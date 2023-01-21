<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PricingBenefitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $options = [
            1 => [
                '30 contacte incluse',
                'Acces la sistemul de recenzii Workbook',
                'Acces la chat privat alături de contactele tale',
                'Cashback prin referral. Primesti 20% din banii pe care o persoana invitată îi folosește pentru achizitonarea unui abonament, și 10% daca acea persoana invită alte persoane',
                'Limită de retragere de pe platforma: 25$'
            ],
            2 => [
                'Toate beneficiile pachetului Basic',
                'Contacte nelimitate',
                'Poți lăsa mesaje tuturor utilizatorilor.',
                'Poți încărca imagini de dimensiuni mai mari (pana la 2GB total, pentru toate anunțurile postate)',
                'Cashback prin referral. Primesti 25% din banii pe care o persoana invitată îi folosește pentru achizitonarea unui abonament, și 15% daca acea persoana invită alte persoane'
            ],
            3 => [
                'Toate beneficiile pachetelor Basic și Standard',
                'Poți încărca imagini de dimensiuni mai mari (pana la 5GB total, pentru toate anunțurile postate)',
                'Cashback prin referral. Primesti 30% din banii pe care o persoana invitată îi folosește pentru achizitonarea unui abonament, și 20% daca acea persoana invită alte persoane'
            ]
        ];

        $data = [];
        foreach ($options as $pricingId => $descriptions) {
            foreach ($descriptions as $description) {
                $data[] = [
                    'pricing_id' => $pricingId,
                    'description' => $description,
                ];
            }
        }

        return $data;
    }
}
