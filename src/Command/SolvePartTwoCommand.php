<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SolvePartTwoCommand extends Command
{
    protected static $defaultName = 'solve:part-two';


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sequence = array_filter(explode("\n", file_get_contents('data/input.txt')));
        $sequence = array_map(function (string $command) {
            [$direction, $affect] = explode(' ', $command, 2);

            return [$direction, intval($affect)];
        }, $sequence);

        $hpos = $depth = $aim = 0;

        foreach ($sequence as $command) {
            [$direction, $affect] = $command;

            switch ($direction) {
                case 'forward':
                    $hpos += $affect;
                    $depth += $aim * $affect;
                    break;
                case 'up':
                    $aim -= $affect;
                    break;
                case 'down':
                    $aim += $affect;
                    break;
            }
        }

        $output->writeln(sprintf('The submarine has a horizontal position of %d and a depth of %d (total: %d)', $hpos, $depth, $hpos * $depth));

        return Command::SUCCESS;
    }
}
