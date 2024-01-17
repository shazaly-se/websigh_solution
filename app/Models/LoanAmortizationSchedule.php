<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmortizationSchedule extends Model
{
    use HasFactory;
    protected $table = "loan_amortization_schedule";
    protected $fillable = ["month_number","user_id","starting_balance","ending_balance","monthly_payment","principal_component","interest_component"];
}
