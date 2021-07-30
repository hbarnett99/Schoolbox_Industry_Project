<?php
require '../inc/require.php';

switch ($_GET['type']) {
    case 'schoolbox':
    case 'schoolboxdev':
        break;
    default:
        echo "Error: Unable to determine type.\n";
        exit;
}

$_GET['version'] = trim($_GET['version']);

if ($_GET['version'] === '') {
    echo "Error: Unable to determine version.\n";
    exit;
}


$servers = getFacts($_GET['type'] . '_config_site_version', $_GET['version']);
$array   = [];

if (array_key_exists('json', $_GET) && $_GET['json'] !== '') {
    header('Content-Type: application/json');
    echo json_encode($servers);
    exit;
}

foreach ($servers as $server) {
    $array[] = $server['certname'];
}
sort($array);
echo '<pre>';
echo "\n" . ucfirst($_GET['type']) . " servers of version: " . $_GET['version'] . "\n\n";
foreach ($array as $server) {
    echo "$server\n";
}

echo "\nTotal servers: " . count($array) . "\n";
