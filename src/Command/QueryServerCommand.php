<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use Cake\Http\Client\AdapterInterface;
use Cake\Http\Client\Request;

class QueryServerCommand extends Command
{

    public function execute(Arguments $args, ConsoleIo $io)
    {
        // List of PuppetDB Servers used by Schoolbox
        $puppetDbServers = ['https://puppetdb.stg.1.schoolbox.com.au', 'https://puppetdb.prd.1.schoolbox.com.au'];

        // Fact URL path
        $path = '/pdb/query/v4/facts?query=';

        $fact = 'schoolbox_users_student';

        // Create a valid queryString
        $QueryString = urlencode(sprintf('["=", "name", "%s"]', $fact));

        // Create the HTTP Client
        $client = new Client();

        $results = [];
        // For each PuppetDB server, execute a query
        foreach($puppetDbServers as $server) {
            $formattedQuery = $server . $path . $QueryString;

            // Execute request and get response
            $response = $client->get(
                $formattedQuery,
                [], // For whatever reason, there is no reason to turn off encoding here, so the urlencode() value from above is encoded twice.
                // For that reason, the queryStringg is just appended straight to the URL rather than using the query value.
                ['auth' => ['username' => 'monash', 'password' => 'ywtsghpsqhsbxg']]
            );
            array_push($results, $response->getJson());
        }


        // Example test code
        $totalStudentFleetCount = 0;
        foreach ($results as $server) {
            foreach ($server as $individualServer) {
                if (stripos($individualServer['certname'], '.live.') || stripos($individualServer['certname'], '.prd.')) {
                    $totalStudentFleetCount += is_array($individualServer['value']) ? array_sum($individualServer['value']) : $individualServer['value'];
                }
            }
        }

        return $totalStudentFleetCount;

    }
    public static function defaultName(): string
    {
        return 'test2';
    }
}
