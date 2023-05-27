<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;

class User extends Fixture
{
    const PHONE_CODES = [
        995, 901, 920, 915, 925,
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("ru_RU");
        for($i = 0; $i < 100; $i++) {
            $phone = sprintf("7%d%d", self::PHONE_CODES[array_rand(self::PHONE_CODES)], random_int(1000000, 9999999));
            $user = new \App\Entity\User\User();
            $user->setName($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPhone((int)$phone);
            $user->setAgreedToPersonalDataCollect(random_int(0, 1));

            $eTypes = array_flip(\App\Entity\User\User::EDUCATION_TYPES);

            $user->setEducation($eTypes[array_rand($eTypes)]);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
