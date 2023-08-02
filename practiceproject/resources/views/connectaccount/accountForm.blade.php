
<style>
.form-group input {
    width: 23%;
    padding: 5px;
    /* margin: auto; */
    display: block;
    margin-bottom: 0px !important;
}

</style>

<div class='container'>
    <form id="payment-form" action="{{route('bankinfo.saveBankDetails')}}" method="POST">
        @csrf
        <div class="form-group">
            <label>Account Holder Name</label>
            {{-- <input type="text" id="card_name" name="account_holder_name" value= "{{$bankInfo->account_holder_name}}"/> --}}

            <input type="text" id="card_name" name="account_holder_name"/>
            @error('account_holder_name')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Account Number</label>
            {{-- <input type="text" id="card_number" name="account_number" value= "{{$bankInfo->account_number}}" /> --}}

            <input type="text" id="card_number" name="account_number"/>
            @error('account_number')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Routing Number</label>
            {{-- <input type="text" id="exp_month" name="routing_number" value= "{{$bankInfo->routing_number}}"/> --}}
            <input type="text" id="exp_month" name="routing_number"/>
            @error('routing_number')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>

        <button type="submit">Submit</button>
    </form>
</div>
<br><br>
<label> Account Info if saved </label>
<br>
@if($bankInfo)
<div class='container'>

        <div class="form-group">
            <label>Account Holder Name</label>
            <input type="text" id="card_name" name="account_holder_name" value= "{{$bankInfo->account_holder_name}}"/>

            @error('account_holder_name')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Account Number</label>
            <input type="text" id="card_number" name="account_number" value= "{{$bankInfo->account_number}}" />

            @error('account_number')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Routing Number</label>
            <input type="text" id="exp_month" name="routing_number" value= "{{$bankInfo->routing_number}}"/>
            @error('routing_number')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>

</div>
@endif
