<pre>
<?php
/*if($_GET['key'] != "online" && $_GET['key'] != "offline"){
    echo "No valid key provided\n";
}*/

// TODO, not working, both endpoints are returning empty result sets

require '../inc/require.php';

echo "\nFailed Last Reports\n\n";

$test = puppetdb4_query('http://puppet.alaress.com.au:8080', 'events', urlencode('["and", ["=", "latest-report?", true],["=", "status", "failure"]]'));
var_dump($test);
$test = puppetdb4_query('http://puppet.alaress.com.au:8080', 'reports', '');
var_dump($test);

$reportings = file_get_contents('http://puppet.alaress-dev.com.au:8080/v3/events?query=' . urlencode('["and", ["=", "latest-report?", true],["=", "status", "failure"]]'));
$reportings = json_decode($reportings);

var_dump($reportings);

$reporting_array = [];
foreach ($reportings as $report) {
    $reporting_array[$report->certname][$report->timestamp] = $report;
}

ksort($reporting_array);
foreach ($reporting_array as $key => $value) {
    krsort($reporting_array[$key]);
}

//print_r($reporting_array);
/*$reporting_array = array();
$ago = strtotime('-1 day');
foreach($reportings as $server){
    if ( $ago > strtotime($server->report_timestamp) && $_GET['key']=='offline'){
        $reporting_array[strtotime($server->report_timestamp)] = $server->name;
    } elseif ($ago <= strtotime($server->report_timestamp) && $_GET['key'] == 'online') {
        $reporting_array[strtotime($server->report_timestamp)] = $server->name;
    }
}
if($_GET['key']=='offline'){
    ksort($reporting_array);
} else {
    krsort($reporting_array);
}
*/
foreach ($reporting_array as $key => $value) {
    echo "-------------------------------------------------------------\n";
    echo "\n" . $key . ": " . count($value) . "\n";
    foreach ($value as $key2 => $value2) {
        echo "\n";
        echo $key2 . ": failed\t" . $value2->file . "\t" . $value2->line . "\n\t" . $value2->message;
        echo "\n";
    }
}
?>
<pre>
