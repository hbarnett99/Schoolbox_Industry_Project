<?php
require '../inc/require.php';

$siteTypesPrd = ['prod','prd'];  // Old + new PRD 'site_type'
$siteTypesStg = ['dev','stg'];   // Old + new STG 'site_type'


echo "<html lang=\"en\">\n";
echo "<head>\n\t<title>Dashboard</title>\n";
echo "</head>\n";
echo "<body>\n";
echo "<pre>";

echo "Note: User totals below only show enabled user accounts\n";

$totalUsersData      = getFacts('schoolbox_totalusers');

// Map each Schoolbox host cert name to a puppet environment [staging|production]
$hostPuppetEnvironments = [];
foreach($totalUsersData as $fact){
    $hostPuppetEnvironments[$fact['certname']] = $fact['environment'];
}

// Map each instanceId to site_type
$instanceSiteTypeMap = [];
foreach(getFacts('schoolbox_config_site_type') as $fact){
    foreach($fact['value'] as $instanceId => $siteType){
        $instanceSiteTypeMap[$instanceId] = $siteType;
    }
}


$totalUserFleetCount = 0;
$totalUserArray      = [];
foreach ($totalUsersData as $server) {
    // Ensure using only production servers
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.')) {
        $value               = is_array($server['value']) ? array_sum($server['value']) : $server['value'];
        $totalUserFleetCount += $value;
        $tempVal             = floor($value / 1000);
        $tempVal             = (string)$tempVal;
        if (!array_key_exists($tempVal, $totalUserArray)) {
            $totalUserArray[$tempVal] = 0;
        }
        $totalUserArray[$tempVal]++;
    }
}
krsort($totalUserArray);
echo "\n<a href='/fact_detail.php?fact=schoolbox_totalusers'>Total Users</a>: $totalUserFleetCount\n";

$totalStudentData      = getFacts('schoolbox_users_student');
$totalStudentFleetCount = 0;
foreach ($totalStudentData as $server) {
    // Ensure using only production servers
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.')) {
        $totalStudentFleetCount += is_array($server['value']) ? array_sum($server['value']) : $server['value'];
    }
}

echo "<a href='/fact_detail.php?fact=schoolbox_users_student'>Total Students</a>: $totalStudentFleetCount\n";

$totalStaffData      = getFacts('schoolbox_users_staff');
$totalStaffFleetCount = 0;
foreach ($totalStaffData as $server) {
    // Ensure using only production servers
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.')) {
        $totalStaffFleetCount += is_array($server['value']) ? array_sum($server['value']) : $server['value'];
    }
}
echo "<a href='/fact_detail.php?fact=schoolbox_users_staff'>Total Staff</a>: $totalStaffFleetCount\n";

$totalParentData      = getFacts('schoolbox_users_parent');
$totalParentFleetCount = 0;
foreach ($totalParentData as $server) {
    // Ensure using only production servers
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.')) {
        $totalParentFleetCount += is_array($server['value']) ? array_sum($server['value']) : $server['value'];
    }
}
echo "<a href='/fact_detail.php?fact=schoolbox_users_parent'>Total Parents</a>: $totalParentFleetCount\n";

$totalCampus      = getFacts('schoolbox_totalcampus');
$totalCampusCount = 0;
foreach ($totalCampus as $server) {
    // Ensure using only production servers
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.')) {
        $totalCampusCount += is_array($server['value']) ? array_sum($server['value']) : $server['value'];
    }
}
echo "<a href='/fact_detail.php?fact=schoolbox_totalcampus'>Total Campus</a>: $totalCampusCount\n";

echo "\nTotal Users Summary\n";
foreach ($totalUserArray as $key => $value) {
    if ($key === 0) {
        $tempDetail = '< 1000';
        $bracket    = '0-1000';
    } else {
        $tempVal    = ($key * 1000);
        $tempDetail = "> $tempVal";
        $bracket    = (($key - 1) * 1000) . '-' . $tempVal;
    }
    echo "\t $tempDetail : $value\n";
}

// Package versions
foreach(['schoolbox','schoolboxdev'] as $package){
    $factName = "{$package}_package_version";
    $schoolboxPackageVersions = getFacts($factName);
    foreach(['staging','production'] as $environment){
        $totalCount = 0;
        $schoolboxPackageVersionCounts = [];
        foreach($schoolboxPackageVersions as $fact){
            if($fact['environment'] === $environment){
                $totalCount++;
                if (!array_key_exists($fact['value'], $schoolboxPackageVersionCounts)) {
                    $schoolboxPackageVersionCounts[$fact['value']] = 0;
                }
                $schoolboxPackageVersionCounts[$fact['value']]++;
            }
        }
        uksort($schoolboxPackageVersionCounts, "version_compare");
        $schoolboxPackageVersionCounts = array_reverse($schoolboxPackageVersionCounts, true);
        echo "\n{$environment} '$package' package versions:\n";
        foreach ($schoolboxPackageVersionCounts as $version => $count) {
            $percent = ' (' . round($count / $totalCount * 100) . '%)';
            $valueFilter = urlencode($version);
            echo "\t<a href='/fact_detail.php?fact=$factName&value=$valueFilter&environment=$environment'>$version</a> : $count\t$percent\n";
        }
    }
}

// Instance Versions
$labelMap = [
    'dev'  => 'stg',
    'prod' => 'prd',
];
foreach(['dev','prod'] as $siteType){
    $factName = 'schoolbox_config_site_version';
    $schoolboxInstanceVersions = getFacts($factName);
    $schoolboxInstanceVersionCounts = [];
    $totalInstanceCount = 0;
    foreach($schoolboxInstanceVersions as $fact){
        foreach($fact['value'] as $instanceId => $value){
            if(!(array_key_exists($instanceId, $instanceSiteTypeMap)) || ($instanceSiteTypeMap[$instanceId] !== $siteType)){
                continue;
            }
            $totalInstanceCount++;
            if (!array_key_exists($value, $schoolboxInstanceVersionCounts)) {
                $schoolboxInstanceVersionCounts[$value] = 0;
            }
            $schoolboxInstanceVersionCounts[$value]++;
        }
    }
    uksort($schoolboxInstanceVersionCounts, "version_compare");
    $schoolboxInstanceVersionCounts = array_reverse($schoolboxInstanceVersionCounts, true);
    echo "\n'$labelMap[$siteType]' instance versions:\n";
    foreach ($schoolboxInstanceVersionCounts as $version => $count) {
        $percent = ' (' . round($count / $totalInstanceCount * 100) . '%)';
        $valueFilter = urlencode($version);
        echo "\t<a href='/fact_detail.php?fact=$factName&value=$valueFilter'>$version</a> : $count\t$percent\n";
    }
}


$virtuals      = getFacts('virtual');
$virtual_array = [];
foreach ($virtuals as $server) {
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.') || stripos($server['certname'], '.dev.') || stripos($server['certname'], '.stg.') || stripos($server['certname'], '.dr.')) {
        if (array_key_exists($server['value'], $virtual_array)) {
            $virtual_array[$server['value']]++;
        } else {
            $virtual_array[$server['value']] = 1;
        }
    }
}
krsort($virtual_array);
unset($virtuals, $server);
echo "\nHosting server types (Schoolbox PRD + STG)\n";
foreach ($virtual_array as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($virtual_array) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=virtual&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($virtual_array, $key, $value);


$linuxtypes     = getFacts('lsbdistdescription');
$linuxTypeArray = [];
foreach ($linuxtypes as $server) {
    if (array_key_exists($server['value'], $linuxTypeArray)) {
        $linuxTypeArray[$server['value']]++;
    } else {
        $linuxTypeArray[$server['value']] = 1;
    }
}
krsort($linuxTypeArray);
unset($linuxtypes, $server);
echo "\nLinux Versions\n";
foreach ($linuxTypeArray as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($linuxTypeArray) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=lsbdistdescription&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($linuxTypeArray, $key, $value);

$kernelVersions     = getFacts('kernelmajversion');
$kernelVersionArray = [];
foreach ($kernelVersions as $server) {
    if (array_key_exists($server['value'], $kernelVersionArray)) {
        $kernelVersionArray[$server['value']]++;
    } else {
        $kernelVersionArray[$server['value']] = 1;
    }
}
krsort($kernelVersionArray, SORT_STRING);
unset($kernelVersions, $server);
echo "\nKernel Major Versions\n";
foreach ($kernelVersionArray as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($kernelVersionArray) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=kernelmajversion&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($kernelVersionArray, $key, $value);

$kernelRelease      = getFacts('kernelrelease');
$kernelReleaseArray = [];
foreach ($kernelRelease as $server) {
    if (array_key_exists($server['value'], $kernelReleaseArray)) {
        $kernelReleaseArray[$server['value']]++;
    } else {
        $kernelReleaseArray[$server['value']] = 1;
    }
}
krsort($kernelReleaseArray, SORT_STRING);
unset($kernelRelease, $server);
echo "\nKernel Release Versions\n";
foreach ($kernelReleaseArray as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($kernelReleaseArray) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=kernelrelease&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($kernelReleaseArray, $key, $value);

$phpVersion      = getFacts('php_cli_version');
$phpVersionArray = [];
foreach ($phpVersion as $server) {
    if (array_key_exists($server['value'], $phpVersionArray)) {
        $phpVersionArray[$server['value']]++;
    } else {
        $phpVersionArray[$server['value']] = 1;
    }
}
arsort($phpVersionArray);
unset($phpVersion, $server);
echo "\nPHP Versions\n";
foreach ($phpVersionArray as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($phpVersionArray) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=php_cli_version&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($phpVersionArray, $key, $value);

$mysqlVersion      = getFacts('mysql_extra_version');
$mysqlVersionAaray = [];
foreach ($mysqlVersion as $server) {
    if (array_key_exists($server['value'], $mysqlVersionAaray)) {
        $mysqlVersionAaray[$server['value']]++;
    } else {
        $mysqlVersionAaray[$server['value']] = 1;
    }
}
arsort($mysqlVersionAaray);
unset($mysqlVersion, $server);
echo "\nMySQL Versions\n";
foreach ($mysqlVersionAaray as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($mysqlVersionAaray) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=mysql_extra_version&value=$valueFilter'>$key</a> : $value\t$pc\n";
}
unset($mysqlVersionAaray, $key, $value);

$processorCounts     = getFacts('processorcount');
$processorCountArray = [];
foreach ($processorCounts as $server) {
    if (array_key_exists($server['value'], $processorCountArray)) {
        $processorCountArray[$server['value']]++;
    } else {
        $processorCountArray[$server['value']] = 1;
    }
}
krsort($processorCountArray);
unset($processorCounts, $server);
echo "\nServers with X number of cores\n";
foreach ($processorCountArray as $key => $value) {
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=processorcount&value=$valueFilter'>$key</a> : $value\n";
}
unset($processorCountArray, $key, $value);

$memorySizes     = getFacts('memorysize');
$memorySizeArray = [];
foreach ($memorySizes as $server) {
    unset($tempVal);
    if (substr_count($server['value'], 'MB') > 0 || substr_count($server['value'], 'MiB') > 0) {
        $tempVal = explode(' ', $server['value']);
        $tempVal = ceil($tempVal[0] / 1024);
    } else {
        $tempVal = explode(' ', $server['value']);
        $tempVal = ceil($tempVal[0]);
    }
    $tempVal = (string)$tempVal;
    if (array_key_exists($tempVal, $memorySizeArray)) {
        $memorySizeArray[$tempVal]++;
    } else {
        $memorySizeArray[$tempVal] = 1;
    }
}
krsort($memorySizeArray);
unset($memorySizes, $server, $tempVal);
echo "\n<a href='/fact_detail.php?fact=memorysize'>Server RAM</a>\n";
foreach ($memorySizeArray as $key => $value) {
    echo "\t$key GB : $value\n";
}
unset($memorySizeArray, $key, $value);

$sbTimezones      = getFacts('schoolbox_config_date_timezone');
$sbTimezone_array = [];
foreach ($sbTimezones as $server) {
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.') || stripos($server['certname'], '.dev.') || stripos($server['certname'], '.stg.') || stripos($server['certname'], '.dr.')) {
        foreach($server['value'] as $instanceId => $value){
            if(!in_array($instanceSiteTypeMap[$instanceId], $siteTypesPrd, true)){
                // Skip non-prod instances
                continue;
            }
            if (!array_key_exists($value, $sbTimezone_array)) {
                $sbTimezone_array[$value] = 0;
            }
            $sbTimezone_array[$value]++;
        }
    }
}
arsort($sbTimezone_array);
unset($sbTimezones, $server);
echo "\n<a href='/fact_detail.php?fact=schoolbox_config_date_timezone'>Production Instance Timezones</a>\n";
foreach ($sbTimezone_array as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($sbTimezone_array) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=schoolbox_config_date_timezone&value=$valueFilter'>$key</a> : $value$pc\n";
}
unset($sbTimezone_array, $key, $value);


$externals      = getFacts('schoolbox_config_external_type');
$external_array = [];
foreach ($externals as $server) {
    if (stripos($server['certname'], '.live.') || stripos($server['certname'], '.prd.') || stripos($server['certname'], '.dev.') || stripos($server['certname'], '.stg.') || stripos($server['certname'], '.dr.')) {
        foreach($server['value'] as $instanceId => $value){
            if(!in_array($instanceSiteTypeMap[$instanceId], $siteTypesPrd, true)){
                // Skip non-prod instances
                continue;
            }
            if (!array_key_exists($value, $external_array)) {
                $external_array[$value] = 0;
            }
            $external_array[$value]++;
        }
    }
}
arsort($external_array);
unset($externals, $server);
echo "\nExternal DB (Production Instances)\n";
foreach ($external_array as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($external_array) * 100) . '%)';
    } else {
        $pc = '';
    }
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=schoolbox_config_external_type&value=$valueFilter'>$key</a> : $value$pc\n";
}
unset($external_array, $key, $value);

$live_update_checks      = getFacts('schoolbox_update_error');
$live_update_check_array = [];
foreach ($live_update_checks as $server) {
    if (stripos($server['certname'], '.schoolbox')) {
        if (array_key_exists($server['value'], $live_update_check_array)) {
            $live_update_check_array[$server['value']]++;
        } else {
            $live_update_check_array[$server['value']] = 1;
        }
    }
}
krsort($live_update_check_array);
unset($live_update_checks, $server);
echo "\nUpdate Checks\n\t('schoolbox' package)\n";
foreach ($live_update_check_array as $key => $value) {
    if ($key == '0') {
        $pretty = 'success';
    } else {
        $pretty = 'error';
    }
    echo "\t<a href='/fact_detail.php?fact=schoolbox_update_errormsg'>$pretty</a> : $value\n";
}
unset($live_update_check_array, $key, $value);

$dev_update_checks      = getFacts('schoolboxdev_update_error');
$dev_update_check_array = [];
foreach ($dev_update_checks as $server) {
    if (stripos($server['certname'], '.schoolbox')) {
        if (array_key_exists($server['value'], $dev_update_check_array)) {
            $dev_update_check_array[$server['value']]++;
        } else {
            $dev_update_check_array[$server['value']] = 1;
        }
    }
}
krsort($dev_update_check_array);
unset($dev_update_checks, $server);
echo "\t('schoolboxdev' package)\n";
foreach ($dev_update_check_array as $key => $value) {
    if ($key == '0') {
        $pretty = 'success';
    } else {
        $pretty = 'error';
    }
    echo "\t<a href='/fact_detail.php?fact=schoolboxdev_update_errormsg'>$pretty</a> : $value\n";
}
unset($dev_update_check_array, $key, $value);


$backups      = getFacts('schoolbox_last_backup');
$backup_array = [];
foreach ($backups as $server) {
    if (stripos($server['certname'], '.schoolbox')) {
        if (array_key_exists($server['value'], $backup_array)) {
            $backup_array[$server['value']]++;
        } else {
            $backup_array[$server['value']] = 1;
        }
    }
}
krsort($backup_array);
unset($backups, $server);
echo "\nBackups (Schoolbox Servers)\n";
foreach ($backup_array as $key => $value) {
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=schoolbox_last_backup&value=$valueFilter'>$key</a> : $value\n";
}
unset($backup_array, $key, $value);

$postfix       = getFacts('postfix_queue');
$postfix_array = [];
foreach ($postfix as $server) {
    if (stripos($server['certname'], '.schoolbox')) {
        if (array_key_exists($server['value'], $postfix_array)) {
            $postfix_array[$server['value']]++;
        } else {
            $postfix_array[$server['value']] = 1;
        }
    }
}
krsort($postfix_array);
unset($postfix, $server);
echo "\n<a href='/fact_detail.php?fact=postfix_queue'>Postfix Queue</a> (Schoolbox Servers)\n";
foreach ($postfix_array as $key => $value) {
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=postfix_queue&value=$valueFilter'>$key</a> : $value\n";
}
unset($postfix_array, $key, $value);

$reportings                 = file_get_contents('http://puppet.alaress-dev.com.au:8080/v3/nodes');
$reportings                 = json_decode($reportings);
$reporting_array            = [];
$reporting_array['online']  = 0;
$reporting_array['offline'] = 0;
$puppetlist                 = [];
$ago                        = strtotime('-3 hour');
foreach ($reportings as $server) {
    $puppetlist[] = $server->name;
    if ($ago > strtotime($server->report_timestamp)) {
        $reporting_array['offline']++;
    } else {
        $reporting_array['online']++;
    }
}
$list   = explode("\n", file_get_contents(WEB_ROOT . '/serverlist')); // TODO replace w/ call to IR
$ignore = [];
foreach ($list as $server) {
    if (trim($server) !== '' && !in_array($server, $ignore) && !in_array($server, $puppetlist)) {
        $reporting_array['offline']++;
    }
}
unset($reportings, $server, $ago, $puppetlist, $list, $ignore, $server);
echo "\nNodes Reporting\n";
foreach ($reporting_array as $key => $value) {
    echo "\t<a href='/nodes_reporting.php?key=$key'>$key</a> : $value\n";
}
unset($reporting_array, $key, $value);

$firstfiles      = getFacts('schoolbox_first_file_upload_year');
$firstfile_array = [];
foreach ($firstfiles as $server) {
    if (stripos($server['certname'], '.live.')) {
        if (str_replace('"', '', $server['value']) === 'NULL') {
            $server['value'] = date('Y');
        }
        if (array_key_exists(str_replace('"', '', $server['value']), $firstfile_array)) {
            $firstfile_array[str_replace('"', '', $server['value'])]++;
        } else {
            $firstfile_array[str_replace('"', '', $server['value'])] = 1;
        }
    }
}
krsort($firstfile_array);
unset($firstfiles, $server);
echo "\nLive Server First File Upload Year\n";
foreach ($firstfile_array as $key => $value) {
    if ($value > 0) {
        $pc = ' (' . round($value / array_sum($firstfile_array) * 100) . '%)';
    } else {
        $pc = '';
    }
    $hashes = str_repeat('#', $value);
    $valueFilter = urlencode($key);
    echo "\t<a href='/fact_detail.php?fact=schoolbox_first_file_upload_year&value=\"$valueFilter\"'>$key</a> : $value\t$pc\t$hashes\n";
}


echo "\n<a href='/fact_detail.php'>Other facts and extended data</a>\n";
echo "<a href='/https_cert_all.php'>HTTPS Certificate Data (All)</a>\n";
echo "<a href='/saml_idp_cert_expiry.php'>SAML Token Signing Certificate Expiry</a>\n";
echo "<a href='/last_report.php'>Failing puppet runs</a>\n";
echo "<a href='/smtp_details.php'>SMTP Details</a>\n";
echo "</pre>";
echo "</body>";
echo "</html>";
