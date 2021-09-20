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
        $currentTimeMinusSixMonths = date('Y-m-d', strtotime("-6 months", strtotime($currentTime)));
        $currentTimeMinusThreeMonths = date('Y-m-d', strtotime("-3 months", strtotime($currentTime)));
        $currentTimeMinusOneMonth = date('Y-m-d', strtotime("-1 month", strtotime($currentTime)));

        // Create arrays for IDs that are contained within the relevant time period
        $withinMonthDateIds = [];
        $withinThreeMonthsDateIds = [];
        $greaterThanSixMonthsDateIds = [];

        // Iterate through all historical fact sets
        foreach ($allHistoricalFacts as $factSet) {
            $timestamp = $factSet->timestamp->format('Y-m-d');
            if (($timestamp >= $currentTimeMinusThreeMonths) && ($timestamp < $currentTimeMinusSixMonths)) {
                debug($timestamp); die;
            }

            // If timestamp is within the range of a month ago to today's date
            if ($timestamp <= $currentTimeMinusOneMonth && $timestamp > $currentTimeMinusThreeMonths) {
                // Add to the array of dates, indexed by key (date stamp)
                if (!array_key_exists($timestamp, $withinMonthDateIds)) {
                    $withinMonthDateIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($withinMonthDateIds[$timestamp], $factSet->id);
                }
            // If timestamp is within the range of three months ago to a month ago (from current date)
            } else if ($timestamp >= $currentTimeMinusThreeMonths && $timestamp > $currentTimeMinusSixMonths) {
                // Add to the array of dates, indexed by key (date stamp)
                if (!array_key_exists($timestamp, $withinThreeMonthsDateIds)) {
                    $withinThreeMonthsDateIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($withinThreeMonthsDateIds[$timestamp], $factSet->id);
                }
            // If the timestamp is greater than six months old (from current date)
            } else if ($timestamp <= $currentTimeMinusSixMonths) {
                // Add to the array of dates, indexed by key (date stamp)
                if (!array_key_exists($timestamp, $greaterThanSixMonthsDateIds)) {
                    $greaterThanSixMonthsDateIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($greaterThanSixMonthsDateIds[$timestamp], $factSet->id);
                }
            }
        }

//        debug($withinMonthDateIds);
//        debug($withinThreeMonthsDateIds);
//        debug($greaterThanSixMonthsDateIds);
        die;

    }

    public static function defaultName(): string {
        return 'cleanupCachedData';
    }
}
