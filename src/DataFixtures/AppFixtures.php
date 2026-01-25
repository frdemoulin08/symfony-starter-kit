<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rows = [
            ['name' => 'Bairon', 'city' => 'Bairon', 'capacity' => 180, 'status' => 'Ouvert', 'updated_at' => '2026-01-12'],
            ['name' => 'Vieilles Forges', 'city' => 'Les Mazures', 'capacity' => 200, 'status' => 'Ouvert', 'updated_at' => '2026-01-09'],
            ['name' => 'Maison des Sports', 'city' => 'Bazeilles', 'capacity' => 260, 'status' => 'Ouvert', 'updated_at' => '2026-01-04'],
        ];

        foreach ($rows as $row) {
            $site = new Site();
            $site->setName($row['name']);
            $site->setCity($row['city']);
            $site->setCapacity($row['capacity']);
            $site->setStatus($row['status']);

            $updatedAt = new \DateTime($row['updated_at']);
            $site->setUpdatedAt($updatedAt);
            $site->setCreatedAt((clone $updatedAt)->modify('-10 days'));

            $manager->persist($site);
        }

        $manager->flush();
    }
}
