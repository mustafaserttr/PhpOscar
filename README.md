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

php file content is in "Code" section of Github. 

Don't forget to generate security token in OSCAR - Management - Manage Machine Access before run php code.





