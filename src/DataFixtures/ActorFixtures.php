<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'andrew lincoln',
        'norman reedus',
        'lauren cohan',
        'danai gurira',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $name) {
            $actor = new Actor();
            $actor->setName($name);
            $actor->addProgram($this->getReference('program_0'));
            $manager->persist($actor);
            $this->addReference('actor_' . $key, $actor);
        }

        $faker = Faker\Factory::create();
        for ($i=4; $i < 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_' . rand(0, 5), $actor));
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}