<?php

namespace App\DataFixtures;

use App\Entity\ChampionPassive;
use App\Entity\Champions;
use App\Entity\ChampionTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ChampionsFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(private readonly ParameterBagInterface $parameterBag) {}

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/champions.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);


        if (isset($data)) {

            foreach ($data  as $championData) {

                $id = $championData['id'];

                $champion = new Champions();
                $champion->setName($championData['name'])
                    ->setChampionId($id)
                    ->setTitle($championData['title'])
                    ->setLore($championData['lore'])
                    ->setPartype($championData['partype'])

                    ->setPassive($this->getReference('champion_passive_' . $id, ChampionPassive::class))
                ;

                foreach ($championData['tags'] as $tag) {
                    $championTag = $this->getReference('champion_tag_' . $tag, ChampionTag::class);
                    $champion->addTag($championTag);
                }

                $this->addReference('champion_' . $id, $champion);
                $manager->persist($champion);
            }
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            ChampionTagFixtures::class,
            ChampionsPassiveFixtures::class,
        ];
    }
}
