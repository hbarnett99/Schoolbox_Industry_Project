<?php

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

class setUserAsAdminCommand extends Command
{

    // Import the User model
    protected $modelClass = 'Users';

    // Adds argument to the parser
    protected function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->addArgument('email', [
            'help' => 'The email of the user that should be made an admin (they must already exist in the system!)'
        ]);

        return $parser;
    }


    /**
     * Main execution function for the command
     *
     * @param Arguments $args arguments for the command
     * @param ConsoleIo $io CakePHP I/O object
     * @return int|void|null 1 if successful, 0 if failure
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $email = $args->getArgument('email');

        // Ensure that the email is provided
        if ($email == null) {
            $io->abort("Email address must be provided as an argument!");
        }

        $user = $this->Users->find('all')->where(['email =' => $email])->first();

        // If the user with that email can be found, then update isAdmin to true.
        if ($user) {
            $user->isAdmin = 1;
            if ($this->Users->save($user)) {
                $io->success("Successfully updated " . $email . " to be an admin.");
            } else {
                $io->error("Unable to update " . $email . " to be an admin. Please try again!");
            }
        } else {
            $io->abort("Email address not found in system. Please ensure this user has signed in at least once!");
        }

    }

    public static function defaultName(): string {
        return 'setUserAsAdmin';
    }
}
