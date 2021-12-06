<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SolvePartOneCommand extends Command
{
    protected static $defaultName = 'solve:part-one';


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sequence = array_filter(explode("\n", file_get_contents('data/input.txt')));
        $sequence = array_map(function (string $command) {
            [$direction, $affect] = explode(' ', $command, 2);

            return [$direction, intval($affect)];
        }, $sequence);

        $y = $z = 0;

        foreach ($sequence as $command) {
            [$direction, $affect] = $command;

            switch ($direction) {
                case 'forward':
                    $z += $affect;
                    break;
                case 'up':
                    $y -= $affect;
                    break;
                case 'down':
                    $y += $affect;
                    break;
            }
        }

        $output->writeln(sprintf('The submarine has a horizontal position of %d and a depth of %d (total: %d)', $z, $y, $z * $y));

        return Command::SUCCESS;
    }
}
