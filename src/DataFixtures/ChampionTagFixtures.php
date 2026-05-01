<?php

namespace App\DataFixtures;

use App\Entity\ChampionTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ChampionTagFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $name = ['Assassin', 'Fighter', 'Mage', 'Marksman', 'Support', 'Tank',];

        for ($i = 0; $i < 6; $i++) {
            $championTag = new  ChampionTag();
            $championTag->setName($name[$i]);
            $this->addReference('champion_tag_' . $name[$i], $championTag);
            $manager->persist($championTag);
        }
        $manager->flush();
    }
}
