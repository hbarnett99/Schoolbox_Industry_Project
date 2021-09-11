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
]
?>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5>Compare Cached Facts</h5>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <?php
                                if (!isset($factSetOne)) {
                                    echo 'Welcome to the Fact Comparison page. Please select your timestamps and fact from below dropdown:';
                                } else {
                                    echo '
                                            <div class="row">
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $timeStampOne . '</h6>
                                                    <hr />
                                                    <div id="factValueOne">';
                                                        $factSetOne = json_decode(json_encode(sortByCountDescending($factSetOne)));
                                                        $factSetTwo = json_decode(json_encode(sortByCountDescending($factSetTwo)));

                                                        // If the value is numeric only, display as numeric only
                                                       if (in_array($selectedFact, $numericalOnlyFacts)) {
                                                           echo current((array) $factSetOne);
                                                       // If not numeric, then handle on case-by-case
                                                       } else {
                                                           if (in_array($selectedFact, $nonStandardFacts)) {
                                                               switch ($selectedFact) {
                                                                   case 'schoolbox_totalusers':
                                                                       echo $factSetOne->totalUsersFleetCount;
                                                                       break;
                                                                   case 'schoolboxdev_package_version':
                                                                   case 'schoolbox_package_version':
                                                                       echo "<b>Production Schoolbox Packages</b><br />";
                                                                       foreach ($factSetOne->productionPackageVersions as $key => $value) {
                                                                           echo $key . ' : ' . $value->count . "<br />";
                                                                       }
                                                                       echo "<br /><b>Development Schoolbox Packages</b><br />";
                                                                       foreach ($factSetOne->developmentPackageVersions as $key => $value) {
                                                                           echo $key . ' : ' . $value->count . "<br />";
                                                                       }
                                                                       break;
                                                                   case 'schoolbox_config_site_type':
                                                                       foreach ($factSetOne as $server => $value) {
                                                                           echo $server . ' : ' . $value . "<br />";
                                                                       }
                                                                       break;
                                                               }
                                                           } else {
                                                               // If not in the non-standard factset, then just render as usual
                                                               foreach ($factSetOne as $key => $detail) {
                                                                   echo $key . ' : ' . $detail->count . "<br />" ;
                                                               }
                                                           }
                                                       }
                                                    echo '</div>
                                                </div>
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $timeStampTwo . '</h6>
                                                    <hr />
                                                    <div id="factValueTwo">';
                                                        // If the value is numeric only, display as numeric only
                                                        if (in_array($selectedFact, $numericalOnlyFacts)) {
                                                            echo current((array) $factSetTwo);
                                                            // If not numeric, then handle on case-by-case
                                                        } else {
                                                            if (in_array($selectedFact, $nonStandardFacts)) {
                                                                switch ($selectedFact) {
                                                                    case 'schoolbox_totalusers':
                                                                        echo $factSetTwo->totalUsersFleetCount;
                                                                        break;
                                                                    case 'schoolboxdev_package_version':
                                                                    case 'schoolbox_package_version':
                                                                        echo "<b>Production Schoolbox Packages</b><br />";
                                                                        foreach ($factSetTwo->productionPackageVersions as $key => $value) {
                                                                            echo $key . ' : ' . $value->count . "<br />";
                                                                        }
                                                                        echo "<br /><b>Development Schoolbox Packages</b><br />";
                                                                        foreach ($factSetTwo->developmentPackageVersions as $key => $value) {
                                                                            echo $key . ' : ' . $value->count . "<br />";
                                                                        }
                                                                        break;
                                                                    case 'schoolbox_config_site_type':
                                                                        foreach ($factSetTwo as $server => $value) {
                                                                            echo $server . ' : ' . $value . "<br />";
                                                                        }
                                                                        break;
                                                                }
                                                            } else {
                                                                // If not in the non-standard factset, then just render as usual
                                                                foreach ($factSetTwo as $key => $detail) {
                                                                    echo $key . ' : ' . $detail->count . "<br />" ;
                                                                }
                                                            }
                                                        }
                                                        echo '</div>
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
                                    'class' => 'form-control'
                                ]
                            );
                            echo '</div><div class="col-md-auto">';
                            echo $this->Form->input(
                                'timestamp_two',
                                [
                                    'type' => 'select',
                                    'options' => $historicalFactTimeStampOptions,
                                    'class' => 'form-control'
                                ]
                            );
                            echo '</div><div class="col-md-auto">';
                            echo $this->Form->input(
                                'fact',
                                [
                                    'type' => 'select',
                                    'options' => $knownFacts,
                                    'class' => 'form-control'
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
    </div>
</div>
