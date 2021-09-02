<?php

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
]

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
                            // If the results value is set, then display value information, otherwise display greeting message
                                if (isset($results)) {
                                    if (!array_filter(array_map('array_filter', $results))) {
                                      echo 'Unknown fact name, or no details returned from server.';
                                    } else {
                                        if (in_array($fact, $knownFacts)) {
                                            echo "Known fact";
                                        } else {
                                            foreach ($results as $result) {
                                                debug($result);
                                            }
                                        }

                                    }
                                } else {
                                    echo 'Welcome to the individual Facts page. Please select a fact from the below dropdown:';
                                }
                            ?>

                            <hr />
                            <div class="form-group">
                                <?php
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
