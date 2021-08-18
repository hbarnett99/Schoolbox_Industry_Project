<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;

class QueryServerCommand extends Command
{

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

        //$fact = 'schoolbox_users_student';

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

    public function performQuery(string $fact) {
        switch($fact) {
            case "schoolbox_totalusers":
                return schoolbox_totalusers($this->sendRequest('schoolbox_totalusers'));
            case "schoolbox_config_site_type":
                return "Not yet implemented";
            case "schoolbox_users_student":
                return schoolbox_users_student($this->sendRequest('schoolbox_users_student'));
            case "schoolbox_users_staff":
                return schoolbox_users_staff($this->sendRequest('schoolbox_users_staff'));
            case "schoolbox_users_parent":
                return schoolbox_users_parent($this->sendRequest('schoolbox_users_parent'));
            case "schoolbox_totalcampus":
                return schoolbox_totalcampus($this->sendRequest('schoolbox_totalcampus'));
            case "schoolbox_package_version":
                return "Not yet implemented";
            case "schoolboxdev_package_version":
                return "Not yet implemented";
            case "schoolbox_config_site_version":
                return "Not yet implemented";
            case "schoolbox_users_student":
                return "Not yet implemented";
            case "virtual":
                return "Not yet implemented";
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
                return "Not yet implemented";
            case "memorysize":
                return "Not yet implemented";
            case "schoolbox_config_date_timezone":
                return "Not yet implemented";
            case "schoolbox_config_external_type":
                return "Not yet implemented";
            case "schoolbox_first_file_upload_year":
                return "Not yet implemented";
            default:
                break;
        }
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        //$results = $this->sendRequest('schoolbox_users_staff');
        //debug($results);

        // Ensure there is a factnames.json file present
        if (!file_exists(dirname(__FILE__) . '/res/factnames.json')) {
            $io->abort("ABORTING: Please ensure a the keys file (named factnames.json) is within the working directory.");
        }

        $factKeys = $this->getFactKeys();

        $results = [];
        foreach ($factKeys as $fact) {
            array_push($results, $this->performQuery($fact));
        }

        debug($results);


    }
    public static function defaultName(): string {
        return 'queryPuppetDb';
    }
}
