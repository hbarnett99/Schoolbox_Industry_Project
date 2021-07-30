<?php

require '../inc/require.php';

CONST PARAM_SORT = 'sort';
const SORT_SERVER = 'server';
const SORT_PORT = 'port';
const SORT_ISSUER = 'issuer';
const SORT_COMMON = 'common';
const SORT_EXPIRY = 'expiry';

$issuers = getFacts('https_cert_issuer');
$expiries = getFacts('https_cert_expiry');
$array = array();
$array2 = array();
$full = array();

foreach($issuers as $server){
    foreach (explode(',',$server['value']) as $vhost){
        if (substr_count($vhost,':')>1) {
            $vhost_array = explode('localhost:',$server['value']);
            unset($vhost_array[0]);
            foreach($vhost_array as $key=>$cert){
                $port = explode(':',$cert)[0];
                if(substr_count($cert,'O = ')>0){
                    $object = str_replace('"','',explode(',',explode('O = ',$cert)[1])[0]);
                } else { $object = 'unknown'; }
                if(substr_count($cert,'CN = ')>0){
                    $commonname = explode(',',explode('CN = ',$cert)[1])[0];
                } else { $commonname = 'unknown'; }
                $full[$server['certname']][$port]['issuer-string'] = $cert;
                $full[$server['certname']][$port]['O'] = $object;
                $full[$server['certname']][$port]['CN'] = $commonname;
            }
        }
    }
}
foreach($expiries as $server){
    foreach (explode(',',$server['value']) as $vhost){
        if (substr_count($vhost,':')>1) {
            $vhost_array = explode('localhost:',$server['value']);
            unset($vhost_array[0]);
            foreach($vhost_array as $key=>$cert){
                $port = explode(':',$cert)[0];
                $expiry = str_replace(',','',explode($port.':',$cert)[1]);
                $full[$server['certname']][$port]['expiry-string'] = $cert;
                $full[$server['certname']][$port]['expiry'] = $expiry;
                $full[$server['certname']][$port]['expiry-iso8601'] = date('Y-m-d H:i:s',strtotime($expiry));
            }
        }
    }
}

$tableData = [];
foreach ($full as $certName => $server) {
    foreach ($server as $port => $cert) {
        $tableData[] = [
            SORT_SERVER => $certName,
            SORT_PORT   => $port,
            SORT_ISSUER => $cert['O'],
            SORT_COMMON => $cert['CN'],
            $cert['expiry'],
            SORT_EXPIRY => $cert['expiry-iso8601'],
        ];
    }
}

// Did the user specify which column to sort by? And was it valid?
$sortColumn      = array_key_exists(PARAM_SORT, $_GET) ? $_GET[PARAM_SORT] : SORT_SERVER;
$validSortValues = [SORT_SERVER, SORT_PORT, SORT_ISSUER, SORT_COMMON, SORT_EXPIRY];
if (!in_array($sortColumn, $validSortValues, true)) {
    $sortColumn = SORT_SERVER;
}

$sortFunction = static function (array $array1, array $array2) use ($sortColumn) {
    return strnatcasecmp($array1[$sortColumn], $array2[$sortColumn]);
};

usort($tableData, $sortFunction);

// Add colours to expiry column
$now              = new DateTime();
$sevenDays        = new DateTime('7 days');
$thirtyDays       = new DateTime('30 days');
$colourExpired    = 'red';
$colourSevenDays  = 'darkorange';
$colourThirtyDays = 'deeppink';
$colourOk         = 'darkgreen';
foreach ($tableData as $idx => $row) {
    $expiryString = $row[SORT_EXPIRY];
    $expiryDate   = new DateTime($expiryString);
    if ($now->diff($expiryDate)->invert) {
        $expiryIso8601 = "<span style='color:$colourExpired'>$expiryString</span>";
    } elseif ($sevenDays->diff($expiryDate)->invert) {
        $expiryIso8601 = "<span style='color:$colourSevenDays'>$expiryString</span>";
    } elseif ($thirtyDays->diff($expiryDate)->invert) {
        $expiryIso8601 = "<span style='color:$colourThirtyDays'>$expiryString</span>";
    } else {
        $expiryIso8601 = "<span style='color:$colourOk'>$expiryString</span>";;
    }
    $tableData[$idx][SORT_EXPIRY] = $expiryIso8601;
}

?>
<style>
table { border: 1px solid black;  border-collapse: collapse; margin: 0 }
td { border: 1px solid black; margin: 0; padding: 2px; }
th { border: 1px solid black; margin: 0; padding: 2px;}
</style>
<h3>HTTPS Certificate All</h3>
<table>
    <tr><td style="color:<?php echo  $colourExpired; ?>">Expired</td></tr>
    <tr><td style="color:<?php echo  $colourSevenDays; ?>">Expire in < 7 days</td></tr>
    <tr><td style="color:<?php echo  $colourThirtyDays; ?>">Expire in < 30 days</td></tr>
    <tr><td style="color:<?php echo  $colourOk; ?>">Expire in > 30 days</td></tr>
</table>
    <p>Click a column title to sort by that column</p>
<?php

echo "<table>\n";
echo "<tr>
        <th><a href='?".PARAM_SORT.'='.SORT_SERVER."'>Server</a></th>
        <th><a href='?".PARAM_SORT.'='.SORT_PORT."'>Port</a></th>
        <th><a href='?".PARAM_SORT.'='.SORT_ISSUER."'>Issuer (Object)</a></th>
        <th><a href='?".PARAM_SORT.'='.SORT_COMMON."'>Issuer (CommonName)</a></th>
        <th>Expiry</th>
        <th><a href='?".PARAM_SORT.'='.SORT_EXPIRY."'>Expiry (ISO8601)</a></th>
      </tr>\n";
foreach($tableData as $row){
    echo "<tr>\n";
    foreach($row as $column){
        echo "\t<td>".$column."</td>\n";
    }
    echo "</tr>\n";
}
echo "\n</table>";
