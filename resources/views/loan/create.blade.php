@extends("layouts.master")
@section('content')
    <form method="post" action="{{ route('loan.post') }}">
        
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        
        <h1 class="h3 mb-3 fw-normal">Loan Info</h1>

        <div class="row">
            <div class="col-md-5">
            <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="loan_amount"  >
            <label for="floatingName">Loan amount</label>
         
        </div>
            </div>
            <div class="col-md-5">
            <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="annual_interest_rate" >
            <label for="floatingName">Annual interest rate</label>
         
        </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5">
            <div class="form-group form-floating mb-3">
            <input type="number" class="form-control" name="loan_term"  >
            <label for="floatingName">Loan term</label>
         
        </div>
            </div>
            <div class="col-md-5">
            <div class="form-group form-floating mb-3">
            <input type="text" class="form-control" name="monthly_extra_payment"  >
            <label for="floatingName">Monthly fixed extra payment</label>
         
        </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-10">

        <button class="w-100 btn btn-lg btn-primary" type="submit">Save</button>
</div>
</div>
        
        
    </form>
@endsection
