<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{

    private $slugify;

    public function __construct(Slugify $slug)
    {
        $this->slugify = $slug;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 1000 ; $i++) {
            $episode = new Episode();
            $episode->setNumber($faker->numberBetween(1, 50));
            $episode->setTitle($faker->text(55));
            $episode->setSynopsis($faker->text(255));
            $episode->setSeasonId($this->getReference('season_' . $faker->numberBetween(0, 49)));
            $episode->setSlug($this->slugify->generate($episode->getTitle()));
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