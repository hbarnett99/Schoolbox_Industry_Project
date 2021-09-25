<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Client;
require_once(__DIR__ . '\..\Command\queries.php');


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
        // Redirect index page to the factDetails page
        $this->redirect(['action' => 'factDetails']);
    }

    /**
     * Queries the Schoolbox PuppetDB servers for a given fact.
     *
     * @param string $factName the name of the fact to query
     * @return array concatenated JSON results from the server query
     */
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
     * Queries the server for a particular fact, and performs data agregation / business logic
     * on the returned values
     *
     * @param string $fact the fact to perform business analytics on
     * @return array array of formatted / business validated data
     */
    public function performQuery(string $fact): array {
        switch($fact) {
//            case "schoolbox_totalusers":
//                return schoolbox_totalusers($this->getDetailsFromServer('schoolbox_totalusers'));
//            case "schoolbox_config_site_type":
//                return schoolbox_config_site_type($this->getDetailsFromServer('schoolbox_config_site_type'));
//            case "schoolbox_users_student":
//                return schoolbox_users_student($this->getDetailsFromServer('schoolbox_users_student'));
//            case "schoolbox_users_staff":
//                return schoolbox_users_staff($this->getDetailsFromServer('schoolbox_users_staff'));
//            case "schoolbox_users_parent":
//                return schoolbox_users_parent($this->getDetailsFromServer('schoolbox_users_parent'));
//            case "schoolbox_totalcampus":
//                return schoolbox_totalcampus($this->getDetailsFromServer('schoolbox_totalcampus'));
//            case "schoolbox_package_version":
//                return schoolbox_package_version($this->getDetailsFromServer('schoolbox_package_version'));
//            case "schoolboxdev_package_version":
//                return schoolboxdev_package_version($this->getDetailsFromServer('schoolboxdev_package_version'));
//            case "virtual":
//                return virtualEnv($this->getDetailsFromServer('virtual'));
//            case "lsbdistdescription":
//                return lsbdistdescription($this->getDetailsFromServer('lsbdistdescription'));
//            case "kernelmajversion":
//                return kernelmajversion($this->getDetailsFromServer('kernelmajversion'));
//            case "kernelrelease":
//                return kernelrelease($this->getDetailsFromServer('kernelrelease'));
//            case "php_cli_version":
//                return php_cli_version($this->getDetailsFromServer('php_cli_version'));
//            case "mysql_extra_version":
//                return mysql_extra_version($this->getDetailsFromServer('mysql_extra_version'));
//            case "processorcount":
//                return processorcount($this->getDetailsFromServer('processorcount'));
//            case "memorysize":
//                return memorysize($this->getDetailsFromServer('memorysize'));
//            case "schoolbox_config_date_timezone":
//                return schoolbox_config_date_timezone($this->getDetailsFromServer('schoolbox_config_date_timezone'));
//            case "schoolbox_config_external_type":
//                return schoolbox_config_external_type($this->getDetailsFromServer('schoolbox_config_external_type'));
//            case "schoolbox_first_file_upload_year":
//                return schoolbox_first_file_upload_year($this->getDetailsFromServer('schoolbox_first_file_upload_year'));
            default:
                $returnResults = $this->getDetailsFromServer($fact);
                return array_merge($returnResults[0], $returnResults[1]);
        }
    }

    /**
     * FactDetails method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function factDetails() {

        // List of fact names
        $factNames = [
            'ipaddress' => 'ip addresses',
            'schoolbox_config_site_school_code' => 'Schoolbox config site_school_code - Unique client identifier',
            'schoolbox_instance_id' => 'Schoolbox INSTANCE_ID - Unique instance/tenant identifier',
            'schoolboxdev_instance_id' => 'Schoolbox INSTANCE_ID - Unique instance/tenant identifier',
            'schoolbox_last_backup' => 'last backup',
            'schoolbox_config_external_type' => 'external db',
            'schoolbox_config_date_timezone' => 'timezone',
            'schoolbox_config_site_version' => 'schoolbox version',
            'memorysize' => 'RAM size',
            'virtual' => 'host server type',
            'schoolbox_totalusers' => 'total schoolbox users',
            'schoolbox_users_student' => 'total schoolbox student users',
            'schoolbox_users_staff' => 'total schoolbox staff users',
            'schoolbox_users_parent' => 'total schoolbox parent users',
            'schoolbox_totalcampus' => 'schoolbox campuses',
            'processorcount' => 'number of cpu cores',
            'hardwareisa' => '32bit or 64bit',
            'lsbdistdescription' => 'server operating system version',
            'rabbitmq_queues' => 'rabbitmq total queues',
            'rabbitmq_messages' => 'rabbitmq total messages',
            'schoolbox_rmq_queues' => 'schoolbox total queues',
            'schoolbox_rmq_msg_total' => 'schoolbox total messages',
            'schoolbox_rmq_msg_unread' => 'schoolbox total unread messages',
            'schoolbox_rmq_msg_tosort' => 'schoolbox total tosort messages',
            'schoolbox_rmq_msg_other' => 'schoolbox total other messages',
            'schoolboxdev_rmq_queues' => 'schoolboxdev total queues',
            'schoolboxdev_rmq_msg_total' => 'schoolboxdev total messages',
            'schoolboxdev_rmq_msg_unread' => 'schoolboxdev total unread messages',
            'schoolboxdev_rmq_msg_tosort' => 'schoolboxdev total tosort messages',
            'schoolboxdev_rmq_msg_other' => 'schoolboxdev total other messages',
            'https_cert_expiry' => 'https certificate expiry date',
            'https_cert_type' => 'https certificate signing algorithm',
            'https_cert_issuer' => 'https certificate issuer',
            'ignore_rabbitmq' => 'servers with ignore rabbitmq config set',
            'current_puppetmaster' => 'current puppetmaster for each server',
            'schoolbox_config_amqp_admin_port' => 'amqp admin port',
            'schoolbox_config_amqp_host' => 'amqp host',
            'schoolbox_config_amqp_port' => 'amqp port',
            'schoolbox_config_amqp_stomp_port' => 'amqp stomp_port',
            'schoolbox_config_amqp_user' => 'amqp user',
            'schoolbox_config_amqp_vhost' => 'amqp vhost',
            'schoolbox_config_browser_cache_image_timeout' => 'Schoolbox Image Cache Timeout',
            'schoolbox_config_browser_cache_portrait_timeout' => 'Schoolbox Portrait Timeout',
            'schoolbox_config_jwt_public_key' => 'JWT Public Key',
            'schoolbox_config_title' => 'Title of Schoolbox install',
            'schoolbox_config_mail_address' => 'Schoolbox Client email domain',
            'schoolbox_config_saml_enabled' => 'Schoolbox SAML enabled',
            'schoolbox_config_saml_sso_url' => 'Schoolbox SAML Server URLs',
            'schoolbox_config_saml_logout_url' => 'Schoolbox SAML Server Logout URLs',
            'schoolbox_config_skin_custom_css' => 'Schoolbox Custom CSS',
            'schoolbox_config_external_db_host' => 'Schoolbox External DB Hosts',
            'schoolbox_config_external_cache_timeout' => 'Schoolbox External DB Cache Timeout in seconds',
            'schoolbox_update_error' => "schoolbox package Update Error State",
            'schoolbox_update_errormsg' => "schoolbox package Update Error State",
            'schoolboxdev_update_error' => "schoolboxdev Update Error Messages",
            'schoolboxdev_update_errormsg' => "schoolboxdev Update Error Messages",
            'tmpdir_size' => 'Temp Directory Size',
            'schoolbox_uniqueusername' => 'Schoolbox Servers with non-unique usernames',
            'postfix_queue' => 'postfix local relay queue length',
            'postfix_error' => 'postfix local relay most common error',
            'plagscan_last_error_date' => 'Plagscan Last Error Date (schoolbox)',
            'plagscan_last_error_msg' => 'Plagscan Last Error Message (schoolbox)',
            'plagscan_today_error_count' => 'Plagscan Today\'s Error Count (schoolbox)',
            'schoolbox_config_plagscan_username' => 'PlagScan Username (schoolbox)',
            'schoolbox_config_plagscan_client_id' => 'PlagScan Client ID (schoolbox)',
            'schoolbox_notif_scheduled_last_error_date' => 'Scheduled Last Error Date (schoolbox)',
            'schoolbox_notif_scheduled_last_error_msg' => 'Scheduled Last Error Message (schoolbox)',
            'schoolbox_notif_scheduled_today_error_count' => 'Scheduled Today\'s Error Count (schoolbox)',
            'schoolbox_notif_socketd_last_error_date' => 'Socketd Last Error Date (schoolbox)',
            'schoolbox_notif_socketd_last_error_msg' => 'Socketd Last Error Message (schoolbox)',
            'schoolbox_notif_socketd_today_error_count' => 'Socketd Today\'s Error Count (schoolbox)',
            'schoolbox_notif_rerouted_last_error_date' => 'Rerouted Last Error Date (schoolbox)',
            'schoolbox_notif_rerouted_last_error_msg' => 'Rerouted Last Error Message (schoolbox)',
            'schoolbox_notif_rerouted_today_error_count' => 'Rerouted Today\'s Error Count (schoolbox)',
            'schoolbox_notif_digestd_last_error_date' => 'Digestd Last Error Date (schoolbox)',
            'schoolbox_notif_digestd_last_error_msg' => 'Digestd Last Error Message (schoolbox)',
            'schoolbox_notif_digestd_today_error_count' => 'Digestd Today\'s Error Count (schoolbox)',
            'schoolbox_gc_missing_task_files' => 'schoolbox_gc_missing_task_files (schoolbox)',
            'mysql_extra_mycnf_sha1' => 'MySQL my.cnf sha1 hash',
            'mysql_extra_bind_address' => 'MySQL bind address',
            'mysql_extra_version' => 'MySQL version',
            'kernelmajversion' => 'Linux Kernel Version',
            'kernelrelease' => 'Linux Release Version',
            'schoolbox_config_protect_student_photo' => 'Schoolbox Config - Protect Student Photos',
            'schoolbox_config_protect_teacher_photo' => 'Schoolbox Config - Protect Teacher Photos',
            'php_cli_version' => 'PHP Version',
            'schoolbox_config_proxy_host' => 'Schoolbox Config - Proxy Host setup',
            'schoolbox_futureactiveterms' => 'Schoolbox Terms - Number of Current or Future Configured Terms',
            'schoolbox_config_site_location' => 'Site Location in Schoolbox',
            'schoolbox_cron_has_gc_enabled' => 'Servers that have gc enabled in /etc/crontab will be greater than zero',
            'schoolbox_media_pending' => 'Schoolbox Media Queue: Pending',
            'schoolbox_media_processing' => 'Schoolbox Media Queue: Processing',
            'schoolbox_media_completed' => 'Schoolbox Media Queue: Completed',
            'schoolbox_media_failed' => 'Schoolbox Media Queue: Failed',
            'schoolbox_media_failed_timeout' => 'Schoolbox Media Queue: Failed due to Time Out',
            'schoolbox_media_failed_latest' => 'Schoolbox Media Queue: Failed with latest ffmpeg',
            'schoolbox_config_external_attendance' => 'Schoolbox Config - Attendance enabled',
            'schoolbox_config_mail_smtp_host' => 'Schoolbox Config - SMTP Server',
            'schoolbox_config_external_synergetic_student_contact_types' => 'Schoolbox Config - Synergetic Student Contact Types',
            'schoolbox_config_cyberhound_api_url' => 'Schoolbox Config - Cyberhound API URL',
            'schoolbox_config_otfs_adapter' => 'Schoolbox Config - otfs_adapter',
            'schoolbox_first_file_upload_year' => 'Schoolbox - Year of first file upload',
            'schoolbox_first_file_upload_date' => 'Schoolbox - Date of first file upload',
            'schoolbox_plagscan_docs_total_currentyear' => 'Schoolbox - Total Plagscan Documents for the Current Year',
            'schoolbox_plagscan_docs_total' => 'Schoolbox - Total Plagscan Documents',
            'curl_processes' => 'Total number of current curl processes',
            'schoolbox_mysql_autoincrement_count_checked' => 'mysql autoincrement count checked',
            'schoolbox_mysql_autoincrement_count_invalid' => 'mysql autoincrement count invalid',
        ];

        // Set fact names for use in the dropdown
        $this->set('factNamesList', $factNames);

        // Get fact from query
        $fact = $this->request->getQuery('fact');
        $value = $this->request->getQuery('value');
        $environment = $this->request->getQuery('environment');


        // Prioritise requests from form on page
        if ($this->request->is('post')) {
            $fact = $this->request->getData('fact');
            $environment = $this->request->getData('environment');
            $this->redirect(['action' => 'factDetails', '?' => ['fact' => $fact, 'environment' => $environment]]);
        }

        // Check if a fact name has been provided, and set it as a variable
        if ($fact) {
            $this->set('fact', $fact);
            // Get the results from the server for this fact and then return details
            $this->set('results', $this->performQuery($fact));
        }

        // Check if a search value has been provided, and set it as a variable
        if ($value) {
            $this->set('value', $value);
        }

        // Check if an environment value has been provided, and set it as a variable
        if ($environment) {
            $this->set('environmentSpecific', $environment);
        }

    }
}