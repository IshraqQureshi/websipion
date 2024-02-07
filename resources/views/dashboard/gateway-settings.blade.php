<x-main-dashboard>
    @php
        $title = __('site.payment.title');
    @endphp
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <x-breadcrumb-header title="{{ $title }}">
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}">{{ pageTitle()[1] }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ pageTitle()[2] }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </x-breadcrumb-header>

            <section class="section">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form id="FromID" enctype="multipart/form-data" data-URL="{{ route('GatewaySaveUpdate') }}">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" id="id" value="{{ $PaymentSettings['id'] ?? '' }}">
                                    <div class="col-md-12">
                                        <h5>Payment Razorpay</h5>
                                        <div class="form-check form-switch">
                                            <label>Enable / Disable</label>
                                            <input class="form-check-input" type="checkbox" id="razorpay_on_off" name="razorpay_on_off"
                                                {{ $PaymentSettings['razorpay_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Key</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control"  name="key_id" id="key_id"
                                            value="{{ $PaymentSettings['key_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Secret Key</label>
                                    </div>

                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="key_secret" id="key_secret"
                                            value="{{ $PaymentSettings['key_secret'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <label class="mt-4 mb-2">Razorpay Webhook Url (readonly)</label>
                                        <input readonly class="form-control" type="text"
                                            value="{{ route('razorpayWebhook') }}">
                                    </div>

                                    {{-- Stripe --}}

                                    <div class="col-md-12 mt-5">
                                        <h5>Stripe</h5>
                                        <label>Enable / Disable</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="stripe_on_off" name="stripe_on_off"
                                                {{ $PaymentSettings['stripe_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client ID</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="stripe_client_id" name="stripe_client_id"
                                            value="{{ $PaymentSettings['stripe_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client Secret</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="stripe_client_secret" name="stripe_client_secret"
                                            value="{{ $PaymentSettings['stripe_client_secret'] ?? '' }}" placeholder="">
                                    </div>



                                    {{-- Paypal --}}

                                    <div class="col-md-3 mt-5">
                                        <h5>Paypal</h5>
                                        <label>Enable / Disable</label>

                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="paypal_on_off" name="paypal_on_off"
                                                {{ $PaymentSettings['paypal_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>


                                    <div class="col-md-9 mb-3 mt-5">
                                        <div class="form-check">
                                            <label class="cslabel">Live</label>

                                            <input class="csradio" type="radio" id="paypal_type" name="paypal_type" value="live"
                                                {{ $PaymentSettings['paypal_type'] == 'live' ? 'checked' : '' }}>
                                            <label class="cslabel">Sandox</label>

                                            <input class="csradio" type="radio" id="paypal_type" name="paypal_type" value="sandbox"
                                                {{ $PaymentSettings['paypal_type'] == 'sandbox' ? 'checked' : '' }}>
                                        </div>
                                        <br />
                                    </div>

                                    <div class="col-sm-12 col-md-12 mb-3">
                                        <label class="mt-4 mb-2">Paypal Webhook Url (readonly)</label>
                                        <input readonly class="form-control" type="text"
                                            value="{{ route('paypal.webhook') }}">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client ID</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="paypal_client_id" name="paypal_client_id"
                                            value="{{ $PaymentSettings['paypal_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client Secret</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="paypal_client_secret" name="paypal_client_secret"
                                            value="{{ $PaymentSettings['paypal_client_secret'] ?? '' }}" placeholder="">
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    @csrf
                                    <center>
                                        <div class="col-md-2 mt-3 mb-2">
                                            <button type="button" id="saveupdate" name="submit"
                                                class="btn btn-sm btn-primary px-4">{{ __('site.payment.save-update') }}</button>
                                        </div>
                                    </center>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-main-dashboard>
