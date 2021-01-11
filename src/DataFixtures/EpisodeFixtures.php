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
        for ($i=0; $i < 6 ; $i++) {
            for ($j=1; $j<10; $j++){
                for ($k=1; $k < rand(2,21); $k++){
                    $episode = new Episode();
                    $episode->setNumber($k);
                    $episode->setTitle($faker->text(55));
                    $episode->setSynopsis($faker->text(255));
                    $episode->setSeasonId($this->getReference('program_' . $i . 'season_' . $j));
                    $episode->setSlug($this->slugify->generate($episode->getTitle()));
                    $manager->persist($episode);
                    $this->addReference('program_' . $i . 'season_' . $j . 'episode_' . $k, $episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}