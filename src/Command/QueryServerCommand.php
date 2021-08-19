<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use DateTime;

class QueryServerCommand extends Command
{

    // Import the HistoricalFacts model
    protected $modelClass = 'HistoricalFacts';

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        require_once ('queries.php');
    }

    /**
     * Queries the Schoolbox PuppetDB servers for a given fact.
     *
     * @param string $factName the name of the fact to query
     * @return array concatenated JSON results from the server query
     */
    public function sendRequest(string $factName): array {
        // List of PuppetDB Servers used by Schoolbox
        $puppetDbServers = ['https://puppetdb.stg.1.schoolbox.com.au', 'https://puppetdb.prd.1.schoolbox.com.au'];

        // Fact URL path
        $path = '/pdb/query/v4/facts?query=';

        // Create a valid queryString
        $QueryString = urlencode(sprintf('["=", "name", "%s"]', $factName));

        // Create the HTTP Client
        $client = new Client();

        $results = [];
        // For each PuppetDB server, execute a query
        foreach($puppetDbServers as $server) {
            $formattedQuery = $server . $path . $QueryString;

            // Execute request and get response
            $response = $client->get(
                $formattedQuery,
                [], // For whatever reason, there is no way to turn off encoding here, so the urlencode() value from above is encoded twice.
                // For that reason, the queryString is just appended straight to the URL rather than using the query value.
                ['auth' => ['username' => 'monash', 'password' => 'ywtsghpsqhsbxg']]
            );
            array_push($results, $response->getJson());
        }

        return $results;
    }

    /**
     * Obtains the factnames for which to execute queries
     *
     * @return array keys within the factnames file
     */
    public function getFactKeys() : array {
        $factKeys = [];

        // Read the factnames.json file and decode to a JSON object
        $file = fopen(dirname(__FILE__) . '/res/factnames.json', "r") or die("Unable to open file!");
        $rawJson = json_decode(fread($file, filesize(dirname(__FILE__) . '/res/factnames.json')));
        fclose($file);

        // Get only the raw keys from the JSON file
        foreach ($rawJson as $key => $value) {
            array_push($factKeys, trim($key));
        }

        return $factKeys;
    }

    /**
     * Queries the server for a particular fact, and performs data agregation / business logic
     * on the returned values
     *
     * @param string $fact the fact to perform business analytics on
     * @return array array of formatted / business validated data
     */
    public function performQuery(string $fact): array {
        switch($fact) {
            case "schoolbox_totalusers":
                return schoolbox_totalusers($this->sendRequest('schoolbox_totalusers'));
            case "schoolbox_config_site_type":
                return schoolbox_config_site_type($this->sendRequest('schoolbox_config_site_type'));
            case "schoolbox_users_student":
                return schoolbox_users_student($this->sendRequest('schoolbox_users_student'));
            case "schoolbox_users_staff":
                return schoolbox_users_staff($this->sendRequest('schoolbox_users_staff'));
            case "schoolbox_users_parent":
                return schoolbox_users_parent($this->sendRequest('schoolbox_users_parent'));
            case "schoolbox_totalcampus":
                return schoolbox_totalcampus($this->sendRequest('schoolbox_totalcampus'));
            case "schoolbox_package_version":
                return schoolbox_package_version($this->sendRequest('schoolbox_package_version'));
            case "schoolboxdev_package_version":
                return schoolboxdev_package_version($this->sendRequest('schoolboxdev_package_version'));
            case "schoolbox_config_site_version":
                return schoolbox_config_site_version($this->sendRequest('schoolbox_config_site_version'));
            case "virtual":
                return virtual($this->sendRequest('virtual'));
            case "lsbdistdescription":
                return lsbdistdescription($this->sendRequest('lsbdistdescription'));
            case "kernelmajversion":
                return kernelmajversion($this->sendRequest('kernelmajversion'));
            case "kernelrelease":
                return kernelrelease($this->sendRequest('kernelrelease'));
            case "php_cli_version":
                return php_cli_version($this->sendRequest('php_cli_version'));
            case "mysql_extra_version":
                return mysql_extra_version($this->sendRequest('mysql_extra_version'));
            case "processorcount":
                return processorcount($this->sendRequest('processorcount'));
            case "memorysize":
                return memorysize($this->sendRequest('memorysize'));
            case "schoolbox_config_date_timezone":
                return schoolbox_config_date_timezone($this->sendRequest('schoolbox_config_date_timezone'));
            case "schoolbox_config_external_type":
                return schoolbox_config_external_type($this->sendRequest('schoolbox_config_external_type'));
            case "schoolbox_first_file_upload_year":
                return schoolbox_first_file_upload_year($this->sendRequest('schoolbox_first_file_upload_year'));
            default:
                break;
        }
        return ['message' => 'An error occurred.'];
    }

    /**
     * Inserts the data obtained from previous business analytics into the database
     *
     * @param array $results results obtained from performing business analytics
     * @return int 1 if successful, 0 if failure
     */
    public function insertIntoDb($results) {
        // Get current time
        $now = new DateTime('Australia/Melbourne');
        $timestamp = $now->format('Y-m-d H:i:s');

        // Create the HistoricalFact model and put the values from $results into it
        $historicalFactSet = $this->HistoricalFacts->newEmptyEntity();
        $historicalFactSet->timestamp = $timestamp;
        $historicalFactSet->schoolbox_totalusers = json_encode($results['schoolbox_totalusers']);
        $historicalFactSet->schoolbox_config_site_type = json_encode($results['schoolbox_config_site_type']);
        $historicalFactSet->schoolbox_users_student = json_encode($results['schoolbox_users_student']);
        $historicalFactSet->schoolbox_users_staff = json_encode($results['schoolbox_users_staff']);
        $historicalFactSet->schoolbox_users_parent = json_encode($results['schoolbox_users_parent']);
        $historicalFactSet->schoolbox_totalcampus = json_encode($results['schoolbox_totalcampus']);
        $historicalFactSet->schoolbox_package_version = json_encode($results['schoolbox_package_version']);
        $historicalFactSet->schoolboxdev_package_version = json_encode($results['schoolboxdev_package_version']);
        $historicalFactSet->schoolbox_config_site_version = json_encode($results['schoolbox_config_site_version']);
        $historicalFactSet->virtual = json_encode($results['virtual']);
        $historicalFactSet->lsbdistdescription = json_encode($results['lsbdistdescription']);
        $historicalFactSet->kernelmajversion = json_encode($results['kernelmajversion']);
        $historicalFactSet->kernelrelease = json_encode($results['kernelrelease']);
        $historicalFactSet->php_cli_version = json_encode($results['php_cli_version']);
        $historicalFactSet->mysql_extra_version = json_encode($results['mysql_extra_version']);
        $historicalFactSet->processorcount = json_encode($results['processorcount']);
        $historicalFactSet->memorysize = json_encode($results['memorysize']);
        $historicalFactSet->schoolbox_config_date_timezone = json_encode($results['schoolbox_config_date_timezone']);
        $historicalFactSet->schoolbox_config_external_type = json_encode($results['schoolbox_config_external_type']);
        $historicalFactSet->schoolbox_first_file_upload_year = json_encode($results['schoolbox_first_file_upload_year']);

        // Attempt to save the object into the Model
        if ($this->HistoricalFacts->save($historicalFactSet)) {
            return 1;
        } else {
            return 0;
        }
    }


    /**
     * Main execution function for the command
     *
     * @param Arguments $args arugments for the command
     * @param ConsoleIo $io CakePHP I/O object
     * @return int|void|null 1 if successful, 0 if failure
     */
    public function execute(Arguments $args, ConsoleIo $io) {
        // Ensure there is a factnames.json file present
        if (!file_exists(dirname(__FILE__) . '/res/factnames.json')) {
            $io->abort("ABORTING: Please ensure a the keys file (named factnames.json) is within the working directory.");
        }

        $factKeys = $this->getFactKeys();

        // Get all of the facts from the PuppetDB and execute business analytics on them
        $results = [];
        foreach ($factKeys as $fact) {
            echo "Executing query for '" . $fact . "'. Please wait.\n";
            $results[$fact] = $this->performQuery($fact);
        }

        // Insert the returned facts into the DB
        if($this->insertIntoDb($results) == 1) {
            $io->success("Successfully inserted values into DB!");
            return 1;
        } else {
            $io->abort("Error with adding values into DB! Please, try again.", 0);
        }

    }
    public static function defaultName(): string {
        return 'queryPuppetDb';
    }
}
