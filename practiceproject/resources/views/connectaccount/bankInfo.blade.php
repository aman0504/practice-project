<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <p>Bank Info </p>
    <div class="container">

        @if (isset($stripeerror))
            <div class="alert alert-danger" role="alert">
                Please try again later.
            </div>
            <a href="{{ route('driver.bank-info') }}" class="btn btn-primary">Reload</a>
        @else
            @if (!$bankInfo)
                <form action={{ route('bankinfo.accountcreate') }}>
                    <button type="submit" class="btn btn-info">Connect Bank Account</button>
                </form>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-warning">
                    {{ session()->get('error') }}
                </div>
            @endif
             @if ($bankInfo)
                @if ($bankInfo->payouts_enabled != 'active')
                    <div class="alert alert-warning"> Payouts are not enabled for your account. Please check all the
                        details are verified or not. </div>
                    <div class="mb-4">
                        <a href="{{ route('bankinfo.connectedAccountUpdate') }}" class="apply-btn">Update Account Details</a>
                    </div>
                @endif

                @if ($bankInfo)
                    @include('connectaccount.accountForm')
                    <a href="{{ route('bankinfo.connectedAccountDelete') }}" class="apply-btn dlete-btn">Delete Bank Account</a>
                @endif
            @endif
        @endif

    </div>
</body>

</html>




