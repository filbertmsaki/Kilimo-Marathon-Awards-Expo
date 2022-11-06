<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redirect;

class DpoGroup extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'slug','enable_dpo', 'dpo_base_url', 'dpo_company_token','dpo_default_currency',
        'dpo_default_country','dpo_default_service','dpo_sandbox','dpo_default_service_description'
    ];

    
    
}
