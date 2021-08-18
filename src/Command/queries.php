<?php
    /*
     * queries.php
     *
     * Written by Dane Rainbird (drai0001@student.monash.edu)
     * Last edited 18/08/2021
     *
     * Performs business / data manipulation on results from a given query to the PuppetDB
     *
     */

    function schoolbox_totalusers($results) : array {
    $totalUserFleetCount = 0;
    $totalUsers = [];
    foreach ($results as $server) {
        foreach ($server as $individualServer) {
            // Ensure only using production servers
            if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                // Increase the total user count
                $value = is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                $totalUserFleetCount += $value;

                $tempVal = strval(floor($value / 1000));

                // Create the totalUsersArray
                if (!array_key_exists($tempVal, $totalUsers)) {
                    $totalUsers[$tempVal] = 0;
                }
                $totalUsers[$tempVal]++;
            }
        }
    }

    return [
        'totalUsersFleetCount' => $totalUserFleetCount,
        'totalUsers' => $totalUsers
    ];
}

    function schoolbox_users_student($results) : array {
        $totalStudentCount = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $totalStudentCount += is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                }
            }
        }
        return [
            'totalStudentCount' => $totalStudentCount
        ];
    }

    function schoolbox_users_staff($results) : array {
        $totalStaffCount = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $totalStaffCount += is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                }
            }
        }
        return [
            'totalStaffCount' => $totalStaffCount
        ];
    }

    function schoolbox_users_parent($results) : array {
        $totalParentCount = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $totalParentCount += is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                }
            }
        }
        return [
            'totalParentCount' => $totalParentCount
        ];
    }

    function schoolbox_totalcampus($results) : array {
        $totalCampus = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $totalCampus += is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                }
            }
        }
        return [
            'totalCampus' => $totalCampus
        ];
    }

    function schoolbox_package_version($results) : array {
        $productionPackageVersions = [];
        $developmentPackageVersions = [];
        $productionTotal = 0;
        $developmentTotal = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $value = $individualServer['value'];
                // Get production server statistics
                if ($individualServer['environment'] == 'production') {
                    if (!array_key_exists($value, $productionPackageVersions)) {
                        $productionPackageVersions[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $productionPackageVersions[$value]['count']++;
                    }
                    $productionTotal++;
                }

                // Get development server statistics
                if ($individualServer['environment'] == 'staging') {
                    if (!array_key_exists($value, $developmentPackageVersions)) {
                        $developmentPackageVersions[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $developmentPackageVersions[$value]['count']++;
                    }
                    $developmentTotal++;
                }
            }
        }

        // Calculate percentages for production
        foreach ($productionPackageVersions as $productionPackageVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $productionTotal) * 100, 2);
            $productionPackageVersions[$productionPackageVersion]['percent'] = $percent;
        }

        // Calculate percentages for staging
        foreach ($developmentPackageVersions as $developmentPackageVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $developmentTotal) * 100, 2);
            $developmentPackageVersions[$developmentPackageVersion]['percent'] = $percent;
        }

        return [
            'productionPackageVersions' => $productionPackageVersions,
            'developmentPackageVersions' => $developmentPackageVersions
        ];
    }

    function schoolboxdev_package_version($results) : array {
        $productionPackageVersions = [];
        $developmentPackageVersions = [];
        $productionTotal = 0;
        $developmentTotal = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $value = $individualServer['value'];
                // Get production server statistics
                if ($individualServer['environment'] == 'production') {
                    if (!array_key_exists($value, $productionPackageVersions)) {
                        $productionPackageVersions[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $productionPackageVersions[$value]['count']++;
                    }
                    $productionTotal++;
                }

                // Get development server statistics
                if ($individualServer['environment'] == 'staging') {
                    if (!array_key_exists($value, $developmentPackageVersions)) {
                        $developmentPackageVersions[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $developmentPackageVersions[$value]['count']++;
                    }
                    $developmentTotal++;
                }
            }
        }

        // Calculate percentages for production
        foreach ($productionPackageVersions as $productionPackageVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $productionTotal) * 100, 2);
            $productionPackageVersions[$productionPackageVersion]['percent'] = $percent;
        }

        // Calculate percentages for staging
        foreach ($developmentPackageVersions as $developmentPackageVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $developmentTotal) * 100, 2);
            $developmentPackageVersions[$developmentPackageVersion]['percent'] = $percent;
        }

        return [
            'productionPackageVersions' => $productionPackageVersions,
            'developmentPackageVersions' => $developmentPackageVersions
        ];
    }

    function virtual($results) : array {
        $serverTypes = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $certname = $individualServer['certname'];
                if (stripos($certname, '.live.') || stripos($certname, '.prd.') || stripos($certname, '.dev.') || stripos($certname, '.stg.') || stripos($certname, '.dr.')) {
                    $value = $individualServer['value'];
                    if (!array_key_exists($value, $serverTypes)) {
                        $serverTypes[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $serverTypes[$value]['count']++;
                    }
                    $total++;
                }
            }
        }

        // Calculate percentages
        foreach ($serverTypes as $serverType => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $serverTypes[$serverType]['percent'] = $percent;
        }

        return $serverTypes;
    }

    function lsbdistdescription($results) : array {
        $linuxVersions = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $linuxValue = $individualServer['value'];
                if (!array_key_exists($linuxValue, $linuxVersions)) {
                    $linuxVersions[$linuxValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $linuxVersions[$linuxValue]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($linuxVersions as $linuxVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $linuxVersions[$linuxVersion]['percent'] = $percent;
        }

        return $linuxVersions;
    }

    function kernelmajversion($results) : array {
        $kernelVersions = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $kernelValue = $individualServer['value'];
                if (!array_key_exists($kernelValue, $kernelVersions)) {
                    $kernelVersions[$kernelValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $kernelVersions[$kernelValue]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($kernelVersions as $kernelVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $kernelVersions[$kernelVersion]['percent'] = $percent;
        }

        return $kernelVersions;
    }

    function kernelrelease($results) : array {
        $kernelTypes = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $kernelValue = $individualServer['value'];
                if (!array_key_exists($kernelValue, $kernelTypes)) {
                    $kernelTypes[$kernelValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $kernelTypes[$kernelValue]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($kernelTypes as $kernelType => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $kernelTypes[$kernelType]['percent'] = $percent;
        }

        return $kernelTypes;
    }

    function php_cli_version($results) : array {
        $phpVersions = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $phpValue = $individualServer['value'];
                if (!array_key_exists($phpValue, $phpVersions)) {
                    $phpVersions[$phpValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $phpVersions[$phpValue]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($phpVersions as $phpVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $phpVersions[$phpVersion]['percent'] = $percent;
        }

        return $phpVersions;
    }

    function mysql_extra_version($results) : array {
        $mySqlVersions = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $mySqlValue = $individualServer['value'];
                if (!array_key_exists($mySqlValue, $mySqlVersions)) {
                    $mySqlVersions[$mySqlValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $mySqlVersions[$mySqlValue]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($mySqlVersions as $mySqlVersion => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $mySqlVersions[$mySqlVersion]['percent'] = $percent;
        }

        return $mySqlVersions;
    }

    function processorcount($results) : array {
        $processorCounts = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $processorCount = $individualServer['value'];
                if (!array_key_exists($processorCount, $processorCounts)) {
                    $processorCounts[$processorCount] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $processorCounts[$processorCount]['count']++;
                }
                $total++;
            }
        }

        // Calculate percentages
        foreach ($processorCounts as $processorCount => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $processorCounts[$processorCount]['percent'] = $percent;
        }

        return $processorCounts;
    }

    function memorysize($results) : array {
        $memoryArray = [];
        $total = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                $value = $individualServer['value'];
                $numericValue = explode(' ', $value)[0];

                // If the value is in MB, convert it to GB
                if (stripos($value, 'MiB') || stripos($value, 'MB')) {
                    $numericValue = ceil($numericValue / 1024);
                } else {
                    $numericValue = ceil($numericValue);
                }

                $numericValue = intval($numericValue);

                if (!array_key_exists($numericValue, $memoryArray)) {
                    $memoryArray[$numericValue] = ['count' => 1, 'percent' => 0.00];
                } else {
                    $memoryArray[$numericValue]['count']++;
                }
                $total++;
            }
        }
        // Calculate percentages
        foreach ($memoryArray as $memSize => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $memoryArray[$memSize]['percent'] = $percent;
        }

        return $memoryArray;

    }

    function schoolbox_config_date_timezone($results) : array {
        $timeZones = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                // Only use production servers
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $value = array_values($individualServer['value'])[0];

                    if (!array_key_exists($value, $timeZones)) {
                        $timeZones[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $timeZones[$value]['count']++;
                    }
                    $total++;
                }
            }
        }

        // Calculate percentages
        foreach ($timeZones as $timeZone => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $timeZones[$timeZone]['percent'] = $percent;
        }

        return $timeZones;
    }

    function schoolbox_config_external_type($results) : array {
        $externalDBTypes = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                // Only use production servers
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $value = array_values($individualServer['value'])[0];

                    if (!array_key_exists($value, $externalDBTypes)) {
                        $externalDBTypes[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $externalDBTypes[$value]['count']++;
                    }
                    $total++;
                }
            }
        }

        // Calculate percentages
        foreach ($externalDBTypes as $externalDBType => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $externalDBTypes[$externalDBType]['percent'] = $percent;
        }

        return $externalDBTypes;
    }

    function schoolbox_first_file_upload_year($results) : array {
        $firstFileUploadArray = [];
        $total = 0;

        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                // Only use 'live' servers
                if (stripos($individualServer['certname'], '.live.')) {
                    $value = $individualServer['value'];
                    $value = str_replace("\"", '', $value);

                    if ($value == "NULL") {
                        $value = date("Y");
                    }

                    if (!array_key_exists($value, $firstFileUploadArray)) {
                        $firstFileUploadArray[$value] = ['count' => 1, 'percent' => 0.00];
                    } else {
                        $firstFileUploadArray[$value]['count']++;
                    }
                    $total++;
                }
            }
        }

        // Calculate percentages
        foreach ($firstFileUploadArray as $firstFileUpload => $value) {
            $count = $value['count'];
            $percent = round(($count / $total) * 100, 2);
            $firstFileUploadArray[$firstFileUpload]['percent'] = $percent;
        }

        return $firstFileUploadArray;
    }

