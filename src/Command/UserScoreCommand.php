<?php

namespace App\Command;

use App\Service\User\ScoreCalculator\UserScoreService;
use App\Service\User\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:score')]
class UserScoreCommand extends Command
{
    private UserService $userService;
    private UserScoreService $scoreService;

    public function __construct(UserService $userService, UserScoreService $scoreService, $name = null)
    {
        parent::__construct($name);
        $this->userService = $userService;
        $this->scoreService = $scoreService;
    }

    protected function configure(): void
    {
        $this->addArgument('id', InputArgument::OPTIONAL, 'user ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$id = $input->getArgument('id')) {
            $users = $this->userService->getAllUsers();
        } else {
            $users = [$this->userService->getUser((int)$id)];
        }

        foreach ($users as $user) {
            $scoreExplain = $this->scoreService->explain($user);
            $total = array_sum($scoreExplain);
            $combinedScores = [];
            $combinedScores[] = sprintf("userID: %d", $user->getId());
            foreach ($scoreExplain as $scoreType => $score) {
                $combinedScores[] = sprintf("%s: %5d", $scoreType, $score);
            }
            $combinedScores[] = sprintf("total: %d", $total);
            $output->writeln(implode(' | ', $combinedScores));
        }


        return Command::SUCCESS;
    }
}