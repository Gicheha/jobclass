@extends('layouts.master')

@section('search')
	@parent
    @include('pages.inc.page-intro')
@endsection

@section('content')
    @include('common.spacer')
    <div class="row">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <div class="form-group">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="accounts@thiswebsite.com">
            <input type="hidden" name="no_shipping" value="0">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="lc" value="AU">
            <input type="hidden" name="bn" value="PP-BuyNowBF">
            <input type="hidden" name="return" value="http://net.tutsplus.com/payment-complete/">
            <div class="form-group mb-2"><input type="email" class="form-control" placeholder="Enter your PayPal Account" required></div>
            <div class="form-group mb-2"><input type="number" class="form-control" placeholder="Enter Amount"></div>
            <div class="form-group mb-2"><input type="text" class="form-control" placeholder="Enter the Package"></div>
            <div class="form-group mb-2 text-center"><input type="submit" class="btn btn-primary" value="submit" name="submit"></div>    
        </div>    
    </form>
    </div>
@endsection