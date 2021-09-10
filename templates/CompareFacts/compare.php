<?php

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
                                                       foreach ($factSetOne as $key => $detail) {
                                                            echo $key . ' : ' . $detail->count . "<br />" ;
                                                       }
                                                    echo '</div>
                                                </div>
                                                <div class="col border-0 p-4 mb-2 mx-1 bg-gray-100 rounded">
                                                    <h6>' . $timeStampTwo . '</h6>
                                                    <hr />
                                                    <div id="factValueTwo">';
                                                        foreach ($factSetTwo as $key => $detail) {
                                                            echo $key . ' : ' . $detail->count . "<br />" ;
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
