<pre>
<?php

// TODO - update to support multi-instance. https://schoolbox.atlassian.net/browse/IST-962

require '../inc/require.php';
echo "\nSAML Token Signing Certificate Expiry Dates (schoolbox production instances)\n\n";

$facts = getFacts('schoolbox_config_saml_idp_signing_cert_expiry');
$array = array();
$array2 = array();

foreach($facts as $server){
        if(isset($_GET['filter']) && $_GET['filter'] != $server['certname']){ break; }
        $datetime = $server['value'];
        $array[$server['certname']] = $datetime;
        if(array_key_exists($datetime,$array2)
            && array_key_exists($server['certname'],$array2[$datetime])
            && in_array("$ip:$port",$array2[$datetime][$server['certname']])){
            break;
        }
        $array2[date("Y-m-d",strtotime($datetime))][] = $server['certname'];
}

ksort($array2);
foreach($array2 as $datetime=>$serverlist){
    echo "\n".$datetime."\n";
    asort($serverlist);
    foreach($serverlist as $server=>$certname){
        echo "\t$certname\n";
    }
}

?>
</pre>
