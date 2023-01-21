<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingBenefit extends Model
{
    use HasFactory;
    protected $table = 'pricing_benefits';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public function pricing()
    {
        return $this->belongsTo('App\Models\Pricing', 'pricing_id');
    }
}
