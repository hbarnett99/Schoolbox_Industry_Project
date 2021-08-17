<?php
namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;

class HelloCommand extends Command
{

    protected $modelClass = 'HistoricalFacts';

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out($this->executeCommand(QueryServerCommand::class));
    }

}
