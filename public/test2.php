<?php

require '../inc/require.php';

$reportings = file_get_contents('http://puppet.alaress-dev.com.au:8080/v3/nodes');
$reportings = json_decode($reportings);
$reporting_array = array();
$reporting_array['online'] = 0;
$reporting_array['offline'] = 0;
$ago = strtotime('-1 day');
foreach($reportings as $server){
	if ( $ago > strtotime($server->report_timestamp) ){
		$reporting_array['offline']++;
	} else {
		$reporting_array['online']++;
	}
}

print_r($reporting_array);

unset($reportings,$server,$ago);
echo "\n<a href='http://puppet.alaress-dev.com.au:8080/v3/nodes'>Nodes Reporting</a>\n";
foreach($reporting_array as $key=>$value){
	echo "\t<a href='/nodes_reporting.php?key=$key'>$key</a> : $value\n";
//	$sql->query("INSERT INTO data VALUES(0, NOW(), 'Nodes Reporting', '$key', $value)");
//	$lsr['reporting#'.$key] = $value;
}
unset($reporting_array,$key,$value);
