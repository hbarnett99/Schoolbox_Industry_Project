<?php

// Known facts list - known facts should be treated differently in table rendering
$knownFacts = [
    "schoolbox_totalusers",
    "schoolbox_config_site_type",
    "schoolbox_users_student",
	"schoolbox_users_staff",
	"schoolbox_users_parent",
	"schoolbox_totalcampus",
    "schoolbox_package_version",
    "schoolboxdev_package_version",
    "virtual",
    "lsbdistdescription",
	"kernelmajversion",
	"kernelrelease",
	"php_cli_version",
	"mysql_extra_version",
	"processorcount",
	"memorysize",
	"schoolbox_config_date_timezone",
    "schoolbox_config_external_type",
	"schoolbox_first_file_upload_year"
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
                        echo "<h5><em><b>'$fact'</b></em> Details</h5>";
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
                                            echo "<th>Value</th>
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
                                            echo '<th>Instance ID</th><th>Certname</th><th>Value</th>';
                                        } else {
                                            echo '<th>Certname</th><th>Value</th>';
                                        }
                                        echo '</tr></thead>';
                                        echo '<tbody>';

                                        $data = [];
                                        $certNameValues = [];
                                        // Loop over returned results
                                        foreach ($results as $result) {
                                            $certNameValues[$result['certname']] = $result['value'];
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
                                echo '<div class="row"><div class="col-4">';
                                echo $this->Form->input(
                                    'fact',
                                    [
                                        'type' => 'select',
                                        'options' => $factNamesList,
                                        'class' => 'form-control'
                                    ]
                                );
                                echo '</div><div class="col-3">';
                                echo $this->Form->button('Go to fact details!', ['type' => 'submit', 'class' => 'btn']);
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
        // Set only the first column to be searchable and disable all others
        let columns = [{'searchable' : true}];
        for (var i=1; i < numberOfColumns; i++) {
            columns.push({"searchable": false});
        }
        $('#factTable').DataTable({
            paging: false,
            search: {
                search: <?php
                            // Set the search based on queryString
                             if ($searchVal) {
                                echo "'" . h($searchVal) . "'";
                            } else {
                                echo "''";
                            }
                        ?>
            },
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
            columns: columns
        })
    });
</script>

