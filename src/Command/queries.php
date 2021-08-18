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



