<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PricingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $titles = ['Basic', 'Standard', 'VIP'];
        $subtitles = ['Gratuit, începe acum treaba!', 'Planul pentru profesioniști', 'Lucrurile se învart in jurul tău!'];
        $monthlyPrices = [0, 25, 50];
        $yearlyPlans = ['{"perMonth": 0,"totalAnual": 0}', '{"perMonth": 18.75,"totalAnual": 225}', '{"perMonth": 37.5,"totalAnual": 450}'];
        $popularValues = [true, false];

        static $counter = 0;

        $result = [
            'title' => $titles[$counter % count($titles)],
            'img' => '@/assets/images/illustration/Pot1.svg',
            'subtitle' => $subtitles[$counter % count($subtitles)],
            'monthlyPrice' => $monthlyPrices[$counter % count($monthlyPrices)],
            'yearlyPlan' => $yearlyPlans[$counter % count($yearlyPlans)],
            'popular' => $popularValues[array_rand($popularValues)],
        ];

        $counter++;

        return $result;
    }
}
