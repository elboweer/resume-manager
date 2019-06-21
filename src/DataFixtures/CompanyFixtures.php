<?php


namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $company = new Company();
            $company->setTitle('Company_'.$i);
            $company->setPhone(mt_rand(10, 100));
            $company->setSite(sprintf('site_number_%s.ru', $i));
            $company->setAddress(sprintf('Adress number %s', $i));
            $manager->persist($company);
        }

        $manager->flush();
    }
}