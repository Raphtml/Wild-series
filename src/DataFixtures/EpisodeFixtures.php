<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 1000 ; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1, 50));
            $episode->setTitle($faker->text(55));
            $episode->setSynopsis($faker->text(255));
            $episode->setSeasonId($this->getReference('season_' . $faker->numberBetween(0, 49)));
            $manager->persist($episode);
            $this->addReference('episode_' . $i, $episode);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}