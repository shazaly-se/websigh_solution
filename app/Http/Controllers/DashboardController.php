<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanAmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;



class DashboardController extends Controller
{
  public function index(){
    $amortizationSchedule = LoanAmortizationSchedule::where("user_id",auth()->user()->id)
    ->get();

    $loan_remaining_term = ExtraRepaymentSchedule::orderBy("remaining_loan_term","asc")->first();
   

    return view("dashboard.index",compact('amortizationSchedule','loan_remaining_term'));
   
  }
}
