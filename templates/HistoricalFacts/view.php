<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HistoricalFact $historicalFact
 */
?>

<?php
// Helper sort function. Takes an array and returns it in descending order of a 'count' value.
function sortByCountDescending($array)
{
    uasort($array, function ($a, $b) {
        return $b['count'] - $a['count'];
    });
    return $array;
}

// Only show breadcrumbs when not on main page
if ($this->getRequest()->getPath() != '/historical-facts/newest-data') {
    $this->Breadcrumbs->add([
        ['title' => 'Historical Facts', 'url' => ['controller' => 'historical-facts', 'action' => 'index']],
        ['title' => 'Fact Sets', 'url' => ['controller' => 'historical-facts', 'action' => 'index']],
        ['title' => $this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null), 'url' => ['controller' => 'historicalfacts', 'action' => 'view', $historicalFact->id]]
    ]);
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
                <?= $this->Flash->render() ?>
                <div class="row">
                    <div class="col">
                        <h4><?= __('Fact Set') ?> as
                            of <?= h($this->Time->format($historicalFact->timestamp, \IntlDateFormatter::MEDIUM, null)) ?></h4>
                    </div>
                    <div class="col">
                        <div class="action-buttons pb-2 float-end">
                            <?php if ($this->getRequest()->getPath() != '/historical-facts/newest-data') {
                                echo $this->Form->postLink(__('<i class="fas fa-trash"></i> Delete'), ['action' => 'delete', $historicalFact->id], ['confirm' => __('Are you sure you want to delete # {0}?', $historicalFact->id), 'class' => 'btn btn-danger mx-1', 'escape' => false]);
                                echo $this->Html->link(__('<i class="fas fa-list"></i> View all Facts'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false]);
                            } ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group px-4">
                            <input type="search" id="accordion_search_bar" class="form-control"
                                   placeholder="Type here to search by fact name!">
                        </div>
                        <div class="row p-4">
                            <div class="col">
                                <!-- Begin Accordion -->
                                <div class="accordion" id="factsAccordion">
                                    <div class="row">
                                        <div class="col" id="accordionColOne">
                                            <!-- Accordion Item (Total Users) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalUsersCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Total Users</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalUsersCollapse" class="accordion-collapse collapse show"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?=
                                                            number_format(intval(json_decode($historicalFact->schoolbox_totalusers, JSON_PRETTY_PRINT)['totalUsersFleetCount']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (User Distribution) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalUserCountDistributionCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>User Count Distribution</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalUserCountDistributionCollapse"
                                                         class="accordion-collapse collapse" aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_totalusers, JSON_PRETTY_PRINT)['totalUsers'];
                                                            // Sort the array by key from low high to low
                                                            krsort($details);
                                                            foreach ($details as $key => $detail) {
                                                                // If the key is 0, then replace with < 1000.
                                                                if ($key == 0) {
                                                                    echo '< ' . 1000 . " : " . $detail . "<br />";
                                                                } else {
                                                                    echo '> ' . number_format($key * 1000) . " : " . $detail . "<br />";
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Total Student) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalStudentsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Total Students</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalStudentsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?=
                                                            number_format(intval(json_decode($historicalFact->schoolbox_users_student, JSON_PRETTY_PRINT)['totalStudentCount']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Total Staff) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalStaffCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Total Staff</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalStaffCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?=
                                                            number_format(intval(json_decode($historicalFact->schoolbox_users_staff, JSON_PRETTY_PRINT)['totalStaffCount']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Total Parents) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalParentsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Total Parents</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalParentsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?=
                                                            number_format(intval(json_decode($historicalFact->schoolbox_users_parent, JSON_PRETTY_PRINT)['totalParentCount']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Total Campus) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#totalCampusCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Total Campuses</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="totalCampusCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?=
                                                            number_format(intval(json_decode($historicalFact->schoolbox_totalcampus, JSON_PRETTY_PRINT)['totalCampus']));
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Production Schoolbox Package Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#schoolboxPackageVersionsCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>Production 'Schoolbox' Package Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="schoolboxPackageVersionsCollapse"
                                                         class="accordion-collapse collapse" aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <table id="schoolboxPackageVersionsTable" class="table table-responsive">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Key</th>
                                                                        <th>Count</th>
                                                                        <th>Percent</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php
                                                                $details = json_decode($historicalFact->schoolbox_package_version, JSON_PRETTY_PRINT)['productionPackageVersions'];

                                                                // Sort the array
                                                                $details = sortByCountDescending($details);

                                                                foreach ($details as $key => $detail) {
                                                                    echo "<tr>
                                                                            <td>". $key . "</td>
                                                                            <td>" . $detail['count'] . "</td>
                                                                            <td>" . $detail['percent'] . "%" . "</td>
                                                                          </tr>";
                                                                }
                                                                ?>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Production Schoolboxdev Package Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#schoolboxDevPackageVersionsCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>Production 'Schoolboxdev' Package Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="schoolboxDevPackageVersionsCollapse"
                                                         class="accordion-collapse collapse" aria-labelledby="totalUsersHeading"
                                                    >
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_package_version, JSON_PRETTY_PRINT)['developmentPackageVersions'];

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Staging Schoolbox Package Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#stagingSchoolboxPackageVersionsCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>Staging 'Schoolbox' Package Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="stagingSchoolboxPackageVersionsCollapse"
                                                         class="accordion-collapse collapse" aria-labelledby="totalUsersHeading"
                                                    >
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolboxdev_package_version, JSON_PRETTY_PRINT)['productionPackageVersions'];

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Staging Schoolboxdev Package Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#stagingSchoolboxDevPackageVersionsCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>Staging 'Schoolboxdev' Package Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="stagingSchoolboxDevPackageVersionsCollapse"
                                                         class="accordion-collapse collapse" aria-labelledby="totalUsersHeading"
                                                    >
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolboxdev_package_version, JSON_PRETTY_PRINT)['developmentPackageVersions'];

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Production Site Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#productionSiteVersionsCollapse"
                                                                aria-expanded="true" aria-controls="totalUsersCollapse">
                                                            <strong>Production Site Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="productionSiteVersionsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_config_site_version, JSON_PRETTY_PRINT)['productionServers'];

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                        </div>
                                        <div class="col" id="accordionColTwo">
                                            <!-- Accordion Item (Staging Site Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#stagingSiteVersionsCollapse"
                                                                aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Staging Site Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="stagingSiteVersionsCollapse"
                                                         class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_config_site_version, JSON_PRETTY_PRINT)['stagingServers'];

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Virtual) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#virtualCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Virtual</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="virtualCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->virtual, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Linux Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#linuxVersionsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Linux Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="linuxVersionsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->lsbdistdescription, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Kernel Major Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#kernelVersionsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Kernel Major Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="kernelVersionsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->kernelmajversion, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Kernel Releases) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#kernelReleasesCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Kernel Releases</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="kernelReleasesCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->kernelrelease, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (PHP CLI Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#phpVersionsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>PHP CLI Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="phpVersionsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->php_cli_version, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (MySQL Versions) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#mysqlVersionsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>MySQL Versions</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="mysqlVersionsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->mysql_extra_version, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Number of Processors) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#processorsCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Number of Processors</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="processorsCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->processorcount, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (RAM Size) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#ramSizeCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>RAM Size</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="ramSizeCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->memorysize, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Schoolbox Config - Date / Time) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#dateTimeZoneCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Schoolbox Config - Date / Timezone</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="dateTimeZoneCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_config_date_timezone, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Schoolbox Config - External DB Type) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#externalDbCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Schoolbox Config - External DB Type</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="externalDbCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_config_external_type, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- Accordion Item (Schoolbox - First File Upload Date) Begin -->
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="totalUsersHeading">
                                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#firstFileCollapse" aria-expanded="true"
                                                                aria-controls="totalUsersCollapse">
                                                            <strong>Schoolbox - First File Upload Year</strong>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3"
                                                               aria-hidden="true"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="firstFileCollapse" class="accordion-collapse collapse"
                                                         aria-labelledby="totalUsersHeading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <?php
                                                            $details = json_decode($historicalFact->schoolbox_first_file_upload_year, JSON_PRETTY_PRINT);

                                                            // Sort the array
                                                            $details = sortByCountDescending($details);

                                                            foreach ($details as $key => $detail) {
                                                                echo $key . ' : ' . $detail['count'] . ' (' . $detail['percent'] . '%)' . "<br />";
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Accordion Item -->
                                            <!-- End Accordion -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        // Search functionality for accordion
        (function () {
            $('#accordion_search_bar').on('change keyup paste click', function () {
                var filter = $(this).val().toLowerCase(); //get text
                $("#factsAccordion [data-bs-toggle]").each(function () {
                    if ($(this).text().toLowerCase().trim().indexOf(filter) < 0) {
                        $(this).closest(".card").hide(200); //hide closest card
                        $('#accordionColOne').removeClass('col').addClass('col-0');
                        $('#accordionColTwo').removeClass('col').addClass('col-0');

                    } else {
                        $(this).closest(".card").show(200)
                        $('#accordionColOne').removeClass('col-0').addClass('col');
                        $('#accordionColTwo').removeClass('col-0').addClass('col');
                    }
                });
            });
        }());

        $(document).ready(() => {
            $('#schoolboxPackageVersionsTable').DataTable({
                paging: false,
                order: [[2, 'desc']],
                info: false
            })
        })

    </script>
