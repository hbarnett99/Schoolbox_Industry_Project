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
asort($knownFacts);

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
                                    if ($selectedFact != 'schoolbox_config_site_type' && $selectedFact != 'schoolbox_totalusers'  && $selectedFact != 'schoolboxdev_package_version'  && $selectedFact != 'schoolbox_package_version') {
                                        $factSetOne = json_decode(json_encode(sortByCountDescending($factSetOne)), true);
                                        $factSetTwo = json_decode(json_encode(sortByCountDescending($factSetTwo)), true);
                                    }

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

                                    // If the value is numeric only, display as numeric only
                                    if (in_array($selectedFact, $numericalOnlyFacts)) {
                                        $factOneValue = (intval(current((array)$factSetOne)));
                                        $factTwoValue = (intval(current((array)$factSetTwo)));
                                        echo "
                                            <tr>
                                                <td>" . $selectedFact . "</td>
                                                <td>" . number_format($factOneValue) . "</td>
                                                <td>" . number_format($factTwoValue) . "</td>
                                                <td>";
                                        if ($factTwoValue > $factOneValue) {
                                            echo "+ " . abs($factTwoValue - $factOneValue);
                                        } else if ($factTwoValue < $factOneValue) {
                                            echo "- " . abs($factTwoValue - $factOneValue);
                                        } else if ($factTwoValue == $factOneValue) {
                                            echo "No change";
                                        }
                                        echo "</td>
                                            </tr>
                                            ";

                                        // If not numeric, handle depending on selected fact
                                    } else {

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
                                                                <td>" . number_format($factTwoValue) . "</td>
                                                                <td>";
                                                                    if ($factTwoValue > $factOneValue) {
                                                                        echo "+ " . abs($factTwoValue - $factOneValue);
                                                                    } else if ($factTwoValue < $factOneValue) {
                                                                        echo "- " . abs($factTwoValue - $factOneValue);
                                                                    } else if ($factTwoValue == $factOneValue) {
                                                                        echo "";
                                                                    }
                                                                    echo "</td>
                                                            </tr>
                                                            ";
                                                    break;
                                                case 'schoolboxdev_package_version':
                                                case 'schoolbox_package_version':
                                                    echo "
                                                            <tr>
                                                                <td colspan='4' class='text-center font-weight-bolder'>Production Packages</td>
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
                                                                <td>" . $value->count . "</td>
                                                                <td>"; if (is_int($factOneValue)) {
                                                                            if ($value->count > $factOneValue) {
                                                                                echo "+ " . abs($value->count - $factOneValue);
                                                                            } else if ($value->count < $factOneValue) {
                                                                                echo "- " . abs($value->count - $factOneValue);
                                                                            } else if ($value->count == $factOneValue) {
                                                                                echo "";
                                                                            }
                                                                        } else {
                                                                            echo "New value!";
                                                                        }
                                                            echo "
                                                                </td>
                                                            </tr>
                                                            ";
                                                    }
                                                echo "
                                                            <tr>
                                                                <td colspan='4' class='text-center font-weight-bolder'>Development Packages</td>
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
                                                                <td>" . $value->count . "</td>
                                                                <td>"; if (is_int($factOneValue)) {
                                                            if ($value->count > $factOneValue) {
                                                                echo "+ " . abs($value->count - $factOneValue);
                                                            } else if ($value->count < $factOneValue) {
                                                                echo "- " . abs($value->count - $factOneValue);
                                                            } else if ($value->count == $factOneValue) {
                                                                echo "";
                                                            }
                                                        } else {
                                                            echo "New value!";
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
                                                                <td>" . $factOneValue  . "</td>
                                                                    <td>" . $value . "</td>
                                                                    <td>";
                                                                        if ($factOneValue != $value) {
                                                                            echo "New value!";
                                                                        } else {
                                                                            echo "";
                                                                        }
                                                                        echo "</td></tr>";
                                                    }
                                                    break;
                                            }

                                        // Otherwise, just render using default settings
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
                                                        <td>" . $value['count'] . "</td>
                                                        <td>";
                                                if (is_int($factOneValue)) {
                                                    if ($value['count'] > $factOneValue) {
                                                        echo "+ " . abs($value['count'] - $factOneValue);
                                                    } else if ($value['count'] < $factOneValue) {
                                                        echo "- " . abs($value['count'] - $factOneValue);
                                                    } else if ($value['count'] == $factOneValue) {
                                                        echo "";
                                                    }
                                                } else {
                                                    echo "New value!";
                                                }

                                                echo "</td>
                                                </tr>
                                              ";
                                            }
                                        }
                                    }



                                    echo '</tbody></table>';

                                    echo '
                                            <div class="row">
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $this->Time->format($timeStampOne, \IntlDateFormatter::MEDIUM, null) . '</h6>
                                                    <hr />
                                                    <input type="checkbox" id="readMoreFirst" />
                                                    <div id="factValueOne" class="inner">';
                                                        if ($selectedFact != 'schoolbox_config_site_type' && $selectedFact != 'schoolbox_totalusers'  && $selectedFact != 'schoolboxdev_package_version'  && $selectedFact != 'schoolbox_package_version') {
                                                            $factSetOne = json_decode(json_encode(sortByCountDescending($factSetOne)));
                                                            $factSetTwo = json_decode(json_encode(sortByCountDescending($factSetTwo)));
                                                        }

                                                        // If the value is numeric only, display as numeric only
                                                       if (in_array($selectedFact, $numericalOnlyFacts)) {
                                                           echo number_format(intval(current((array) $factSetOne)));
                                                       // If not numeric, then handle on case-by-case
                                                       } else {
                                                           if (in_array($selectedFact, $nonStandardFacts)) {
                                                               switch ($selectedFact) {
                                                                   case 'schoolbox_totalusers':
                                                                       echo number_format(intval($factSetOne->totalUsersFleetCount));
                                                                       break;
                                                                   case 'schoolboxdev_package_version':
                                                                   case 'schoolbox_package_version':
                                                                       echo "<b>Production Schoolbox Packages</b>";
                                                                       foreach ($factSetOne->productionPackageVersions as $key => $value) {
                                                                           echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                       }
                                                                       echo "<br /><b>Development Schoolbox Packages</b><br />";
                                                                       foreach ($factSetOne->developmentPackageVersions as $key => $value) {
                                                                           echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                       }
                                                                       break;
                                                                   case 'schoolbox_config_site_type':
                                                                       foreach ($factSetOne as $server => $value) {
                                                                           echo "<p class='comparedFactValue' id='" . $server . "'>" . $server . ' : ' . $value . "</p>";
                                                                       }
                                                                       break;
                                                               }
                                                           } else {
                                                               // If not in the non-standard factset, then just render as usual
                                                               foreach ($factSetOne as $key => $detail) {
                                                                   echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $detail->count . "</p>";
                                                               }
                                                           }
                                                       }
                                                    echo '</div><label class="overflowLabel" for="readMoreFirst">Read </label>
                                                </div>
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $this->Time->format($timeStampTwo, \IntlDateFormatter::MEDIUM, null) . '</h6>
                                                    <hr />
                                                    <input type="checkbox" id="readMoreSecond" />
                                                    <div id="factValueTwo" class="inner">';
                                                        // If the value is numeric only, display as numeric only
                                                        if (in_array($selectedFact, $numericalOnlyFacts)) {
                                                            if (current((array) $factSetOne) > current((array) $factSetTwo)) {
                                                                echo "<p class='comparedFactValue highlight-minus'>" . number_format(intval(current((array)$factSetTwo))) . "<span class='float-end pe-1 fact-difference-stats'>- " . abs(current((array)$factSetOne) - current((array)$factSetTwo)) . "</span></p>";
                                                            } elseif (current((array) $factSetOne) < current((array) $factSetTwo)) {
                                                                    echo "<p class='comparedFactValue highlight-plus'>" . number_format(intval(current((array) $factSetTwo))) . "<span class='float-end pe-1 fact-difference-stats'>+ " . abs(current((array) $factSetOne) - current((array) $factSetTwo)) . "</span></p>";
                                                            } else {
                                                                echo "<p class='comparedFactValue'>" . number_format(intval(current((array) $factSetTwo))) . "</p>";
                                                            }
                                                            // If not numeric, then handle on case-by-case
                                                        } else {
                                                            if (in_array($selectedFact, $nonStandardFacts)) {
                                                                switch ($selectedFact) {
                                                                    case 'schoolbox_totalusers':
                                                                        // First case compares if less than, show red & "-", second shows green and "+", third is unchanged
                                                                        if ($factSetTwo->totalUsersFleetCount < $factSetOne->totalUsersFleetCount) {
                                                                            echo "<p class='comparedFactValue highlight-minus' id='totalUsersFleetCount'>" . number_format(intval($factSetTwo->totalUsersFleetCount)) . "<span class='float-end pe-1 fact-difference-stats'>- " . abs($factSetTwo->totalUsersFleetCount - $factSetOne->totalUsersFleetCount) . "</span></p>";
                                                                        } elseif ($factSetTwo->totalUsersFleetCount > $factSetOne->totalUsersFleetCount) {
                                                                                echo "<p class='comparedFactValue highlight-plus' id='totalUsersFleetCount'>" . number_format(intval($factSetTwo->totalUsersFleetCount)) . "<span class='float-end pe-1 fact-difference-stats'>+ " . abs($factSetTwo->totalUsersFleetCount - $factSetOne->totalUsersFleetCount) . "</span></p>";
                                                                        } else {
                                                                            echo "<p class='comparedFactValue' id='totalUsersFleetCount'>" . number_format(intval($factSetTwo->totalUsersFleetCount)) . "</p>";
                                                                        }
                                                                        break;
                                                                    case 'schoolboxdev_package_version':
                                                                    case 'schoolbox_package_version':
                                                                        echo "<b>Production Schoolbox Packages</b>";
                                                                        foreach ($factSetTwo->productionPackageVersions as $key => $value) {
                                                                            // Check if the first set contains the current key
                                                                            if(isset($factSetOne->productionPackageVersions->$key)) {
                                                                                $firstFactSetValue = $factSetOne->productionPackageVersions->$key;
                                                                                // Check if the first set's value is different to the second set's value, and if it is, then display with red highlight
                                                                                if ($firstFactSetValue->count > $value->count) {
                                                                                    echo "<p class='comparedFactValue highlight-minus' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>- " . abs($firstFactSetValue->count - $value->count)  . "</span></p>";
                                                                                } elseif ($firstFactSetValue->count < $value->count) {
                                                                                    echo "<p class='comparedFactValue highlight-plus' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>+ " . abs($firstFactSetValue->count - $value->count)  . "</span></p>";
                                                                                } else { // If it's the same, then display with no change
                                                                                    echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                                }
                                                                            // If it does not, then display with green highlight
                                                                            } else {
                                                                                echo "<p class='comparedFactValue highlight-new' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>New value</span></p>";
                                                                            }
                                                                        }
                                                                        echo "<br /><b>Development Schoolbox Packages</b><br />";
                                                                        foreach ($factSetTwo->developmentPackageVersions as $key => $value) {
                                                                            // Check if the first set contains the current key
                                                                            if(isset($factSetOne->developmentPackageVersions->$key)) {
                                                                                $firstFactSetValue = $factSetOne->developmentPackageVersions->$key;
                                                                                // First case compares if less than, show red & "-", second shows green and "+", third is unchanged
                                                                                if ($firstFactSetValue->count > $value->count) {
                                                                                    echo "<p class='comparedFactValue highlight-minus' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>- " . abs($firstFactSetValue->count - $value->count)  . "</span></p>";
                                                                                } elseif ($firstFactSetValue->count < $value->count) {
                                                                                    echo "<p class='comparedFactValue highlight-plus' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>+ " . abs($firstFactSetValue->count - $value->count)  . "</span></p>";
                                                                                } else { // If it's the same, then display with no change
                                                                                    echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                                }
                                                                                // If it does not, then display with green highlight
                                                                            } else {
                                                                                echo "<p class='comparedFactValue highlight-new' id='" . $key . "'>" . $key . ' : ' . $value->count . "<span class='float-end pe-1 fact-difference-stats'>New value</span></p>";
                                                                            }
                                                                        }
                                                                        break;
                                                                    case 'schoolbox_config_site_type':
                                                                        foreach ($factSetTwo as $server => $value) {
                                                                            // Check if the first set contains the current key
                                                                            if(isset($factSetOne->$server)) {
                                                                                $firstFactSetValue = $factSetOne->$server;
                                                                                // First case compares if less than, show red & "-", second shows green and "+", third is unchanged
                                                                                if ($firstFactSetValue != $value) {
                                                                                    echo "<p class='comparedFactValue highlight-new' id='" . $server . "'>" . $server . ' : ' . $value . "<span class='float-end pe-1 fact-difference-stats'>(Change of " . abs($firstFactSetValue - $value)  . ")</span></p>";
                                                                                } else { // If it's the same, then display with no change
                                                                                    echo "<p class='comparedFactValue' id='" . $server . "'>" . $server . ' : ' . $value . "</p>";
                                                                                }
                                                                                // If it does not, then display with green highlight
                                                                            } else {
                                                                                echo "<p class='comparedFactValue highlight-new' id='" . $server . "'>" . $server . ' : ' . $value . "<span class='float-end pe-1 fact-difference-stats'>New value</span></p>";
                                                                            }
                                                                        }
                                                                        break;
                                                                }
                                                            } else {
                                                                // If not in the non-standard factset, then just render as usual
                                                                foreach ($factSetTwo as $key => $detail) {
                                                                    // Check if the first set contains the current key
                                                                    if(isset($factSetOne->$key)) {
                                                                        $firstFactSetValue = $factSetOne->$key;
                                                                        // First case compares if less than, show red & "-", second shows green and "+", third is unchanged
                                                                        if ($firstFactSetValue->count > $detail->count) {
                                                                            echo "<p class='comparedFactValue highlight-minus' id='" . $key . "'>" . $key . ' : ' . $detail->count . "<span class='float-end pe-1 fact-difference-stats'>- " . abs($firstFactSetValue->count - $detail->count) . "</span></p>";
                                                                        } elseif ($firstFactSetValue->count < $detail->count) {
                                                                                echo "<p class='comparedFactValue highlight-plus' id='" . $key . "'>" . $key . ' : ' . $detail->count . "<span class='float-end pe-1 fact-difference-stats'>+ " . abs($firstFactSetValue->count - $detail->count)  . "</span></p>";
                                                                        } else { // If it's the same, then display with no change
                                                                            echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $detail->count . "</p>";
                                                                        }
                                                                        // If it does not, then display with blue highlight
                                                                    } else {
                                                                        echo "<p class='comparedFactValue highlight-new' id='" . $key . "'>" . $key . ' : ' . $detail->count . "<span class='float-end pe-1 fact-difference-stats'>New value</span></p>";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        echo '</div><label class="overflowLabel" for="readMoreSecond">Read </label>
                                                </div>
                                            </div>
                                        ';
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
                "initComplete": function (settings, json) {
                    $("#comparedFactsTable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");
                }
            });
        </script>
    </div>
</div>
