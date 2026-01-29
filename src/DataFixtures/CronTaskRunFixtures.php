<?php

namespace App\DataFixtures;

use App\Entity\CronTaskRun;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CronTaskRunFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTimeImmutable();
        $commands = [
            'app:auth-log:purge',
            'app:cache:cleanup',
            'app:stats:aggregate',
            'app:maintenance:ping',
        ];

        for ($i = 0; $i < 100; $i++) {
            $run = new CronTaskRun();
            $command = $commands[array_rand($commands)];
            $run->setCommand($command);

            $secondsAgo = random_int(0, 60 * 60 * 24 * 120);
            $startedAt = $now->sub(new \DateInterval('PT' . $secondsAgo . 'S'));
            $run->setStartedAt($startedAt);

            $statusRoll = random_int(1, 100);
            if ($statusRoll <= 75) {
                $status = CronTaskRun::STATUS_SUCCESS;
            } elseif ($statusRoll <= 90) {
                $status = CronTaskRun::STATUS_FAILED;
            } else {
                $status = CronTaskRun::STATUS_RUNNING;
            }

            $run->setStatus($status);

            if ($status === CronTaskRun::STATUS_RUNNING) {
                $run->setSummary('Execution en cours.');
                $run->setContext([
                    'trigger' => 'cron',
                    'host' => 'cron-01',
                ]);
                $manager->persist($run);
                continue;
            }

            $durationMs = random_int(120, 8500);
            $durationSeconds = (int) ceil($durationMs / 1000);
            $finishedAt = $startedAt->add(new \DateInterval('PT' . $durationSeconds . 'S'));

            $run->setFinishedAt($finishedAt);
            $run->setDurationMs($durationMs);
            $run->setExitCode($status === CronTaskRun::STATUS_SUCCESS ? 0 : 1);

            if ($command === 'app:auth-log:purge') {
                $days = random_int(180, 365);
                $deleted = $status === CronTaskRun::STATUS_SUCCESS ? random_int(5, 1400) : 0;
                $cutoff = $startedAt->modify(sprintf('-%d days', $days));
                $summary = $status === CronTaskRun::STATUS_SUCCESS
                    ? sprintf('%d entrees supprimees (anterieures a %s).', $deleted, $cutoff->format('Y-m-d'))
                    : 'Erreur lors de la purge des journaux.';
                $run->setSummary($summary);
                $run->setOutput($status === CronTaskRun::STATUS_SUCCESS ? $summary : null);
                $run->setError($status === CronTaskRun::STATUS_FAILED ? 'Database timeout during purge.' : null);
                $run->setContext([
                    'days' => $days,
                    'dry_run' => false,
                    'trigger' => 'cron',
                    'host' => 'cron-01',
                ]);
            } else {
                $summary = $status === CronTaskRun::STATUS_SUCCESS
                    ? 'Tache executee avec succes.'
                    : 'Echec lors de l\'execution de la tache.';
                $run->setSummary($summary);
                $run->setOutput($status === CronTaskRun::STATUS_SUCCESS ? $summary : null);
                $run->setError($status === CronTaskRun::STATUS_FAILED ? 'Unexpected failure in task runner.' : null);
                $run->setContext([
                    'trigger' => 'cron',
                    'host' => 'cron-01',
                ]);
            }

            $manager->persist($run);
        }

        $manager->flush();
    }
}
