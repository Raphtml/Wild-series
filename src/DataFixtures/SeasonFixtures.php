<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($i=0; $i < 6; $i++) {
            for ($j=1; $j < 10; $j++){
                $season = new Season();
                $season->setProgramId($this->getReference('program_' . $i));
                $season->setNumber($j);
                $season->setDescription($faker->text(255));
                $season->setYear('200' . $j);
                $manager->persist($season);
                $this->addReference('program_'. $i . 'season_' . $j, $season);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}