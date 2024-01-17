<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraRepaymentSchedule extends Model
{
    use HasFactory;
    protected $table = "extra_repayment_schedule";
    protected $fillable = ["month_number","user_id","starting_balance","ending_balance","monthly_payment","principal_component","interest_component","extra_payment","remaining_loan_term"];

}
