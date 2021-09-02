<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Client;

/**
 * Facts Controller
 */
class FactsController extends AppController
{

    /**
     * Check to see if the user is signed in first
     * @param EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $path = $this->request->getPath();
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null) {
            $this->redirect('/users/login?redirect=' . $path);
        }
    }

    private function getDetailsFromServer($fact) {
        // List of PuppetDB Servers used by Schoolbox
        $puppetDbServers = ['https://puppetdb.stg.1.schoolbox.com.au', 'https://puppetdb.prd.1.schoolbox.com.au'];

        // Fact URL path
        $path = '/pdb/query/v4/facts?query=';

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
                [], // For whatever reason, there is no way to turn off encoding here, so the urlencode() value from above is encoded twice.
                // For that reason, the queryString is just appended straight to the URL rather than using the query value.
                ['auth' => ['username' => 'monash', 'password' => 'ywtsghpsqhsbxg']]
            );
            array_push($results, $response->getJson());
        }

        return $results;
    }


    /**
     * FactDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function factDetails() {


        $fact = $this->request->getQuery('fact');

        // Check if a fact name has been provided, and set it as a variable
        if ($fact) {
            $this->set('fact', $fact);
            // Get the results from the server for this fact and then return details
            $this->set('results', $this->getDetailsFromServer($fact));
        }

    }
}
