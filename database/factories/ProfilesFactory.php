<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProfilesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $profileTitles = [
            'Dulgher',
            'Electrician',
            'Mecanic auto',
            'Zidar',
            'Sofer',
            'Bucatar profesionist',
            'Programator',
            'Ospatar'
        ];

        $userIds = User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'title' => $profileTitles[rand(1, sizeof($profileTitles)-1)],
            'description' => $this->faker->text(200),
            'profileImage' => 'https://placeimg.com/100/100/any?' . rand(1, 100),
            'available' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
