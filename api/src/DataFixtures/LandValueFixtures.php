<?php

namespace App\DataFixtures;

use App\Entity\LandValue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LandValueFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 18; $i < 22; $i++) {
            $dataFile = fopen('%kernel.root_dir%/../data/valeursfoncieres-20'.strval($i).'.txt',  'r');
            $regionFile = fopen('%kernel.root_dir%/../data/departements-region.txt',  'r');
            $numberLine = 0;
            while (($lineRegion = fgets($regionFile)) !== false) {
                if ($numberLine !== 0) {
                    $values = explode(',', $lineRegion);
                    $regionMapping[strval($values[0])] = str_replace("\r\n", "", $values[2]);
                }
                $numberLine++;
            }
            $numberItems = 0;
            $numberLine = 0;
            while (($lineData = fgets($dataFile)) !== false) {
                if ($numberLine !== 0) {
                    $values = explode('|',  $lineData);
                    $land_value = new LandValue();
                    $land_value->setMutationDate(\DateTime::createFromFormat('d/m/Y',  $values[8]));
                    $land_value->setMutationType($values[9]);
                    $land_value->setLandValue(floatval(str_replace(', ',  '.',  $values[10])));
                    $land_value->setLocalType($values[36]);
                    $land_value->setActualBuiltUpArea(intval($values[38]));
                    $land_value->setRegion($regionMapping[strval($values[18])]);
                    $manager->persist($land_value);
                    $numberItems++;
                    if ($numberItems === 1000) {
                        $numberItems = 0;
                        $manager->flush();
                        $manager->clear();
                    }
                }
                $numberLine++;
            }
            $manager->flush();
            $manager->clear();
            fclose($dataFile);
            fclose($regionFile);
        }
    }
}
