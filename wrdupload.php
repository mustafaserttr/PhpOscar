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
		
		
        $proxy_server = '192.168.XX.XX:XXXX';   //if proxy server is used
		
        $proxy_user = 'YYY:ZZZZZ';              //proxy user and password  
        
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
