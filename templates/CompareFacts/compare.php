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
                                    echo '
                                            <div class="row">
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $timeStampOne . '</h6>
                                                    <hr />
                                                    <div id="factValueOne">';
                                                        if ($selectedFact != 'schoolbox_config_site_type' && $selectedFact != 'schoolbox_totalusers') {
                                                            $factSetOne = json_decode(json_encode(sortByCountDescending($factSetOne)));
                                                            $factSetTwo = json_decode(json_encode(sortByCountDescending($factSetTwo)));
                                                        }

                                                        // If the value is numeric only, display as numeric only
                                                       if (in_array($selectedFact, $numericalOnlyFacts)) {
                                                           echo current((array) $factSetOne);
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
                                                                        echo number_format(intval($factSetTwo->totalUsersFleetCount));
                                                                        break;
                                                                    case 'schoolboxdev_package_version':
                                                                    case 'schoolbox_package_version':
                                                                        echo "<b>Production Schoolbox Packages</b>";
                                                                        foreach ($factSetTwo->productionPackageVersions as $key => $value) {
                                                                            echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                        }
                                                                        echo "<br /><b>Development Schoolbox Packages</b><br />";
                                                                        foreach ($factSetTwo->developmentPackageVersions as $key => $value) {
                                                                            echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $value->count . "</p>";
                                                                        }
                                                                        break;
                                                                    case 'schoolbox_config_site_type':
                                                                        foreach ($factSetTwo as $server => $value) {
                                                                            echo "<p class='comparedFactValue' id='" . $server . "'>" . $server . ' : ' . $value . "</p>";
                                                                        }
                                                                        break;
                                                                }
                                                            } else {
                                                                // If not in the non-standard factset, then just render as usual
                                                                foreach ($factSetTwo as $key => $detail) {
                                                                    echo "<p class='comparedFactValue' id='" . $key . "'>" . $key . ' : ' . $detail->count . "</p>";
                                                                }
                                                            }
                                                        }
                                                        echo '</div>
                                                </div>
                                                <script>
                                                    let factSetOne = $("#factValueOne").find("p");
                                                    let factSetTwo = $("#factValueTwo").find("p");

                                                    factSetTwo.each((index, value) => {
                                                        // Get the ID of the item on the right (newest set of data)
                                                        let itemOneId = factSetTwo[index].id;
                                                        let itemOne =  factSetTwo[index];

                                                        // Check if that ID exists for the first fact set
                                                        let itemTwo = $("#factValueOne").find("#" + itemOneId);
                                                        if (itemTwo.length !== 0) {
                                                            itemTwo = itemTwo[0];
                                                            if (itemTwo.innerHTML !== itemOne.innerText) {
                                                                console.log("Item Two: " + itemTwo.innerText);
                                                                console.log("Item One: " + itemOne.innerText);
                                                            }
                                                        }
                                                    })

//                                                    console.log(factSetOne);
//                                                    console.log(factSetTwo);
                                                </script>
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
