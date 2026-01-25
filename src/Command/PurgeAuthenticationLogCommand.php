<?php

namespace App\Command;

use App\Repository\AuthenticationLogRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:auth-log:purge',
    description: 'Purge les journaux de connexion (AuthenticationLog) au-delà de la durée de conservation.',
)]
class PurgeAuthenticationLogCommand extends Command
{
    public function __construct(
        private readonly AuthenticationLogRepository $authenticationLogRepository,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('days', null, InputOption::VALUE_OPTIONAL, 'Nombre de jours de conservation (défaut: 365).', 365)
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Affiche le seuil sans supprimer de données.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $days = (int) $input->getOption('days');
        $dryRun = (bool) $input->getOption('dry-run');

        if ($days < 1) {
            $io->error('Le paramètre --days doit être supérieur ou égal à 1.');
            return Command::INVALID;
        }

        $cutoff = (new \DateTimeImmutable())->modify(sprintf('-%d days', $days));

        if ($dryRun) {
            $io->note(sprintf('Seuil de purge (dry-run) : %s', $cutoff->format('Y-m-d H:i:s')));
            return Command::SUCCESS;
        }

        $deleted = $this->authenticationLogRepository->purgeOlderThan($cutoff);
        $io->success(sprintf('%d entrées supprimées (antérieures à %s).', $deleted, $cutoff->format('Y-m-d H:i:s')));

        return Command::SUCCESS;
    }
}
