<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Paypal Payment</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>

	<h1 class="text-center">This is great</h1>

    @if ($message = Session::get('success'))

    <div class="custom-alerts alert alert-success fade in">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

        {!! $message !!}

    </div>

    <?php Session::forget('success');?>

    @endif

    @if ($message = Session::get('error'))

    <div class="custom-alerts alert alert-danger fade in">

        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

        {!! $message !!}

    </div>

    <?php Session::forget('error');?>

    @endif


        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('post.paypal')}}" >

            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">

                <label for="amount" class="col-md-4 control-label">Amount</label>

                <div class="col-md-6">

                    <input id="amount" type="text" class="form-control" name="amount" value="{{ old('amount') }}" autofocus>

                    @if ($errors->has('amount'))

                        <span class="help-block">

                            <strong>{{ $errors->first('amount') }}</strong>

                        </span>

                    @endif

                </div>

            </div>

            

            <div class="form-group">

                <div class="col-md-6 col-md-offset-4">

                    <button type="submit" class="btn btn-primary">

                        Paywith Paypal

                    </button>

                </div>

            </div>

        </form>

	<script src="{{asset('js/app.js')}}"></script>

</body>
</html>