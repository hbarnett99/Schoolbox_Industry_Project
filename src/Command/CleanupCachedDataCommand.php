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
        $currentTime = new DateTime();
        $currentTime = $currentTime->format('Y-m-d');

        // Generate current date, minus 6 months
        $currentTimeMinusSixMonths = new DateTime($currentTime);
        $currentTimeMinusSixMonths = $currentTimeMinusSixMonths->modify("-6 months");
        $currentTimeMinusSixMonths = $currentTimeMinusSixMonths->format('Y-m-d');

        // Generate current date, minus 3 months
        $currentTimeMinusThreeMonths = new DateTime($currentTime);
        $currentTimeMinusThreeMonths = $currentTimeMinusThreeMonths->modify("-3 months");
        $currentTimeMinusThreeMonths = $currentTimeMinusThreeMonths->format('Y-m-d');

        // Generate current date, minus a month
        $currentTimeMinusOneMonth = new DateTime($currentTime);
        $currentTimeMinusOneMonth = $currentTimeMinusOneMonth->modify("-1 month");
        $currentTimeMinusOneMonth = $currentTimeMinusOneMonth->format('Y-m-d');

        // Create arrays for IDs that are contained within the relevant time period
        $greaterThanAMonthLessThanThreeMonthsIds = [];
        $greaterThanThreeMonthsLessThanSixMonthsIds = [];
        $greaterThanSixMonthsIds = [];

        // Iterate through all historical fact sets
        foreach ($allHistoricalFacts as $factSet) {
            $timestamp = new DateTime($factSet->timestamp);
            $timestamp = $timestamp->format('Y-m-d');

            // Get all the dates between >1 month ago and <3 months ago
            if (($currentTimeMinusOneMonth >= $timestamp) && ($timestamp >= $currentTimeMinusThreeMonths)) {
                if (!array_key_exists($timestamp, $greaterThanAMonthLessThanThreeMonthsIds)) {
                    $greaterThanAMonthLessThanThreeMonthsIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($greaterThanAMonthLessThanThreeMonthsIds[$timestamp], $factSet->id);
                }
            }

            // Get all the dates between >3 months ago and <6 months ago
            if (($currentTimeMinusThreeMonths >= $timestamp) && ($timestamp >= $currentTimeMinusSixMonths)) {
                if (!array_key_exists($timestamp, $greaterThanThreeMonthsLessThanSixMonthsIds)) {
                    $greaterThanThreeMonthsLessThanSixMonthsIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($greaterThanThreeMonthsLessThanSixMonthsIds[$timestamp], $factSet->id);
                }
            }

            // Get all the dates >6 months ago
            if ($currentTimeMinusSixMonths >= $timestamp) {
                if (!array_key_exists($timestamp, $greaterThanSixMonthsIds)) {
                    $greaterThanSixMonthsIds[$timestamp] = [$factSet->id];
                } else {
                    array_push($greaterThanSixMonthsIds[$timestamp], $factSet->id);
                }
            }
        }

        // ==== DELETING > 1 MONTH DATA ==== //

        // Leave only one per day after a month, but less than three months
        foreach ($greaterThanAMonthLessThanThreeMonthsIds as $day) {
            // Remove the latest entry for each day
            $day = array_splice($day, 1);

            // Iterate through and delete every other value
            foreach ($day as $value) {
                $historicalFact = $this->HistoricalFacts->get($value);
                $this->HistoricalFacts->delete($historicalFact);
            }
        }

//        debug($greaterThanThreeMonthsLessThanSixMonthsIds);
//        die;

        // Create an array of months containing the IDs of each date within the month
        $months = [];
        foreach ($greaterThanSixMonthsIds as $date => $value) {
            $date = new DateTime($date);
            $date = $date->format('m');
            if (!array_key_exists($date, $months)) {
                $months[$date] = $value;
            } else {
                array_push($months[$date], $value[0]);
            }
        }

        // Leave only one value per month after 6 months
        foreach ($months as $month) {
            // Remove the latest entry for each day
            $month = array_splice($month, 1);

            // Iterate through and delete every other value
            foreach ($month as $value) {
                $historicalFact = $this->HistoricalFacts->get($value);
                $this->HistoricalFacts->delete($historicalFact);
            }
        }

    }

    public static function defaultName(): string {
        return 'cleanupCachedData';
    }
}
