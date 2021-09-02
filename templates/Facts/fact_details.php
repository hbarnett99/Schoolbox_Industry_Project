<?php

?>

<div class="row">
    <div class="col-12">
        <?php
        echo $this->Breadcrumbs->render(
            ['class' => 'breadcrumb'],
            ['separator' => '<i class="fa fa-angle-right"></i>']
        );
        ?>
        <div class="card mb-4">

            <div class="card-header pb-0">
                <?php
                    if (isset($fact)) {
                        echo "<h5><em><b>'$fact'</b></em> Details</h5>";
                    } else {
                        echo '<h5>Individual Fact Details</h5>';
                    }
                ?>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <?php
                                if (isset($results)) {
                                    echo empty($results[0]) && empty($results[1]) ? 'Unknown fact name, or no details returned from server.' : print_r($results);
                                } else {
                                    echo 'Welcome to the individual Facts page. Please select a fact from the below dropdown:';
                                }
                            ?>

                            <?php
                                echo $this->Form->create();
                                echo $this->Form->select(
                                    'fact',
                                    [1, 2, 3, 4, 5]
                                );
                                echo $this->Form->submit();
                                echo $this->Form->end();
                            ?>

                            <div class="input-group">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
