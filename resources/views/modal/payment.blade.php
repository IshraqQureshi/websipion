<div class="modal fade text-left modal-borderless" data-bs-backdrop="static" id="pay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ __('site.packages.pop.title') }}</h5>
            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="FromID">
                <div class="row mt-3">
                    <input type="hidden" id="APP_NAME" value="{{ env('APP_NAME') }}">
                    <input type="hidden" id="userName" value="{{ auth()->user()->name }}">
                    <input type="hidden" id="email" value="{{ auth()->user()->email }}">
                    <input type="hidden" id="mobile" value="{{ auth()->user()->mobile }}">
                    <input type="hidden" id="logo" value="{{ LogoGet()['favicon'] }}">

                    <center>
                        <h2>{{ __('site.packages.pop.cong') }}</h2>
                    </center>
                    <span class="text-center mb-3">{{ __('site.packages.pop.sub-title') }}</span>
                    <center>
                        <span class="showdarkprice showpriceinlinedollar">$</span>
                        <span class="showdarkprice showpriceinlinePrice"></span>
                        <span>(USD)</span>
                    </center>

                    @if ($arraySettings['razorpay_on_off'] == 'on')
                        <input type="hidden" id="rzpKEY"
                            value="{{ $arraySettings['key_id'] ?? '' }}">
                        <div class="col-md-12 mb-2 mt-3">
                            <center>
                                <div data-url="{{ route('PaymentSaveRazorpay') }}" data-packageID-pay="" data-priceShow-pay="" data-totalPrice-pay="" data-websiteTotal-pay="" class="method-pay razorpay">
                                   {{ __('site.packages.pop.checkout') }}
                                    <img src="{{ asset('pay.png') }}" alt="">
                                </div>
                            </center>
                        </div>
                        @if ($arraySettings['stripe_on_off'] == 'on')
                            <center>
                                <h6> {{ __('site.packages.pop.or') }}</h6>
                            </center>
                        @endif
                    @endif

                    @if ($arraySettings['stripe_on_off'] == 'on')
                        <div class="col-md-12 mb-2">
                            <center>
                                <div data-url="{{ route('PaymentSaveStripe') }}"  data-packageID-pay="" data-priceShow-pay="" data-totalPrice-pay="" data-websiteTotal-pay="" class="method-pay stripepay">
                                   {{ __('site.packages.pop.checkout') }}
                                    <img src="{{ asset('stripe.png') }}" alt="">
                                </div>
                            </center>
                        </div>
                        @if ($arraySettings['paypal_on_off'] == 'on')
                            <center>
                                <h6>{{ __('site.packages.pop.or') }}</h6>
                            </center>
                        @endif
                    @endif

                    @if ($arraySettings['paypal_on_off'] == 'on')
                        <div class="col-md-12">
                            <center>
                                <div data-url="{{ route('PaymentSavePayPal') }}"   data-packageID-pay="" data-priceShow-pay="" data-totalPrice-pay="" data-websiteTotal-pay="" class="method-pay paypal">
                                   {{ __('site.packages.pop.checkout') }}
                                    <img src="{{ asset('paypal.png') }}" alt="">
                                </div>
                            </center>
                        </div>
                    @endif

                    <center><img src="{{ asset('PaymentMode.png') }}" class="img-fluid mt-5"
                            height="40px">
                    </center>

                    @csrf
                </div>
            </form>
        </div>
    </div>
</div>
</div>