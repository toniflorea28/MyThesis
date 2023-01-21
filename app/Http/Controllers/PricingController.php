<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricing;
use App\Models\QAndA;

class PricingController extends Controller
{
    public function getPricingData() {
        $plans = [1, 2, 3];
        $planNames = ['basicPlan', 'standardPlan', 'vipPlan'];
        $response = (object)[];

        foreach ($plans as $planId) {
            $pricing = Pricing::where('id', $planId)->get()[0];
            $plan = (object)[];
            $plan->title = $pricing->title;
            $plan->img = $pricing->img;
            $plan->subtitle = $pricing->subtitle;
            $plan->monthlyPrice = $pricing->monthlyPrice;
            $plan->yearlyPlan = $pricing->yearlyPlan;
            $plan->planBenefits = [];
            foreach($pricing->benefits as $benefit) {
                array_push($plan->planBenefits, $benefit->description);
            }
            $response->{$planNames[$planId-1]} = $plan;
        }

        $response->qandA = QAndA::all();

        return response()->json($response);
    }
}
