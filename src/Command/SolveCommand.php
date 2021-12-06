<?php

namespace App\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SolveCommand extends Command
{
    protected static $defaultName = 'solve';


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sequence = array_filter(explode("\n", file_get_contents('data/input.txt')));

        $total = count($sequence);
        $output->writeln(sprintf('There are %d lines', $total));

        $increments = $decrements = 0;
        $max = null;

        for($offset = 0; $offset < ($total - 2); $offset++) {
            $subSequence = array_slice($sequence, $offset, 3);
            $sum = array_sum($subSequence);

            if (null === $max) {
                $max = $sum;
                $output->writeln(sprintf("%s\t\t\t\t[%s]", $sum, join(', ', $subSequence)));
                continue;
            }

            $delta = $sum - $max;

            if ($delta > 0) {
                $increments++;
                $output->writeln(sprintf("%d +%s\t%s\t[%s]", $sum, str_pad($sum - $max, 3, '0', STR_PAD_LEFT), 'Increment', join(', ', $subSequence)));
            }

            else if ($delta < 0) {
                $decrements++;
                $output->writeln(sprintf("%d -%s\t%s\t[%s]", $sum, str_pad($max - $sum, 3, '0', STR_PAD_LEFT), 'Decrement', join(', ', $subSequence)));
            }

            else $output->writeln(sprintf("%d -%s\t%s\t[%s]", $sum, str_pad($max - $sum, 3, '0', STR_PAD_LEFT), 'No change', join(', ', $subSequence)));

            $max = $sum;
        }

        $output->writeln(sprintf('There were %d increments', $increments));
        $output->writeln(sprintf('There were %d decrements', $decrements));

        return Command::SUCCESS;
    }
}
