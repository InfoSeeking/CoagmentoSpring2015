<?php
$xmldata = $_POST["xmldata"];
$xml = stripslashes($xml);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_HEADER, 0);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
// curl_setopt($ch, CURLOPT_URL, "http://iris.comminfo.rutgers.edu/index.php?xmldata=");
// curl_setopt($ch, CURLOPT_POST, 1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
// $result=curl_exec($ch);

$url = 'http://iris.comminfo.rutgers.edu/';
$parameters = $xml;
 
$data = array('xmldata' => $parameters);
 
// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($parameters),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
echo $result;

?>