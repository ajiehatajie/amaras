<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address(),
        'email' => $faker->unique()->safeEmail,
        'website'=> $faker->word(50),
        'phone' =>$faker->phoneNumber(),
        'npwp' => $faker->word(10),
        'direktur'=> $faker->firstNameMale(),
        'notes' => $faker->text()
    ];
});
