<?php

use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address(),
        'email' => $faker->unique()->safeEmail,
        'website'=> $faker->word(50),
        'phone' =>$faker->phoneNumber(),
        'fax' =>$faker->phoneNumber(),
        'npwp' => $faker->word(10),
        'ttd'=> $faker->firstNameMale(),
        'position'=> $faker->firstNameMale(),
        'notes' => $faker->text()
    ];
});
