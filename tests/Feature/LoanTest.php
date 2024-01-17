<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->post('/api/loan',[
            'loan_amount' => 24000,
            "annual_interest_rate" =>3,
            "loan_term" =>2
        ]);
        $response->assertStatus(200);

        // $responseWithExtraPayment= $this->post("/loan",[
        //     'loan_amount' => 24000,
        //     "annual_interest_rate" =>3,
        //     "loan_term" =>2,
        //     "monthly_extra_payment" =>50
        // ]);


        // $responseWithExtraPayment->assertStatus(200);

        

    }
}
