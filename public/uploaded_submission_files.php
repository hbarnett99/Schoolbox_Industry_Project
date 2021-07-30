<pre>
<?php
require '../inc/require.php';
echo "\nSchoolbox - Submissions uploaded to external service (crocodoc)\n\n";

$servers = getFacts('schoolbox_uploaded_submission_check');
$array = array();
$array2 = array();
$array3 = array();
$array4 = array();

//print_r($servers);

foreach($servers as $server){
    if (substr_count(".dr.",$server['certname']) > 0 ) {
        break;
    }
    $array3[] = $server['certname'];
    foreach (explode(',',str_replace('"','',$server['value'])) as $uploadcheck){
        if (substr_count($uploadcheck,':')<2) { break; }
        $upload_array = explode(':',$uploadcheck);
        $yearmonth = $upload_array[0].' '.str_pad($upload_array[1],2,'0',STR_PAD_LEFT);
        $result = $upload_array[2];
        if (array_key_exists($yearmonth,$array)) {
            $array[$yearmonth] += $result;
        } else {
            $array[$yearmonth] = $result;
        }
        if (array_key_exists($upload_array[0],$array2)) {
            $array2[$upload_array[0]] += $result;
        } else {
            $array2[$upload_array[0]] = $result;
        }
        if (array_key_exists($server['certname'],$array4)) {
            $array4[$server['certname']] += $result;
        } else {
            $array4[$server['certname']] = $result;
        }
    }
}

echo "Year Month Total\n";
krsort($array);
foreach ($array as $id=>$result) {
    echo "$id $result\n";
}

echo "\nYear Total\n";

krsort($array2);
foreach ($array2 as $id=>$result) {
    echo "$id $result\n";
}

echo "\nServers included: ".count($array3)."\n";

echo "\nServer Total\n";

arsort($array4);
foreach ($array4 as $id=>$result) {
    echo "$id $result\n";
}
?>
</pre>
