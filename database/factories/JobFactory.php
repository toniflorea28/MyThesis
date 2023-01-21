<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\JobCategoryFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Job::class;

    public function definition()
    {
        $userIds = User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'category_id' => $this->faker->numberBetween(1, sizeof(JobCategoryFactory::$jobCategories)),
            'img' => 'https://placeimg.com/400/250/any?1' . $this->faker->numberBetween(1, 1000),
            'title' => JobCategoryFactory::$jobCategories[$this->faker->numberBetween(1, sizeof(JobCategoryFactory::$jobCategories)-1)],
            'excerpt' => $this->faker->sentences(2, true),
            'content' => '<p>'. $this->faker->paragraphs(3, true).'</p>',
            'phone' => $this->faker->phoneNumber(),
            'location' => $this->faker->city(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' =>  $this->faker->numberBetween(1, 1000),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ];
    }
}
