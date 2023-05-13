<?php
 
$ch = curl_init();

//curl_setopt($ch, CURLOPT_URL, 'http://154.66.13.182:8086/stsvend/QueryTx.xml');

//smile
//curl_setopt($ch, CURLOPT_URL, 'http://154.66.13.182:8080/stsvend/QueryTx.xml');


//spectranet
curl_setopt($ch, CURLOPT_URL, 'http://154.118.38.152:8080/stsvend/QueryTx.xml');

//Spectranet Static IP
//curl_setopt($ch, CURLOPT_URL, 'http://154.118.38.152:8080/stsvend/QueryTx.xml');

// curl_setopt($ch, CURLOPT_URL, 'http://192.168.1.4:80/stsvend/QueryTx.xml');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
else
{
	
	
	
$doc = new DOMDocument;
$doc->loadXML($result);

	 $xml=simplexml_load_string($result);
	$value = $xml->txCredit;
	
	
	echo $value;
	//echo number_format($value, 2);
	
	
	
}
curl_close($ch);
												?>