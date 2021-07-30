<?php
require '../inc/require.php';

$validKeys = ['label', 'sort'];

const SORT_BY_VALUE = 'value';
const SORT_BY_REVERSE_VALUE = 'reverse-value';
const SORT_BY_CERT_NAME = 'cert';
$validSorts = [SORT_BY_VALUE, SORT_BY_REVERSE_VALUE, SORT_BY_CERT_NAME];

/*
name => [         // fact name
    label,        // human readable label
    sort,         // how to sort this fact
]
 */

$knownFacts = [

    'ipaddress' => ['label' => ''],
    'schoolbox_config_site_school_code'                          => ['label' => 'Schoolbox config site_school_code - Unique client identifier'],
    // We want to just aggregate this. If we want to distinguish live/dev we should add an extra GET filter
    'schoolbox_instance_id'                                      => ['label' => 'Schoolbox INSTANCE_ID - Unique instance/tenant identifier'],
//    'schoolbox_instance_sql_host'                                => ['label' => ''],
//    'schoolbox_instance_sql_schema'                              => ['label' => ''],
//    'schoolbox_instance_sql_user'                                => ['label' => ''],
//    'schoolbox_instance_sql_pass'                                => ['label' => ''],
    'schoolboxdev_instance_id'                                   => ['label' => 'Schoolbox INSTANCE_ID - Unique instance/tenant identifier'],
//    'schoolboxdev_instance_sql_host'                             => ['label' => ''],
//    'schoolboxdev_instance_sql_schema'                           => ['label' => ''],
//    'schoolboxdev_instance_sql_user'                             => ['label' => ''],
//    'schoolboxdev_instance_sql_pass'                             => ['label' => ''],
    'schoolbox_last_backup'                                      => ['label' => 'last backup'],
    'schoolbox_config_external_type'                             => ['label' => 'external db'],
    'schoolbox_config_date_timezone'                             => ['label' => 'timezone'],
    'schoolbox_config_site_version'                              => ['label' => 'schoolbox version'],
    'memorysize'                                                 => ['label' => 'RAM size'],
    'virtual'                                                    => ['label' => 'host server type'],
    'schoolbox_totalusers'                                       => ['label' => 'total schoolbox users', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_users_student'                                    => ['label' => 'total schoolbox student users', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_users_staff'                                      => ['label' => 'total schoolbox staff users', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_users_parent'                                     => ['label' => 'total schoolbox parent users', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_totalcampus'                                      => ['label' => 'schoolbox campuses'],
    'processorcount'                                             => ['label' => 'number of cpu cores', 'sort' => SORT_BY_REVERSE_VALUE],
    'hardwareisa'                                                => ['label' => '32bit or 64bit'],
    'lsbdistdescription'                                         => ['label' => 'server operating system version'],
    'rabbitmq_queues'                                            => ['label' => 'rabbitmq total queues'],
    'rabbitmq_messages'                                          => ['label' => 'rabbitmq total messages'],
    'schoolbox_rmq_queues'                                       => ['label' => 'schoolbox total queues', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_rmq_msg_total'                                    => ['label' => 'schoolbox total messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_rmq_msg_unread'                                   => ['label' => 'schoolbox total unread messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_rmq_msg_tosort'                                   => ['label' => 'schoolbox total tosort messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_rmq_msg_other'                                    => ['label' => 'schoolbox total other messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_rmq_queues'                                    => ['label' => 'schoolboxdev total queues', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_rmq_msg_total'                                 => ['label' => 'schoolboxdev total messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_rmq_msg_unread'                                => ['label' => 'schoolboxdev total unread messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_rmq_msg_tosort'                                => ['label' => 'schoolboxdev total tosort messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_rmq_msg_other'                                 => ['label' => 'schoolboxdev total other messages', 'sort' => SORT_BY_REVERSE_VALUE],
    'https_cert_expiry'                                          => ['label' => 'https certificate expiry date'],
    'https_cert_type'                                            => ['label' => 'https certificate signing algorithm'],
    'https_cert_issuer'                                          => ['label' => 'https certificate issuer'],
    'ignore_rabbitmq'                                            => ['label' => 'servers with ignore rabbitmq config set'],
    'current_puppetmaster'                                       => ['label' => 'current puppetmaster for each server', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_config_amqp_admin_port'                           => [],
    'schoolbox_config_amqp_host'                                 => [],
//    'schoolbox_config_amqp_pass'                                 => [],
    'schoolbox_config_amqp_port'                                 => [],
    'schoolbox_config_amqp_stomp_port'                           => [],
    'schoolbox_config_amqp_user'                                 => [],
    'schoolbox_config_amqp_vhost'                                => [],
    'schoolbox_config_browser_cache_image_timeout'               => [],
    'schoolbox_config_browser_cache_portrait_timeout'            => [],
    'schoolbox_config_jwt_public_key'                            => ['label' => 'JWT Public Key'],
    'schoolbox_config_title'                                     => ['label' => 'Title of Schoolbox install', 'sort' => SORT_BY_VALUE],
    'schoolbox_config_mail_address'                              => ['label' => 'Schoolbox Client email domain'],
    'schoolbox_config_saml_enabled'                              => ['label' => 'Schoolbox SAML enabled', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_config_saml_sso_url'                              => ['label' => 'Schoolbox SAML Server URLs'],
    'schoolbox_config_saml_logout_url'                           => ['label' => 'Schoolbox SAML Server Logout URLs'],
    'schoolbox_config_skin_custom_css'                           => [],
    'schoolbox_config_external_db_host'                          => ['label' => 'Schoolbox External DB Hosts'],
    'schoolbox_config_external_cache_timeout'                    => ['label' => 'Schoolbox External DB Cache Timeout in seconds', 'sort' => SORT_BY_VALUE],
    'schoolbox_update_error'                                     => ['label' => "'schoolbox' package Update Error State", 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_update_errormsg'                                  => ['label' => "'schoolbox' package Update Error State", 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolboxdev_update_error'                                  => ['label' => "'schoolboxdev' Update Error Messages"],
    'schoolboxdev_update_errormsg'                               => ['label' => "'schoolboxdev' Update Error Messages"],
    'tmpdir_size'                                                => ['label' => 'Temp Directory Size', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_uniqueusername'                                   => ['label' => 'Schoolbox Servers with non-unique usernames'],
    'postfix_queue'                                              => ['label' => 'postfix local relay queue length', 'sort' => SORT_BY_REVERSE_VALUE],
    'postfix_error'                                              => ['label' => 'postfix local relay most common error'],
    'plagscan_last_error_date'                                   => ['label' => 'Plagscan Last Error Date (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'plagscan_last_error_msg'                                    => ['label' => 'Plagscan Last Error Message (schoolbox)'],
    'plagscan_today_error_count'                                 => ['label' => 'Plagscan Today\'s Error Count (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
//    'schoolbox_config_plagscan_api_key'                          => ['label' => 'PlagScan API Key (schoolbox)'],
    'schoolbox_config_plagscan_username'                         => ['label' => 'PlagScan Username (schoolbox)'],
    'schoolbox_config_plagscan_client_id'                        => ['label' => 'PlagScan Client ID (schoolbox)'],
    'schoolbox_notif_scheduled_last_error_date'                  => ['label' => 'Scheduled Last Error Date (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_scheduled_last_error_msg'                   => ['label' => 'Scheduled Last Error Message (schoolbox)'],
    'schoolbox_notif_scheduled_today_error_count'                => ['label' => 'Scheduled Today\'s Error Count (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_socketd_last_error_date'                    => ['label' => 'Socketd Last Error Date (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_socketd_last_error_msg'                     => ['label' => 'Socketd Last Error Message (schoolbox)'],
    'schoolbox_notif_socketd_today_error_count'                  => ['label' => 'Socketd Today\'s Error Count (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_rerouted_last_error_date'                   => ['label' => 'Rerouted Last Error Date (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_rerouted_last_error_msg'                    => ['label' => 'Rerouted Last Error Message (schoolbox)'],
    'schoolbox_notif_rerouted_today_error_count'                 => ['label' => 'Rerouted Today\'s Error Count (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_digestd_last_error_date'                    => ['label' => 'Digestd Last Error Date (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_notif_digestd_last_error_msg'                     => ['label' => 'Digestd Last Error Message (schoolbox)'],
    'schoolbox_notif_digestd_today_error_count'                  => ['label' => 'Digestd Today\'s Error Count (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
//    'schoolbox_config_weather_api_key'                           => ['label' => 'Weather (Wunderground) API Key (schoolbox)', 'sort' => SORT_BY_VALUE],
    'schoolbox_gc_missing_task_files'                            => ['label' => 'schoolbox_gc_missing_task_files (schoolbox)', 'sort' => SORT_BY_REVERSE_VALUE],
    'mysql_extra_mycnf_sha1'                                     => ['label' => 'MySQL my.cnf sha1 hash', 'sort' => SORT_BY_VALUE],
    'mysql_extra_bind_address'                                   => ['label' => 'MySQL bind address'],
    'mysql_extra_version'                                        => ['label' => 'MySQL version'],
    'kernelmajversion'                                           => ['label' => 'Linux Kernel Version', 'sort' => SORT_BY_VALUE],
    'kernelrelease'                                              => ['label' => 'Linux Release Version', 'sort' => SORT_BY_VALUE],
    'schoolbox_config_protect_student_photo'                     => ['label' => 'Schoolbox Config - Protect Student Photos', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_config_protect_teacher_photo'                     => ['label' => 'Schoolbox Config - Protect Teacher Photos', 'sort' => SORT_BY_REVERSE_VALUE],
    'php_cli_version'                                            => ['label' => 'PHP Version', 'sort' => SORT_BY_VALUE],
    'schoolbox_config_proxy_host'                                => ['label' => 'Schoolbox Config - Proxy Host setup'],
    'schoolbox_futureactiveterms'                                => [
        'label' => 'Schoolbox Terms - Number of Current or Future Configured Terms',
        'sort'  => SORT_BY_REVERSE_VALUE,
    ],
    'schoolbox_config_site_location'                             => ['label' => 'Site Location in Schoolbox', 'sort' => SORT_BY_VALUE],
    'schoolbox_cron_has_gc_enabled'                              => [
        'label' => 'Servers that have gc enabled in /etc/crontab will be greater than zero',
        'sort'  => SORT_BY_REVERSE_VALUE,
    ],
    'schoolbox_media_pending'                                    => ['label' => 'Schoolbox Media Queue: Pending', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_media_processing'                                 => ['label' => 'Schoolbox Media Queue: Processing', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_media_completed'                                  => ['label' => 'Schoolbox Media Queue: Completed', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_media_failed'                                     => ['label' => 'Schoolbox Media Queue: Failed', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_media_failed_timeout'                             => ['label' => 'Schoolbox Media Queue: Failed due to Time Out', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_media_failed_latest'                              => ['label' => 'Schoolbox Media Queue: Failed with latest ffmpeg', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_config_external_attendance'                       => ['label' => 'Schoolbox Config - Attendance enabled', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_config_mail_smtp_host'                            => ['label' => 'Schoolbox Config - SMTP Server'],
//    'schoolbox_config_googleapps_api_key'                        => ['label' => 'Schoolbox Config - Google Apps API Key'],
    'schoolbox_config_external_synergetic_student_contact_types' => [
        'label' => 'Schoolbox Config - Synergetic Student Contact Types',
        'sort'  => SORT_BY_REVERSE_VALUE,
    ],
    'schoolbox_config_cyberhound_api_url'                        => ['label' => 'Schoolbox Config - Cyberhound API URL'],
//    'schoolbox_config_schoolbox_help_access_token'               => ['label' => 'Schoolbox Config - Help Access Token'],
    'schoolbox_config_otfs_adapter'               => [
        'label' => 'Schoolbox Config - otfs_adapter',
    ],
    'schoolbox_first_file_upload_year'                           => ['label' => 'Schoolbox - Year of first file upload', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_first_file_upload_date'                           => ['label' => 'Schoolbox - Date of first file upload', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_plagscan_docs_total_currentyear'                  => ['label' => 'Schoolbox - Total Plagscan Documents for the Current Year'],
    'schoolbox_plagscan_docs_total'                              => ['label' => 'Schoolbox - Total Plagscan Documents'],
    'curl_processes'                                             => ['label' => 'Total number of current curl processes', 'sort' => SORT_BY_REVERSE_VALUE],
    'schoolbox_mysql_autoincrement_count_checked'                => [],
    'schoolbox_mysql_autoincrement_count_invalid'                => [],
];

// Check our data structure
foreach ($knownFacts as $factName => $knownFact) {
    $invalidKeys = array_diff(array_keys($knownFact), $validKeys);
    if ($invalidKeys) {
        trigger_error("Invalid fact keys detected. Fact: '$factName' " . implode(',', $invalidKeys), E_USER_WARNING);
    }
}

$factName = array_key_exists('fact', $_GET) ? $_GET['fact'] : '';
if ($factName === '') {
    echo "<pre>Please choose from the options below.\n\n";
    ksort($knownFacts);
    foreach ($knownFacts as $factName => $knownFact) {
        echo "<a href='?fact=$factName'>$factName</a>\n";
    }
    exit;
}
if (array_key_exists($factName, $knownFacts)){
    $fact        = $knownFacts[$factName];
    $label       = array_key_exists('label', $fact) ? $fact['label'] : "No label for '$factName'";
    $sort        = array_key_exists('sort', $fact) ? $fact['sort'] : SORT_BY_CERT_NAME;
} else {
    $label       = $factName;
    $sort        = SORT_BY_CERT_NAME;
}
if(array_key_exists('sort', $_GET) && in_array($_GET['sort'], $validSorts, true)){
    $sort = $_GET['sort'];
}

// If provided, just show a list of certs (and optionally instanceId) that match this value and/or environment
$valueFilter       = array_key_exists('value', $_GET) ? trim($_GET['value']) : '';
$environmentFilter = array_key_exists('environment', $_GET) ? trim($_GET['environment']) : '';

$factValues = getFacts($factName, $valueFilter, $environmentFilter);

# Dump all data as JSON if requested
if (array_key_exists('json', $_GET)) {
    header('Content-Type: application/json');
    echo json_encode($factValues);
    exit;
}

echo '
<style>
* { font-family: monospace; }
table { border: 1px solid black;  border-collapse: collapse; margin: 0 }
th,td { border: 1px solid black; margin: 0; padding: 2px; vertical-align: top; }
</style>
';

echo "<h2><a href='/'>Home</a> > <a href='/fact_detail.php'>Fact List</a> > Servers for fact: $label</h2>\n";
if($valueFilter){
    echo "<h3>value = '$valueFilter'</h3>\n";
}
if($environmentFilter){
    echo "<h3>environment = '$environmentFilter'</h3>\n";
}
$certNameValues = [];
foreach ($factValues as $serverFactValue) {
    $certNameValues[$serverFactValue['certname']] = $serverFactValue['value'];
}


// If instance-specific, use that as primary key
$data = [];
$isInstanceSpecific =
    strpos($factName, 'schoolbox_config_') === 0 ||
    strpos($factName, 'schoolbox_users_') === 0 ||
    strpos($factName, 'schoolbox_media_') === 0 ||
    $factName === 'schoolbox_totalusers' ||
    $factName === 'schoolbox_totalcampus';
if($isInstanceSpecific){
    foreach ($certNameValues as $certName => $values) {
        foreach($values as $instanceId => $value){
            if(!array_key_exists($instanceId, $data)){
                $data[$instanceId] = [[],[]];
            }
            $data[$instanceId][0][] = $certName;
            $data[$instanceId][1][] = $value;
        }
    }
    foreach($data as $instanceId => list($certs, $values)){
        $data[$instanceId] = [implode(',', $certs), implode(',', array_unique($values)),];
    }
    if ($valueFilter === '') {
        if (in_array($sort, [SORT_BY_VALUE, SORT_BY_REVERSE_VALUE], true)){
            uasort($data, static function(array $left, array $right) use ($sort){
                return strnatcasecmp($left[1], $right[1]) * ($sort === SORT_BY_VALUE ? 1 : -1);
            });
        }
    } else {
        ksort($data); // sort by instanceId
    }
} else {
    ksort($certNameValues);
    if ($valueFilter === '') {
        if ($sort === SORT_BY_REVERSE_VALUE) {
            arsort($certNameValues);
        } elseif ($sort === SORT_BY_VALUE) {
            asort($certNameValues);
        }
    }
    foreach ($certNameValues as $certName => $value) {
        $data[$certName] = [is_array($value) ? json_encode($value) : $value];
    }

}

// Render it out
echo "<table>\n";
echo "<tr>\n";
if($isInstanceSpecific){
    echo "<th>Instance Id</th>";
}
echo "<th><a href='?fact=$factName&sort=".SORT_BY_CERT_NAME."'>Cert Name</a></th>";
if ($valueFilter === '') {
    echo "<th><a href='?fact=$factName&sort=" . ($sort === SORT_BY_VALUE ? SORT_BY_REVERSE_VALUE : SORT_BY_VALUE) . "'>Fact Value</a></th>\n";
}
echo "<tr>\n";

foreach($data as $idx => $row){
    echo "<tr>\n";
    echo "<td>$idx</td>";
    if($valueFilter){
        array_pop($row);
    }
    foreach($row as $value){
        echo "<td>$value</td>";
    }
    echo "<tr>\n";
}

echo "</table>\n";

echo "\n<pre>Total servers: " . count($certNameValues) . "\n";
if($isInstanceSpecific){
    echo "\n<pre>Total instances: " . count($data) . "\n";
}

