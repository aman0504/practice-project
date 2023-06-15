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



<table>
    <thead>
        <tr>
            <th> S.No.</th>
            <th> Card Name</th>
            <th> Card Number.</th>
            <th> Exp Month</th>
            <th> Exp Year</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cardDetails->userCard as $cardDetail)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $cardDetail->card_name }}</td>
                <td> {{ $cardDetail->card_number }}</td>
                <td> {{ $cardDetail->exp_month }}</td>
                <td> {{ $cardDetail->exp_year }}</td>
                <td>
                    <a href="{{ route('cardEdit', $cardDetail->id) }}" value="{{ $cardDetail->id }}"> Update </a>

                    <form method="POST" action="{{ route('deleteCard', $cardDetail->id) }}">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit" class="btn btn-danger confirm-button">Delete</button>
                    </form>
                </td>
            <tr>
        @endforeach
    </tbody>
</table>
<br> <br>
<table>
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Transaction ID </th>
            <th>Balance Transaction </th>
            <th>Customer </th>
            <th> Amount </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cardDetails->payment as $cardDetail)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $cardDetail->transaction_id }}</td>
                <td> {{ $cardDetail->balance_transaction }}</td>
                <td> {{ $cardDetail->customer }}</td>
                <td> {{ $cardDetail->amount }}</td>

            <tr>
        @endforeach
    </tbody>
</table>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script type="text/javascript">
    $('.confirm-button').click(function(event) {
        // debugger();
        var form = $(this).closest("form");
        event.preventDefault();
        swal({
                title: `Are you sure you want to delete this row?`,
                text: "It will gone forevert",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
