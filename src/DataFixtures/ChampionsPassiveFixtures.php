<?php

namespace App\DataFixtures;

use App\Entity\ChampionPassive;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ChampionsPassiveFixtures extends Fixture
{

    public function __construct(private readonly ParameterBagInterface $parameterBag) {}


    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/champions-passive.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);

        if (isset($data)) {


            $publicDir = $this->parameterBag->get('kernel.project_dir') . "/public";

            foreach ($data as $champion) {

                $id = $champion['champion-id'];

                $filePath = $publicDir . '/utils/champions/' .  $champion['passive']['image'];
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

                $championPassive = new ChampionPassive();
                $championPassive
                    ->setName($champion['passive']['name'])
                    ->setDescription($champion['passive']['description'])
                    ->setImageFile($imageFile)
                ;

                $this->addReference('champion_passive_' . $id, $championPassive);
                $manager->persist($championPassive);
            }
        }



        $manager->flush();
    }
}
