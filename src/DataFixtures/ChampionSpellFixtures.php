<?php

namespace App\DataFixtures;

use App\Entity\Champions;
use App\Entity\ChampionSpell;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ChampionSpellFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(private readonly ParameterBagInterface $parameterBag) {}


    public function load(ObjectManager $manager): void
    {

        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/champions-spells.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (isset($data)) {
            foreach ($data as $spell) {

                $id = $spell['champion-id'];
                $champion = $this->getReference('champion_' . $id, Champions::class);
                $publicDir = $this->parameterBag->get('kernel.project_dir') . "/public";


                foreach ($spell['spells'] as $slot => $spellData) {

                    $filePath = $publicDir . '/utils/champions/' .  $spellData['image'];
                    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                    $copyPath = $publicDir . '/images/copies/' . basename($filePath);
                    copy($filePath, $copyPath);

                    $imageFile = new UploadedFile(
                        $copyPath,
                        basename($copyPath),
                        'image/' . $extension,
                        null,
                        true
                    );

                    $championSpell = new ChampionSpell();
                    $championSpell
                        ->setChampion($champion)
                        ->setSlot($slot)
                        ->setName($spellData['name'])
                        ->setDescription($spellData['description'])
                        ->setTooltip($spellData['tooltip'])
                        ->setMaxrank($spellData['maxrank'])
                        ->setCooldown($spellData['cooldown'])
                        ->setCooldownBurn($spellData['cooldownBurn'])
                        ->setCost($spellData['cost'])
                        ->setCostBurn($spellData['costBurn'])
                        ->setSpellRange($spellData['range'])
                        ->setRangeBurn($spellData['rangeBurn'])
                        ->setImageFile($imageFile)
                    ;


                    $manager->persist($championSpell);
                }
            }
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ChampionsFixtures::class,
        ];
    }
}
