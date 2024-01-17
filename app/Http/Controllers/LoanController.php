<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoanRequest;
use App\Models\LoanAmortizationSchedule;
use App\Models\ExtraRepaymentSchedule;



class LoanController extends Controller
{

    public function index(){
     $amortizationSchedule = LoanAmortizationSchedule::get();
     return view("loan.index",compact('amortizationSchedule'));

    }
    public function create(){
        return view("loan.create");
    }

    public function apistore(Request $request){
        $loanAmount = $validatedData['loan_amount'];
        $annualInterestRate = $validatedData['annual_interest_rate'];
        $loanTerm = $validatedData['loan_term'];
        $monthlyExtraPayment = $validatedData['monthly_extra_payment'] ?? 0;
    
    
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
    
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));
    
      
        $amortizationSchedule = [];
        $remainingBalance = $loanAmount;
    
        for ($month = 1; $month <= $numberOfMonths; $month++) {
            
            $interestComponent = $remainingBalance * $monthlyInterestRate;
            $principalComponent = $monthlyPayment - $interestComponent;
            $remainingBalance -= $principalComponent;
    
            $amortizationSchedule[] = [
               'user_id' => auth()->user()->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance + $principalComponent,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $remainingBalance,
            ];
    
            LoanAmortizationSchedule::create([
                'user_id' => auth()->user()->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance + $principalComponent,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $remainingBalance,
            ]);
    
           
        }
        if ($monthlyExtraPayment > 0) {
            $remainingBalance = $loanAmount;
            $updatedAmortizationSchedule = [];

            for ($month = 1; $month <= $numberOfMonths; $month++) {
                $interestComponent = $remainingBalance * $monthlyInterestRate;
                $principalComponent = $monthlyPayment - $interestComponent;

                // Check if extra repayment is made
                $extraRepayment = min($remainingBalance, $monthlyExtraPayment);
                $remainingBalance -= ($principalComponent + $extraRepayment);

             

                // Store in the database
                ExtraRepaymentSchedule::create([
                    'user_id' => auth()->user()->id,
                    'month_number' => $month,
                    'starting_balance' => $remainingBalance + $principalComponent + $extraRepayment,
                    'monthly_payment' => $monthlyPayment,
                    'principal_component' => $principalComponent,
                    'interest_component' => $interestComponent,
                    'extra_payment' => $extraRepayment,
                    'ending_balance' => $remainingBalance,
                    'remaining_loan_term' => $numberOfMonths - $month,

                ]);
            }
        }
        return redirect("/");
       
        return response()->json(["success"=>true]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'loan_amount' => 'required|numeric|min:0',
            'annual_interest_rate' => 'required|numeric|min:0',
            'loan_term' => 'required|integer|min:1',
            // 'monthly_extra_payment' => 'nullable|numeric|min:0',
        ]);

       

      
    
        
        $loanAmount = $validatedData['loan_amount'];
        $annualInterestRate = $validatedData['annual_interest_rate'];
        $loanTerm = $validatedData['loan_term'];
        $monthlyExtraPayment = $validatedData['monthly_extra_payment'] ?? 0;
    
    
        $monthlyInterestRate = ($annualInterestRate / 12) / 100;
        $numberOfMonths = $loanTerm * 12;
    
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfMonths));
    
      
        $amortizationSchedule = [];
        $remainingBalance = $loanAmount;
    
        for ($month = 1; $month <= $numberOfMonths; $month++) {
            
            $interestComponent = $remainingBalance * $monthlyInterestRate;
            $principalComponent = $monthlyPayment - $interestComponent;
            $remainingBalance -= $principalComponent;
    
            $amortizationSchedule[] = [
               'user_id' => auth()->user()->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance + $principalComponent,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $remainingBalance,
            ];
    
            LoanAmortizationSchedule::create([
                'user_id' => auth()->user()->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance + $principalComponent,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $remainingBalance,
            ]);
    
           
        }
        if ($monthlyExtraPayment > 0) {
            $remainingBalance = $loanAmount;
            $updatedAmortizationSchedule = [];

            for ($month = 1; $month <= $numberOfMonths; $month++) {
                $interestComponent = $remainingBalance * $monthlyInterestRate;
                $principalComponent = $monthlyPayment - $interestComponent;

                // Check if extra repayment is made
                $extraRepayment = min($remainingBalance, $monthlyExtraPayment);
                $remainingBalance -= ($principalComponent + $extraRepayment);

             

                // Store in the database
                ExtraRepaymentSchedule::create([
                    'user_id' => auth()->user()->id,
                    'month_number' => $month,
                    'starting_balance' => $remainingBalance + $principalComponent + $extraRepayment,
                    'monthly_payment' => $monthlyPayment,
                    'principal_component' => $principalComponent,
                    'interest_component' => $interestComponent,
                    'extra_payment' => $extraRepayment,
                    'ending_balance' => $remainingBalance,
                    'remaining_loan_term' => $numberOfMonths - $month,

                ]);
            }
        }
        return redirect("/");
        
      

    }

    public function repayment(Request $request)
{

    
    // Validation logic for repayment form
    $request->validate([
        'repayment_amount' => 'required|numeric|min:0',
        // Add validation rules for other fields as needed
    ]);

    // Extract repayment input
    $repaymentAmount = $request->input('repayment_amount');

    // Update the first table (loan_amortization_schedule) with the repayment amount
    // Assume you have a model named LoanAmortizationSchedule for the first table
    $latestRecord = LoanAmortizationSchedule::latest()->first();


    // Insert into the second table (extra_repayment_schedule)
    ExtraRepaymentSchedule::create([
        'user_id' => auth()->user()->id,
        'month_number' => $latestRecord->month_number,
        'starting_balance' => $latestRecord->starting_balance,
        'monthly_payment' => $latestRecord->monthly_payment,
        'principal_component' => $latestRecord->principal_component,
        'interest_component' => $latestRecord->interest_component,
        'extra_payment' => $repaymentAmount,
        'ending_balance' => $latestRecord->ending_balance,
    ]);

    return redirect("/");

    // Return success response or redirect back
}
}
