<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobCategoryFactory extends Factory
{
    public static array $jobCategories = [
        'Dulgher',
        'Electrician',
        'Mecanic auto',
        'Zidar',
        'Sofer',
        'Bucatar profesionist',
        'Programator',
        'Ospatar'
    ];

    protected $model = JobCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(self::$jobCategories),
            'icon' => 'https://svgbackgrounds.com/random?size=100'
        ];
    }
}
