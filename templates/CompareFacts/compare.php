<?php

// Helper sort function. Takes an array and returns it in descending order of a 'count' value.
function sortByCountDescending($array)
{
    $array = json_decode(json_encode($array), true);
    uasort($array, function ($a, $b) {
        return $b['count'] - $a['count'];
    });
    return $array;
}

// List of facts that only have numerical responses
$numericalOnlyFacts = [
    'schoolbox_users_student',
    'schoolbox_users_staff',
    'schoolbox_users_parent',
    'schoolbox_totalcampus'
];

// List of non-standard facts (i.e. require specific data wrangling to display properly)
$nonStandardFacts = [
    'schoolbox_config_site_type',
    'schoolbox_package_version',
    'schoolboxdev_package_version',
    'schoolbox_totalusers'
];

// Only show breadcrumbs when not on default page
if (isset($selectedFact)) {
    $this->Breadcrumbs->add([
        ['title' => 'Compare Facts', 'url' => ['controller' => 'CompareFacts', 'action' => 'compare']],
        ['title' => $selectedFact . ' between ' . $this->Time->format($timeStampOne, \IntlDateFormatter::MEDIUM, null)  . " and " . $this->Time->format($timeStampTwo, \IntlDateFormatter::MEDIUM, null), 'url' => ['controller' => 'CompareFacts', 'action' => 'compare']]
    ]);
}

// Sort the list of known facts alphabetically according to their values
natsort($knownFacts);

// Set page title depending on if a fact has been selected to be compared
if (isset($selectedFact)) {
    $this->assign('title', 'Comparing ' . $selectedFact);
} else {
    $this->assign('title', 'Compare Fact Sets');
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
                <h5>Compare Cached Facts</h5>
                <?php
                    if (isset($selectedFact)) {
                        echo "<em>Comparing values for: '<b>" . $selectedFact . "</b>', between <b>" . $this->Time->format($timeStampOne, \IntlDateFormatter::MEDIUM, null)  . "</b> and <b>" . $this->Time->format($timeStampTwo, \IntlDateFormatter::MEDIUM, null), "</b></em>";
                    }
                ?>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <?php
                                if (!isset($factSetOne)) {
                                    echo 'Welcome to the Fact Comparison page. Please select your timestamps and fact from below dropdown:';
                                } else {
                                    if ($selectedFact != 'schoolbox_config_site_type' && $selectedFact != 'schoolbox_totalusers' && $selectedFact != 'schoolboxdev_package_version' && $selectedFact != 'schoolbox_package_version') {
                                        $factSetOne = json_decode(json_encode(sortByCountDescending($factSetOne)), true);
                                        $factSetTwo = json_decode(json_encode(sortByCountDescending($factSetTwo)), true);
                                    }

                                    // Begin building generic table structure
                                    echo '<table class="table table-responsive table-striped" id="comparedFactsTable">';
                                    echo "
                                        <thead>
                                            <tr>
                                                <th>Value</th>
                                                <th>" . $this->Time->format($timeStampOne, \IntlDateFormatter::MEDIUM, null) . "</th>
                                                <th>" . $this->Time->format($timeStampTwo, \IntlDateFormatter::MEDIUM, null) . "</th>
                                                <th>Difference</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        ";

                                    // If the selected fact value is numeric only, display as numeric only
                                    if (in_array($selectedFact, $numericalOnlyFacts)) {
                                        $factOneValue = (intval(current((array)$factSetOne)));
                                        $factTwoValue = (intval(current((array)$factSetTwo)));
                                        echo "
                                            <tr>
                                                <td>" . $selectedFact . "</td>
                                                <td>" . number_format($factOneValue) . "</td>
                                                <td>" . number_format($factTwoValue) . "</td>";
                                        if ($factTwoValue > $factOneValue) {
                                            echo "<td class='highlight-plus'> + " . abs($factTwoValue - $factOneValue);
                                        } else if ($factTwoValue < $factOneValue) {
                                            echo "<td class='highlight-minus'> - " . abs($factTwoValue - $factOneValue);
                                        } else if ($factTwoValue == $factOneValue) {
                                            echo "<td> No change";
                                        }
                                        echo "</td>
                                            </tr>
                                            ";

                                        // If not numeric, handle depending on selected fact
                                    } else {
                                        // If it's a non-standard fact type (i.e. requires more data wrangling)
                                        if (in_array($selectedFact, $nonStandardFacts)) {
                                            // Handle depending on which non-standard fact needs to be rendered
                                            switch ($selectedFact) {
                                                case 'schoolbox_totalusers':
                                                    $factOneValue = (intval(current((array)$factSetOne->totalUsersFleetCount)));
                                                    $factTwoValue = (intval(current((array)$factSetTwo->totalUsersFleetCount)));
                                                    echo "
                                                            <tr>
                                                                <td>" . $selectedFact . "</td>
                                                                <td>" . number_format($factOneValue) . "</td>
                                                                <td>" . number_format($factTwoValue) . "</td>";
                                                    if ($factTwoValue > $factOneValue) {
                                                        echo "<td class='highlight-plus'> + " . abs($factTwoValue - $factOneValue);
                                                    } else if ($factTwoValue < $factOneValue) {
                                                        echo "<td class='highlight-minus'> - " . abs($factTwoValue - $factOneValue);
                                                    } else if ($factTwoValue == $factOneValue) {
                                                        echo "<td> No change";
                                                    }
                                                    echo "</td>
                                                            </tr>
                                                            ";
                                                    break;
                                                case 'schoolboxdev_package_version':
                                                case 'schoolbox_package_version':
                                                    echo "
                                                            <tr>
                                                                <td colspan='4' class='text-center font-weight-bolder'>Schoolbox Packages (in Production)</td>
                                                            </tr>
                                                            ";
                                                    foreach ($factSetTwo->productionPackageVersions as $key => $value) {
                                                        if (isset($factSetOne->productionPackageVersions->$key)) {
                                                            $factOneValue = $factSetOne->productionPackageVersions->$key->count;
                                                        } else {
                                                            $factOneValue = "N/A";
                                                        }
                                                        echo "
                                                            <tr>
                                                                <td>" . $key . "</td>
                                                                <td>" . $factOneValue . "</td>
                                                                <td>" . $value->count . "</td>";
                                                        if (is_int($factOneValue)) {
                                                            if ($value->count > $factOneValue) {
                                                                echo "<td class='highlight-plus'> + " . abs($value->count - $factOneValue);
                                                            } else if ($value->count < $factOneValue) {
                                                                echo "<td class='highlight-minus'> - " . abs($value->count - $factOneValue);
                                                            } else if ($value->count == $factOneValue) {
                                                                echo "<td> No change";
                                                            }
                                                        } else {
                                                            echo "<td class='highlight-new'> New value";
                                                        }
                                                        echo "
                                                                </td>
                                                            </tr>
                                                            ";
                                                    }
                                                    echo "
                                                            <tr>
                                                                <td colspan='4' class='text-center font-weight-bolder'>Schoolbox Packages (in Staging)</td>
                                                            </tr>
                                                            ";
                                                    foreach ($factSetTwo->developmentPackageVersions as $key => $value) {
                                                        if (isset($factSetOne->developmentPackageVersions->$key)) {
                                                            $factOneValue = $factSetOne->developmentPackageVersions->$key->count;
                                                        } else {
                                                            $factOneValue = "N/A";
                                                        }
                                                        echo "
                                                            <tr>
                                                                <td>" . $key . "</td>
                                                                <td>" . $factOneValue . "</td>
                                                                <td>" . $value->count . "</td>";
                                                        if (is_int($factOneValue)) {
                                                            if ($value->count > $factOneValue) {
                                                                echo " <td class='highlight-plus'> + " . abs($value->count - $factOneValue);
                                                            } else if ($value->count < $factOneValue) {
                                                                echo "<td class='highlight-minus'> - " . abs($value->count - $factOneValue);
                                                            } else if ($value->count == $factOneValue) {
                                                                echo "<td>";
                                                            }
                                                        } else {
                                                            echo "<td class='highlight-new'> New value";
                                                        }
                                                        echo "
                                                                </td>
                                                            </tr>
                                                            ";
                                                    }
                                                    break;
                                                case 'schoolbox_config_site_type':
                                                    foreach ($factSetTwo as $server => $value) {
                                                        if (isset($factSetOne->$server)) {
                                                            $factOneValue = $factSetOne->$server;
                                                        } else {
                                                            $factOneValue = "N/A";
                                                        }
                                                        echo "
                                                            <tr>
                                                                <td>" . $server . "</td>
                                                                <td>" . $factOneValue . "</td>
                                                                    <td>" . $value . "</td>";
                                                        if ($factOneValue != $value) {
                                                            echo "<td class='highlight-new'> New value";
                                                        } else {
                                                            echo "<td>";
                                                        }
                                                        echo "</td></tr>";
                                                    }
                                                    break;
                                            }

                                            // If it doesn't require specific data wrangling, just render using default settings
                                        } else {
                                            foreach ($factSetTwo as $key => $value) {
                                                if (isset($factSetOne[$key]['count'])) {
                                                    $factOneValue = $factSetOne[$key]['count'];
                                                } else {
                                                    $factOneValue = "N/A";
                                                }
                                                echo "
                                                <tr>
                                                    <td>" . $key . "</td>
                                                    <td>" . $factOneValue . "</td>
                                                        <td>" . $value['count'] . "</td>";
                                                if (is_int($factOneValue)) {
                                                    if ($value['count'] > $factOneValue) {
                                                        echo "<td class='highlight-plus'> + " . abs($value['count'] - $factOneValue);
                                                    } else if ($value['count'] < $factOneValue) {
                                                        echo "<td class='highlight-minus'> - " . abs($value['count'] - $factOneValue);
                                                    } else if ($value['count'] == $factOneValue) {
                                                        echo "<td>";
                                                    }
                                                } else {
                                                    echo "<td class='highlight-new'> New value";
                                                }

                                                echo "</td>
                                                </tr>
                                              ";
                                            }
                                        }
                                    }

                                    // Finish building table
                                    echo '</tbody></table>';
                                }
                            ?>


                            <?php
                            echo "<hr />";
                            // Create an HTML form for selecting the type
                            echo $this->Form->create(null, ['url' => ['action' => 'compare']]);
                            echo '<div class="row align-items-center"><div class="col-md-auto">';
                            echo $this->Form->input(
                                'timestamp_one',
                                [
                                    'type' => 'select',
                                    'options' => $historicalFactTimeStampOptions,
                                    'class' => 'form-control',
                                    'default' => $this->request->getQuery('timestamp_one')
                                ]
                            );
                            echo '</div><div class="col-md-auto">';
                            echo $this->Form->input(
                                'timestamp_two',
                                [
                                    'type' => 'select',
                                    'options' => $historicalFactTimeStampOptions,
                                    'class' => 'form-control',
                                    'default' => $this->request->getQuery('timestamp_two')
                                ]
                            );
                            echo '</div><div class="col-md-auto">';
                            echo $this->Form->input(
                                'fact',
                                [
                                    'type' => 'select',
                                    'options' => $knownFacts,
                                    'class' => 'form-control',
                                    'default' => (isset($selectedFact)) ? $selectedFact : 0
                                ]
                            );
                            echo '</div><div class="col-md-auto mt-2 mt-md-0">';
                            echo $this->Form->button('Compare Facts!', ['type' => 'submit', 'class' => 'btn btn-primary mb-0 w-100']);
                            echo $this->Form->end();
                            echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let containerHeight = $(".inner")[0].scrollHeight;
            if (containerHeight < 250) {
                $('label').hide();
            }
        </script>
        <?php
            if (isset($selectedFact)) {
                if ($selectedFact != 'schoolbox_package_version' && $selectedFact != 'schoolboxdev_package_version') {
                    echo "<script>
                        $('#comparedFactsTable').DataTable({
                            paging: true,
                            language: {
                                'paginate': {
                                    'next': '>',
                                    'previous': '<'
                                }
                            },
                            info: true,
                            order: [[0, 'desc']],
                            'initComplete': function (settings, json) {
                                $('#comparedFactsTable').wrap('<div style=\'overflow:auto; width:100%;position:relative;\'></div>');
                            }
                        });
                        </script>";
                }
            } ?>
    </div>
</div>
