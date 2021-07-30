<html>
<body style="font-family: Inconsolata, courier-new, arial;font-size: 0.9em">
<?php

require '../inc/require.php';

$node = file_get_contents('http://puppet.alaress-dev.com.au:8080/v3/nodes/' . urlencode($_GET['server'] . '/facts'));
$node = json_decode($node);

$fact = array();
foreach($node as $nodefact){
    $fact[$nodefact->name] = $nodefact->value;
//    $jsontest = json_decode(str_replace('{','[',str_replace('}',']',str_replace("=>","=",$nodefact->value))));
//    var_dump(str_replace('{','[',str_replace('}',']',str_replace("=>","=",$nodefact->value))));
//    var_dump($jsontest);
//    if((substr_count($nodefact->value,'[') > 0 OR substr_count($nodefact->value,'{') > 0) AND json_last_error() == JSON_ERROR_NONE){
//        echo "\n".$nodefact->name." : ".$json_last_error."\n";
//        $fact[$nodefact->name] = json_decode($nodefact->value);
//    } else {
//            $fact[$nodefact->name] = $nodefact->value;
//    }
}

/* Cleanup some facts for display */
if(array_key_exists('schoolbox_config_site_hostname',$fact)) {
    $path='';
    if(array_key_exists('schoolbox_config_saml_enabled',$fact) && $fact['schoolbox_config_saml_enabled']=='1'){ $path='?samlAuth=0'; }
    $proto='http';
    if(array_key_exists('https_cert_expiry',$fact)){ $proto='https'; }
    $fact['schoolbox_fqdn'] = $fact['schoolbox_config_site_hostname'].'.'.$fact['schoolbox_config_site_domain'];
    $fact['schoolbox_url'] = $proto.'://'.$fact['schoolbox_config_site_hostname'].'.'.$fact['schoolbox_config_site_domain'].'/login/'.$path;
}
if(array_key_exists('schoolboxdev_config_site_hostname',$fact)) {
    $path='';
    if(array_key_exists('schoolboxdev_config_saml_enabled',$fact) && $fact['schoolboxdev_config_saml_enabled']=='1'){ $path='?samlAuth=0'; }
    $proto='http';
    if(array_key_exists('https_cert_expiry',$fact)){ $proto='https'; }
    $fact['schoolboxdev_fqdn'] = $fact['schoolboxdev_config_site_hostname'].'.'.$fact['schoolboxdev_config_site_domain'];
    $fact['schoolboxdev_url'] = $proto.'://'.$fact['schoolboxdev_config_site_hostname'].'.'.$fact['schoolboxdev_config_site_domain'].'/login/'.$path;
}
ksort($fact);

function display($array, $fact) {
    echo "<p style='font-weight: bold'>".$array['TITLE']."</p>\n";
    foreach($array as $key=>$value){
        if(array_key_exists($key,$fact) && $fact[$key] != '') {
            if(substr_count(strtolower($fact[$key]),'://')>0){
                echo "<span style='font-weight: bold'>".$value.":</span> <a href='".$fact['key']."'>".$fact[$key]."</a><br>\n";
            } else {
                echo "<span style='font-weight: bold'>".$value.":</span> ".$fact[$key]."<br>\n";
            }
        }
    }
    echo "</p>\n";
}

echo "<h2>Server: " . $fact['clientcert'] . "</h3>\n";
echo "<p><a href='https://github.com/alaress/puppet-alaress/blob/master/data/hieradata/" . $fact['clientcert'] . ".yaml'>Puppet Configuration</a><br><br></p>\n";

$serverspecs['TITLE'] = "Server Specs";
$serverspecs['lsbdistdescription'] = 'OS';
$serverspecs['processorcount'] = 'CPU Cores';
$serverspecs['memorysize'] = 'Memory (RAM)';
$serverspecs['ipaddress'] = 'Internal IP';
$serverspecs['virtual'] = 'Hypervisor';
$serverspecs['kernelrelease'] = 'Kernel';
$serverspecs['uptime'] = 'Uptime';
display($serverspecs, $fact);

$monitoring['TITLE'] = "Monitoring";
$monitoring['postfix_queue'] = "Postfix Queue Length";
display($monitoring, $fact);

$servertype['Live'] = '';
$servertype['Dev'] = 'dev';
foreach($servertype as $typekey=>$type) {
    if(array_key_exists('schoolbox'.$type.'_config_site_version',$fact)){
        echo "<h2>Schoolbox ".$typekey." Instance</h2>\n";

        $school['TITLE'] = "School Details";
        $school['schoolbox'.$type.'_config_school_name'] = "School";
        $school['schoolbox'.$type.'_config_school_address'] = "School Website";
        display($school, $fact);
        unset($school);

        $version['TITLE'] = "General Info";
        $version['schoolbox'.$type.'_fqdn'] = 'FQDN';
        $version['schoolbox'.$type.'_url'] = 'URL';
        $version['schoolbox'.$type.'_config_title'] = "Title";
        $version['schoolbox'.$type.'_config_site_version'] = "Release";
        $version['schoolbox'.$type.'_config_external_type'] = "External DB";
        display($version, $fact);
        unset($version);

        $stats['TITLE'] = 'Statistics';
        $stats['schoolbox'.$type.'_totalusers'] = 'Total Users';
        $stats['schoolbox'.$type.'_totalcampus'] = 'Campuses';
        $stats['schoolbox'.$type.'_users_student'] = 'Students';
        $stats['schoolbox'.$type.'_users_staff'] = 'Staff';
        $stats['schoolbox'.$type.'_users_parent'] = 'Parents';
        display($stats, $fact);
        unset($stats);

        $plan['TITLE'] = "Modules";
        $plan['schoolbox'.$type.'_config_boarder_leave_enabled'] = "Leave";
        $plan['schoolbox'.$type.'_config_resource_booking_enabled'] = "Resource Booking";
        $plan['schoolbox'.$type.'_config_due_work_notifications_enabled'] = "Push Notifications";
        $plan['schoolbox'.$type.'_config_crocodoc_api_token'] = "Crocodoc Token";
        $plan['schoolbox'.$type.'_config_plagscan_username'] = "PlagScan Username";
        $plan['schoolbox'.$type.'_config_plagscan_api_key'] = "PlanScan API Key";
        display($plan, $fact);
        unset($plan);
    }
}
//echo "<pre>";
//print_r($fact);
//echo "</pre>";
?>
</body>
</html>
