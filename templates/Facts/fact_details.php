<?php

// Known facts list - known facts should be treated differently in table rendering
$knownFacts = [
//    "schoolbox_totalusers",
//    "schoolbox_config_site_type",
//    "schoolbox_users_student",
//	"schoolbox_users_staff",
//	"schoolbox_users_parent",
//	"schoolbox_totalcampus",
//    "schoolbox_package_version",
//    "schoolboxdev_package_version",
//    "virtual",
//    "lsbdistdescription",
//	"kernelmajversion",
//	"kernelrelease",
//	"php_cli_version",
//	"mysql_extra_version",
//	"processorcount",
//	"memorysize",
//	"schoolbox_config_date_timezone",
//    "schoolbox_config_external_type",
//	"schoolbox_first_file_upload_year"
];

/**
 * Note regarding this weirdness:
 *
 * For whatever reason, if you try to access $value after the table is rendered,
 * it will sometimes be an array (but not all the time, of course).
 *
 * The easiest solution I can find is to set the variable here (where it is always
 * a string), and then just use that new variable elsewhere (as it always remains
 * a string).
 *
 * CakePHP is wild.
 *
 * Dane Rainbird, 04/09/2021
 */
if (isset($value)) {
    $searchVal = $value;
} else {
    $searchVal = null;
}

// Only show breadcrumbs when not on default page
if (isset($fact)) {
    $this->Breadcrumbs->add([
        ['title' => 'Individual Facts', 'url' => ['controller' => 'Facts', 'action' => 'fact-details']],
        ['title' => $fact, 'url' => ['controller' => 'Facts', 'action' => 'fact-details', '?' => ['fact' => $fact]]]
    ]);
    // If a search value has been provided, then render an extra breadcrumb for the search value
    if (isset($searchVal)) {
        $this->Breadcrumbs->add([
            ['title' => "Search: '<em>" . $searchVal . "'</em>", 'url' => ['controller' => 'Facts', 'action' => 'fact-details', '?' => ['fact' => $fact, 'value' => $searchVal]]]
        ]);
    }
    // If an environment value has been provided, then render an extra breadcrumb for the environment value
    if (isset($environmentSpecific)) {
        $this->Breadcrumbs->add([
            ['title' => "Environment: '<em>" . $environmentSpecific . "'</em>", 'url' => ['controller' => 'Facts', 'action' => 'fact-details', '?' => ['fact' => $fact, 'value' => $searchVal, 'environment' => $environmentSpecific]]]
        ]);
    }
}

// If a fact value is set, then update the page title
if (isset($fact)) {
    $this->assign('title', $fact . ' Details');
} else {
    $this->assign('title', 'Individual Fact Details');
}
?>

<div class="row">
    <div class="col-12">
        <?php
        echo $this->Breadcrumbs->render(
            ['class' => 'breadcrumb'],
            ['separator' => '<i id="breadcrumb-divider" class="fa fa-angle-right"> </i>']
        );
        ?>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <?php
                    // Determine what header to show
                    if (isset($fact)) {
                        echo "
                        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
                            <span class='text-white font-weight-bold'>The below is <u>live</u> data, pulled from the server just now.</span>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>";
                        echo "<h5><em><b>'$fact'</b></em> Details</h5>";
                        if (isset($searchVal)) {
                            echo "<em>Searching for: '<b>" . $searchVal . "</b>'" .  (isset($environmentSpecific) ? ", in environment: '<b>" . $environmentSpecific . "</b>'.</em>" : ".</em>");
                        } else if (isset($environmentSpecific)) {
                            echo "<em>In  environment:'<b>" . $environmentSpecific . "</b>'</em>";
                        };
                        // Determine if this fact is instance specific
                        $isInstanceSpecific =
                            str_starts_with($fact, 'schoolbox_config_') ||
                            str_starts_with($fact, 'schoolbox_users_')  ||
                            str_starts_with($fact, 'schoolbox_media_')  ||
                            $fact == 'schoolbox_totalusers' ||
                            $fact == 'schoolbox_totalcampus';

                    } else {
                        echo '<h5>Individual Fact Details</h5>';
                        $isInstanceSpecific = false;
                    }
                ?>

            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <?php
                                // Check if results are set, and display default message if not
                                if (!isset($results)) {
                                    echo 'Welcome to the individual Facts page. Please select a fact from the below dropdown:';
                                } else {
                                    if (isset($results[0])) {
                                        if ($results[0] !== 'integer') {
                                            if (!array_filter(array_map('array_filter', $results))) {
                                                echo 'Unknown fact name, or no details returned from server.';
                                            }
                                        }
                                    }

                                    // Start creating the table
                                    echo '<table id="factTable" class="table table-responsive w-100"><thead><tr>';


                                    // If in the array of known facts, render entirely different table + skip data processing
                                    if (in_array($fact, $knownFacts)) {
                                        // If the known fact is an integer (e.g. total users), then just display the value and nothing else
                                        if (is_int(array_values($results)[0])) {
                                            echo '<th>Value</th></tr><tbody><td>' . array_values($results)[0] . '</td></tr>';
                                        } else {
                                            // Create the header
                                            echo "<th id='value'>Value</th>
                                                  <th>Amount</th>
                                                  <th>Percentage</th>
                                                  </tr></thead>";
                                            // Create the columns
                                            echo '<tbody>';
                                            foreach ($results as $key => $value) {
                                                echo '<tr>';
                                                echo '<td>' . $key . '</td>';
                                                echo '<td>' . $value['count'] . '</td>';
                                                echo '<td>' . $value['percent'] . '</td>';
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                        }
                                    } else {
                                        // If instance-specific, render with InstanceID column
                                        if ($isInstanceSpecific) {
                                            echo '<th>Instance ID</th><th>Certname</th><th id="value">Value</th>';
                                        } else {
                                            echo '<th>Certname</th><th id="value">Value</th>';
                                        }
                                        echo '</tr></thead>';
                                        echo '<tbody>';

                                        $data = [];
                                        $certNameValues = [];
                                        // Loop over returned results
                                        foreach ($results as $result) {
                                            // If the requested fact is environment specific, then filter by the environment value
                                            if (isset($environmentSpecific)) {
                                                if ($result['environment'] == $environmentSpecific) {
                                                    $certNameValues[$result['certname']] = $result['value'];
                                                }
                                                // Otherwise, just get all values
                                            } else {
                                                $certNameValues[$result['certname']] = $result['value'];

                                            }
                                        }
                                        // If the query is instance specific, then get the instance ID as the first column of the table
                                        foreach ($certNameValues as $certName => $values) {
                                            if ($isInstanceSpecific) {
                                                foreach ($values as $instanceId => $value) {
                                                    if (!array_key_exists($instanceId, $data)) {
                                                        $data[$instanceId] = [[], []];
                                                    }
                                                    $data[$instanceId][0][] = $certName;
                                                    $data[$instanceId][1][] = $value;
                                                }
                                                // If not instance specific, then just create the data array normally
                                            } else {
                                                foreach ($certNameValues as $certName => $value) {
                                                    $data[$certName] = [is_array($value) ? json_encode($value) : $value];
                                                }
                                            }
                                        }
                                        // If instance specific, render with 3 columns (InstanceID, CertName, Value)
                                        foreach ($data as $key => $value) {
                                            if ($isInstanceSpecific) {
                                                // Create key / instance ID value
                                                echo '<tr>';
                                                echo '<td>' . $key . '</td>';

                                                // Create certname
                                                echo '<td>';
                                                echo implode(', ', $value[0]);
                                                echo '</td>';

                                                // Create fact value
                                                echo '<td>' . $value[1][0] . '</td>';
                                                echo '</tr>';
                                            } else {
                                                // If not instance specific, render with 2 columns (CertName, Value)
                                                echo '<tr>';
                                                echo '<td>' . $key . '</td>';
                                                echo '<td>' . $value[0] . '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    echo '</tbody></table>';
                                }
                                ?>

                            <hr />
                            <div class="form-group">
                                <?php
                                // Create an HTML form for selecting the type
                                echo $this->Form->create(null, ['url' => ['action' => 'fact_details']]);
                                echo '<div class="row align-items-center"><div class="col-md-auto">';
                                echo $this->Form->input(
                                    'fact',
                                    [
                                        'type' => 'select',
                                        'options' => $factNamesList,
                                        'class' => 'form-control'
                                    ]
                                );
                                echo '</div><div class="col-md-auto">';
                                echo $this->Form->input(
                                    'environment',
                                    [
                                        'type' => 'select',
                                        'options' => [
                                            'production' => 'production',
                                            'staging' => 'staging'
                                        ],
                                        'class' => 'form-control'
                                    ]
                                );
                                echo '</div><div class="col-md-auto mt-2 mt-md-0">';
                                echo $this->Form->button('Go to fact details!', ['type' => 'submit', 'class' => 'btn btn-primary mb-0 w-100']);
                                echo $this->Form->end();
                                echo '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // DataTable initialisation
    $(document).ready(() => {
        let numberOfColumns = document.getElementById('factTable').rows[0].cells.length;

        let table = $('#factTable').DataTable({
            paging: false,
            order: [
                [
                    <?php
                    if ($isInstanceSpecific) {
                        if (in_array($fact, $knownFacts)) {
                            echo 0;
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 1;
                    }
                    ?>,
                    'desc']
            ],
            info: false,
            scrollX: true,
            <?php
                if (isset($searchVal)) {
                    echo 'dom: "ti",';
                }
            ?>
        })

        // Set search value
        table.columns("#value")
            .search(<?= "'" . $searchVal . "'" ?>)
            .draw();

    });

</script>

