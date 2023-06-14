<div class='container'>
    <form id="payment-form" action="{{ route('getCardDetails') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Card Name</label>
            <input type="text" id="card_name" name="card_name" />
            @error('card_name')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Card Number</label>
            <input type="text" id="card_number" name="card_number" />
            @error('card_number')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Exp. Month</label>
            <input type="text" id="exp_month" name="exp_month" />
            @error('exp_month')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>Exp. Year</label>
            <input type="text" id="exp_year" name="exp_year" />
            @error('exp_year')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <div class="form-group">
            <label>CVC</label>
            <input type="text" id="cvc" name="cvv" />
            @error('cvv')
                <div class="help-block">{{ $message }}</div>
            @enderror
        </div>
        <br>
        <button type="submit">Pay</button>
    </form>
</div>
