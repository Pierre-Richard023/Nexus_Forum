<?php

namespace App\DataFixtures;

use App\Entity\ChampionImage;
use App\Entity\Champions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ChampionImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly ParameterBagInterface $parameterBag) {}

    public function load(ObjectManager $manager): void
    {
        $jsonFile = $this->parameterBag->get('kernel.project_dir') . '/public/utils/champions.json';
        $jsonData = file_get_contents($jsonFile);
        $data = json_decode($jsonData, true);



        if (isset($data)) {
            $publicDir = $this->parameterBag->get('kernel.project_dir') . "/public";

            foreach ($data  as $championData) {

                $id = $championData['id'];
                $champion = $this->getReference('champion_' . $id, Champions::class);
                foreach ($championData['image'] as $t => $image) {

                    $filePath = $publicDir . '/utils/champions/' .  $image;
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


                    $championImage = new ChampionImage();
                    $championImage
                        ->setType($t)
                        ->setChampion($champion)
                        ->setImageFile($imageFile)
                    ;


                    $manager->persist($championImage);
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
