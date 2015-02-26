@extends(Config::get('core.default'))

@section('title', 'Donate')

@section('top')
<div class="page-heading">
    <div class="container">
        <h1>Donate to StyleCI</h1>
        <p>Do you like what we do; interested in donating?</p>
    </div>
</div>
@stop

@section('content')
<h1>Donate via Paypal</h1>
<p>As you may know, we don't charge a penny for StyleCI but it still costs us time and money to run the service. If you like what we do and would like to help us out, you can donate to via Paypal.</p>

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="business" value="StyleCI">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="item_name" value="StyleCI Donation">
    <input type="hidden" name="hosted_button_id" value="C98JAXGZ5PQX6">
    <input type="hidden" name="currency_code" value="GBP">
    <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
@stop
