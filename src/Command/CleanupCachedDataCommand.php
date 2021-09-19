<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use DateTime;

class CleanupCachedDataCommand extends Command
{

    // Import the HistoricalFacts model
    protected $modelClass = 'HistoricalFacts';

    /**
     * Main execution function for the command
     *
     * @param Arguments $args arguments for the command
     * @param ConsoleIo $io CakePHP I/O object
     * @return int|void|null 1 if successful, 0 if failure
     */
    public function execute(Arguments $args, ConsoleIo $io) {
        // Get all Historical Facts, with timestamps descending
        $allHistoricalFacts = $this->HistoricalFacts->find('all', [
            'order' => ['timestamp' => 'DESC']
        ]);

        // Get current timestamp, and timestamps from previous time periods
        $currentTime = date('Y-m-d');
        $timeStampMinusSixMonths = date('Y-m-d', strtotime("-6 months", strtotime($currentTime)));

        // Iterate through all historical fact sets
        foreach ($allHistoricalFacts as $factSet) {
            $timestamp = $factSet->timestamp->format('Y-m-d');

            if ($timestamp < $timeStampMinusSixMonths) {
                echo $factSet->timestamp . " is less older than six months \n";

            } else {
                echo $factSet->timestamp . " is within the last six months. \n";
            }
        }

    }

    public static function defaultName(): string {
        return 'cleanupCachedData';
    }
}
