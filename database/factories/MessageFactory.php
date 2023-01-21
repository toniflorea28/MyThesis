<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition()
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'from_id' => $this->faker->randomElement($userIds),
            'user_id' => $this->faker->randomElement($userIds),
            'to_id' => $this->faker->randomElement($userIds),
            'subject' => $this->faker->sentences(1, true),
            'message' =>'<p>'. $this->faker->paragraphs(3, true).'</p>',
            'folder' => 'inbox',
            'isStarred' => 0,
            'isRead' => 0,
            'labels' => '',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
