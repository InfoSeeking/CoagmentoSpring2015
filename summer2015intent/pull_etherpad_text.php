<?php
	require_once('core/Connection.class.php');
    
    
    $apikey = "857212484544558872d773276b65eba2d916510f2022c613e5e4517cc57d863c";
    $port = 9000;
    
    
    
    
    $connection = Connection::getInstance();
    $query = "SELECT * FROM users GROUP BY projectID";
    $results = $connection->commit($query);
    while($line = mysql_fetch_array($results,MYSQL_ASSOC)){
        $projectID = $line['projectID'];
        $padID = "spring2015_report-$projectID-70-2";
        $url = "http://coagmentopad.rutgers.edu:".$port."/api/1/getText?apikey=".$apikey."&padID=".$padID;
        $data=file_get_contents($url);
        $data_str = $data;
        $data=json_decode($data);
        $valid = ($data->{'code'} == 0);
        if($valid){
            $data = addslashes($data->{'data'}->{'text'});
            $text = str_replace("\r","",$text);
            $text = str_replace("\n","",$text);
            $text = str_replace("\r\n","",$text);
            $text = str_replace("*","",$text);
            $query = "INSERT INTO etherpad_submissions (projectID,pad_text) VALUES ('$projectID','$data')";
            $r = $connection->commit($query);
        }
    }
    
    echo "Done!";
    
?>








