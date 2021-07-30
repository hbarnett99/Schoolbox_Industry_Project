<pre>
<?php

require '../inc/require.php';

if ($_GET['key'] !== "online" && $_GET['key'] !== "offline") {
    echo "No valid key provided\n";
}

echo "\nNodes Reporting: " . $_GET['key'] . "\n\n";

$reportings      = file_get_contents('http://puppet.alaress-dev.com.au:8080/v3/nodes');
$reportings      = json_decode($reportings);
$reporting_array = [];
$puppetlist      = [];

$ago = strtotime('-3 hours');
foreach ($reportings as $server) {
    $puppetlist[] = $server->name;
    if ($ago > strtotime($server->report_timestamp) && $_GET['key'] === 'offline') {
        $reporting_array[strtotime($server->report_timestamp)] = $server->name;
    } elseif ($ago <= strtotime($server->report_timestamp) && $_GET['key'] === 'online') {
        $reporting_array[strtotime($server->report_timestamp)] = $server->name;
    }
}

$list   = explode("\n", file_get_contents(WEB_ROOT . '/serverlist')); // TODO replace w/ call to IR
$ignore = [];
foreach ($list as $server) {
    if (trim($server) != '' && !in_array($server, $ignore)) {
        if (!in_array($server, $puppetlist) && $_GET['key'] === 'offline') {
            $reporting_array['offline - ' . time() . rand()] = $server;
        }
    }
}

if ($_GET['key'] === 'offline') {
    ksort($reporting_array);
} else {
    krsort($reporting_array);
}
foreach ($reporting_array as $key => $value) {
    if (substr($key, 0, 7) === 'offline') {
        echo $value, " : offline\n";
    } else {
        echo $value . " : " . date('Y-m-d H:i:s', $key) . "\n";
    }
}
?>
<pre>
