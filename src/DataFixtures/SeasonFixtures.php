<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Season;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const NBSEASONS = 3;

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create();
        for ($j = 0; $j < 168; $j++) {
            $season = new Season();
            $season->setNumber($j %self::NBSEASONS);
            $season->setYear(($j %self::NBSEASONS) + 2015);
            $season->setDescription($faker->paragraph($nbSentences = rand(0, 4)+2, $variableNbSentences = true));

            $manager->persist($season);
            $this->addReference('season_'. $j, $season);

            $season->setProgram($this->getReference('program_'. (floor($j /  self::NBSEASONS))));
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}
