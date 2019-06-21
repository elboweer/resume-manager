<?php


namespace App\DataFixtures;

use App\Entity\Summary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SummaryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $summary = new Summary();
            $summary->setPosition(sprintf('Position %s', $i));
            $summary->setBody(sprintf('Summary %s', $i));
            $manager->persist($summary);
        }

        $manager->flush();
    }
}