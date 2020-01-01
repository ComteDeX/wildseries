<?php

namespace App\DataFixtures;

use App\Services\SlugifyService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Episode;
use Faker;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();
        for ($j = 0; $j < 840; $j++) {
            $episode = new Episode();
            $episode->setTitle($faker->words($nb = 5, $asText = true));
            $episode->setSysnopsis($faker->paragraph($nbSentences = rand(0, 4)+2, $variableNbSentences = true));
            $episode->setNumber($j % 5);
            $episode->setSlug(SlugifyService::generate($episode->getTitle()));

            $manager->persist($episode);

            $episode->setSeason($this->getReference('season_'.(floor(floor($j/5)/3))));
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}
