<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact $historicalFact
 */
?>

<?php
    // Helper sort function. Takes an array and returns it in descending order of a 'count' value.
    function sortByCountDescending($array) {
        uasort($array, function($a, $b) {
            return $b['count'] - $a['count'];
        });
        return $array;
    }
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(__('Delete Historical Fact'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalFact->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Historical Facts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="historicalFacts view content">
            <table>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Total Users') ?></strong>
                <blockquote>
                    <?=
                        number_format(intval(json_decode($historicalFact->schoolbox_totalusers, JSON_PRETTY_PRINT)['totalUsersFleetCount']));
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('User Count Distribution') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_totalusers, JSON_PRETTY_PRINT)['totalUsers'];
                        // Sort the array by key from low high to low
                        krsort($details);
                        foreach($details as $key => $detail) {
                            // If the key is 0, then replace with < 1000.
                            if ($key == 0) {
                                echo '< ' . 1000 . " : " . $detail . "<br />";
                            } else {
                                echo '> ' . number_format($key * 1000) . " : " . $detail . "<br />";
                            }
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Total Students') ?></strong>
                <blockquote>
                    <?=
                        number_format(intval(json_decode($historicalFact->schoolbox_users_student, JSON_PRETTY_PRINT)['totalStudentCount']));
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Total Staff') ?></strong>
                <blockquote>
                    <?=
                        number_format(intval(json_decode($historicalFact->schoolbox_users_staff, JSON_PRETTY_PRINT)['totalStaffCount']));
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Total Parents') ?></strong>
                <blockquote>
                    <?=
                        number_format(intval(json_decode($historicalFact->schoolbox_users_parent, JSON_PRETTY_PRINT)['totalParentCount']));
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Total Campuses') ?></strong>
                <blockquote>
                    <?=
                        number_format(intval(json_decode($historicalFact->schoolbox_totalcampus, JSON_PRETTY_PRINT)['totalCampus']));
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Production \'Schoolboox\' Package Version') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_package_version, JSON_PRETTY_PRINT)['productionPackageVersions'];

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Production \'Schoolboxdev\' Package Version') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_package_version, JSON_PRETTY_PRINT)['developmentPackageVersions'];

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Staging \'Schoolbox\' Package Version') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolboxdev_package_version, JSON_PRETTY_PRINT)['productionPackageVersions'];

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Staging \'Schoolboxdev\' Package Version') ?></strong>
                <blockquote>
                    <?php
                    $details = json_decode($historicalFact->schoolboxdev_package_version, JSON_PRETTY_PRINT)['developmentPackageVersions'];

                    // Sort the array
                    $details = sortByCountDescending($details);

                    foreach($details as $key => $detail) {
                        echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                    }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Production Site Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_config_site_version, JSON_PRETTY_PRINT)['productionServers'];

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Staging Site Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_config_site_version, JSON_PRETTY_PRINT)['stagingServers'];

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Virtual') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->virtual, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Linux Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->lsbdistdescription, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Kernel Major Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->kernelmajversion, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Kernel Releases') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->kernelrelease, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('PHP CLI Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->php_cli_version, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('MySQL Versions') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->mysql_extra_version, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Number of Processors') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->processorcount, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('RAM Size') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->memorysize, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . 'GB : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config - Date / Timezone') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_config_date_timezone, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox Config - External DB Type') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_config_external_type, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Schoolbox - First File Upload Year') ?></strong>
                <blockquote>
                    <?php
                        $details = json_decode($historicalFact->schoolbox_first_file_upload_year, JSON_PRETTY_PRINT);

                        // Sort the array
                        $details = sortByCountDescending($details);

                        foreach($details as $key => $detail) {
                            echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                        }
                    ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
