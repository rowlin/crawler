<?php


declare(strict_types=1);

namespace App\Command;

use App\Entity\JobResponse;
use App\Jobs\Runner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Jobs;

#[AsCommand(
    name: 'app:run',
    description: 'Execute jobs on a schedule',
)]
class RunCommand extends Command
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {/*
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;*/
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
       /* $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }*/


        $jobs_rep=$this->entityManager->getRepository(Jobs::class);
        $jobs_list =  $jobs_rep->findBy(['active' => true]);

        foreach ($jobs_list as $job){
            if($job->isActive() === true) {
                 $cron  = new CronResolver($job->getCron());
                if($cron->getResult()) {
                    $runner = new Runner();
                    $rep = $this->entityManager->getRepository(JobResponse::class);
                    $rep->add($runner->run($job), true);
                    $io->info('added : ' . $job->getId());
                }else{
                    $io->info('skipped : ' . $job->getId());
                }
            }
        }
        $io->success('Ok');

        return Command::SUCCESS;
    }
}
