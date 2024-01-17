@extends("layouts.master")
@section("content")
</br></br>
<div style="display:flex;flex-direction:row;justify-content:space-between"><h5>Loan Details</h5>  

    <form method="post" action="{{ route('loan.repayment') }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div style="display:flex;flex-direction:row;justify-content:space-between">
       
        <div class="form-group form-floating">
            <input type="text" class="form-control" name="repayment_amount" required="required" >
            <label for="floatingName">amount</label>
         
        </div>
<input  class="ml-3" type="submit" value="Repayment">
</div>
</form>

</div>
 Remaining months:{{$loan_remaining_term->remaining_loan_term}}
</br></br>
<table class="table table-bordered">
    <thead>
        <tr>
        <th>Month</th>
        <th>Starting balance</th>
        <th>Monthly payment</th>
        <th>Principal</th>
        <th>Interest</th>
        <th>Ending balance</th>
</tr>
    </thead>
    <tbody>
   @foreach($amortizationSchedule as $schedule)
    <tr>
        <td>{{ $schedule['month_number'] }}</td>
        <td>{{ $schedule['starting_balance'] }}</td>
        <td>{{ $schedule['monthly_payment'] }}</td>
        <td>{{ $schedule['principal_component'] }}</td>
        <td>{{ $schedule['interest_component'] }}</td>
        <td>{{ $schedule['ending_balance'] }}</td>
    </tr>
@endforeach
</tbody>
<table>


@stop()