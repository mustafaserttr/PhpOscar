# PhpOscar
Php Code for uploading XML to WMO OSCAR
This PHP code can use as example for uploading their own XML to OSCAR Surface portal.
This upload example runs on Windows 10 Professional but can be adopt to Linux environment. 

REQUIREMENTS:
1. Download and install Xampp for Apache Web App. Server (for Windows 7.3.26, 7.4.14 & 8.0.1) https://www.apachefriends.org/download.html 
2. Download  Codeignater and copy it in c:\xampp\ci directory (CodeIgniter 3.1.11)  https://codeigniter.com/download
3. Download and install Java SDK if not installed before https://www.oracle.com/java/technologies/javase-jdk11-downloads.html#license-lightbox 
4. Download Apache NetBeans 12 feature update 1 (NB 12.2) - Apache-NetBeans-12.2-bin-windows-x64.exe (SHA-512, PGP ASC)         https://ftp.itu.edu.tr/Mirror/Apache/netbeans/netbeans/12.2/Apache-NetBeans-12.2-bin-windows-x64.exe
5. Download NetBeans plugin for CodeIgniter https://github.com/nbphpcouncil/nb-ci-plugin/releases/download/v0.6.0/org-nbphpcouncil-modules-php-ci-0.6.0.nbm ,  
   https://github.com/nbphpcouncil/nb-ci-plugin/releases/download/v0.6.0/org-nbphpcouncil-modules-php-ci-repository-0.6.0.nbm
   
CONFIGURATION;
1. Create directory named "wrd" under C:\xampp\htdocs
2. Copy codeigniter application and system directories and index.php file into wrd. (from C:\xampp\ci\bcit-ci-CodeIgniter-b73eb19\)
3. Create log directory in C:\xampp\htdocs\wrd\ for logging messages.
4. In C:\xampp\htdocs\wrd\application\config\config.php file, set rows like below;

	$config['base_url'] = 'http://localhost/wrd/';
        
	$config['index_page'] = '';
        
	$config['log_threshold'] = 1;
        
	$config['log_path'] = ''log/; 
        
5. Create .htaccess file in C:\xampp\htdocs\wrd\  and set rows in below;  

	<IfModule mod_rewrite.c>
	
	RewriteEngine On

	RewriteCond %{REQUEST_FILENAME} !-f

	RewriteCond %{REQUEST_FILENAME} !-d

	RewriteRule ^(.*)$ index.php/$1 [L]

	</IfModule>

6. Create a php file wrd.php under C:\xampp\htdocs\wrd\application\controllers\ directory.
This file will upload your XML file to OSCAR.

Don't forget to generate security token in OSCAR - Management - Manage Machine Access before run php code.

wrd.php ;

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wrd extends CI_Controller {

	function __construct() {
        parent::__construct();
    }

    function index() {
        
    }

    function Upload() {
        
		$this->load->helper('url');
		$this->load->helper('file');
		
		
        $proxy_server = '192.168.X.X:XXXX';	//if you use proxy server
        $proxy_user = 'xxx:yyyyy';           //set proxy user and password 
        
        $token='759e2db7-1c97-4660-819c-fd88f0903c89';        
        $url = "https://oscardepl.wmo.int/surface/rest/api/wmd/upload";
        
        $headers = [
            'X-Apple-Tz: 0',
            'X-Apple-Store-Front: 143444,12',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            'X-WMO-WMDR-Token: ' . $token
        ];

        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_PROXY, $proxy_server);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		// VALID sample start 
		echo "<h1>VALID Sample</h1>";
		$xmlFile = base_url() . 'xml/Valid.xml';
        $contents = read_file($xmlFile);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $contents);
        $result = curl_exec($ch);

		$jsonv = json_decode($result);
		foreach ($jsonv as $key => $value) {
			echo $key . ": " . $value . "<br><br>";
		}
        // VALID sample end		
		
		
		// rejected sample start 
		$xmlFile = base_url() . 'xml/Sample.xml';
        $contents = read_file($xmlFile);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $contents);
        $result = curl_exec($ch);

		//var_dump($ch);
		//echo "<br>*************************************************************************************************************************************************************<br>";
		///var_dump($result);
		
		echo "<h1>REJECTED Sample</h1>";
		
		$json = json_decode($result);
		foreach ($json as $key => $value) {
			echo $key . ": " . $value . "<br><br>";
		}
        // rejected sample end

		
		

		


		if (!curl_errno($ch)) {
			//$info = curl_getinfo($ch);
			write_file(base_url() . 'log/err.' . date('Ymd') . '.log', date('Y-m-d H:i:s') .'-'. $result . "\n", 'a+');
		} else {
			//$info = curl_getinfo($ch);
			write_file(base_url() . 'log/inf.' . date('Ymd') . '.log', date('Y-m-d H:i:s') .'-'. $result . "\n", 'a+');
		}
	
        curl_close($ch);
        
    }
	
}






