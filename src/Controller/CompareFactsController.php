<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Http\Exception\InternalErrorException;
use Cake\I18n\FrozenTime;

/**
 * Facts Controller
 */
class CompareFactsController extends AppController
{

    /**
     * Check to see if the user is signed in first
     * @param EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Capture query params if passed
        $queryString = '?';
        foreach ($this->request->getQueryParams() as $key => $value) {
            $queryString .= $key . '=' . $value . '&';
        }
        $queryString = Substr_replace($queryString, "", -1);

        $path = $this->request->getPath();
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null) {
            $this->Flash->error("Please sign in first...");
            $this->redirect('/users/login?redirect=' . $path . $queryString);
        }
    }

    /**
     * Index method
     */
    public function index() {
        // Redirect index controller to compare
        $this->redirect(['action' => 'compare']);
    }

    /**
     * Compare method
     */
    public function compare() {
        // Set the dropdown box option variables
        $this->set('historicalFactTimeStampOptions', $this->getHistoricalFactTimeStamps());
        $this->set('knownFacts', $this->getKnownFactsArray());
        $this->loadModel('HistoricalFacts');

        // Convert POST request into a GET request with parameters
        if ($this->request->is('post')) {
            $idOne = $this->request->getData('timestamp_one');
            $idTwo = $this->request->getData('timestamp_two');
            $selectedFact = $this->request->getData('fact');

            $this->redirect(['action' => 'compare', '?' => ['timestamp_one' => $idOne, 'timestamp_two' => $idTwo, 'fact' => $selectedFact]]);
        }

        // Get parameters from query
        $idOne = $this->request->getQuery('timestamp_one');
        $idTwo = $this->request->getQuery('timestamp_two');
        $selectedFact = $this->request->getQuery('fact');

        // If both IDs are the same, then display error message and redirect
        if ($idOne !== null && $idTwo !== null) {
            if ($idOne === $idTwo) {
                $this->Flash->error("Please select two different times to compare!");
                $this->redirect(['action' => 'compare']);
            }
        }

        // Ensure all data is here before continuing
        if ($idOne && $idTwo && $selectedFact) {
            // Get the selected fact data for the given HistoricalFact set
            try {
                $factSetOne = $this->HistoricalFacts->get($idOne)->$selectedFact;
                $factSetTwo = $this->HistoricalFacts->get($idTwo)->$selectedFact;
            } catch (RecordNotFoundException $exception) {
                throw new InternalErrorException(__('Unable to locate record. Please check IDs provided.'));
            }

            // Set view variables
            $this->set('factSetOne', json_decode($factSetOne));
            $this->set('factSetTwo', json_decode($factSetTwo));
            $this->set('timeStampOne', $this->HistoricalFacts->get($idOne)->timestamp);
            $this->set('timeStampTwo', $this->HistoricalFacts->get($idTwo)->timestamp);
            $this->set('selectedFact', $selectedFact);
        }

    }

    /**
     * Helper function to obtain all HistoricalFacts timestamps combined with their dates
     * @return array of HistoricalFact IDs and corresponding timestamps
     */
    protected function getHistoricalFactTimeStamps() {
        // Get all the HistoricalFacts
        $this->loadModel('HistoricalFacts');
        $historicalFacts = $this->HistoricalFacts->find()->select(['id', 'timestamp'])->order(['timestamp' => 'desc'])->all();
        $historicalFactsTimeStamps = [];

        // Iterate over all of them to get their timestamps
        foreach($historicalFacts as $historicalFact) {
            $time = new FrozenTime($historicalFact->timestamp);
            $historicalFactsTimeStamps[$historicalFact->id] = $time->i18nFormat('dd/MM/yyyy HH:mm:ss');
        }
        return $historicalFactsTimeStamps;
    }

    /**
     * Helper function that returns all the current Known Facts, alongside their plain-English descriptions
     * @return string[] of Known Facts mapped to their English descriptions
     */
    protected function getKnownFactsArray() {
        return [
            "schoolbox_totalusers" => "Schoolbox Total Users",
            "schoolbox_config_site_type" => "Schoolbox Site Type",
            "schoolbox_users_student" => "Schoolbox Total Students",
            "schoolbox_users_staff" => "Schoolbox Total Staff",
            "schoolbox_users_parent" => "Schoolbox Total Parents",
            "schoolbox_totalcampus" => "Schoolbox Total Campus",
            "schoolbox_package_version" => "Schoolbox Package Versions",
            "schoolboxdev_package_version" => "SchoolboxDev Package Versions",
            "virtual" => "Virtual",
            "lsbdistdescription" => "Linux Versions",
            "kernelmajversion" => "Kernel Major Versions",
            "kernelrelease" => "Kernel Releases",
            "php_cli_version" => "PHP CLI Version",
            "mysql_extra_version" => "MySQL Version",
            "processorcount" => "Processor Count",
            "memorysize" => "RAM Size",
            "schoolbox_config_date_timezone" => "Schoolbox Server Timezone",
            "schoolbox_config_external_type" => "Schoolbox External DB Type",
            "schoolbox_first_file_upload_year" => "Schoolbox First File Year Upload"
        ];
    }
}
