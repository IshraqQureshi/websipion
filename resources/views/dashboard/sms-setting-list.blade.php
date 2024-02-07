<x-main-dashboard>
    @php
        $title =  __('site.sms-setting.title')
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
                            <form id="FromID" enctype="multipart/form-data">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" id="id"
                                        value="{{ $smsSettings['id'] ?? '' }}">
                                    <div class="col-md-12 mb-3">
                                        <h5>SMS Twilio</h5>
                                        <div class="form-check form-switch">
                                            <label>Enable / Disable</label>
                                            <input class="form-check-input" type="checkbox" id="twilio_on_off"
                                                name="twilio_on_off"
                                                {{ @$smsSettings['twilio_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Key</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="key_id" id="key_id"
                                            value="{{ $smsSettings['key_id'] ?? '' }}" placeholder="">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Secret</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="key_secret" id="key_secret"
                                            value="{{ $smsSettings['key_secret'] ?? '' }}" placeholder="">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">From</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="twilio_from" id="twilio_from"
                                            value="{{ $smsSettings['twilio_from'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="row mt-5">
                                        @csrf
                                        <center>
                                            <div class="col-md-2 mt-3 mb-2">
                                                <button type="button" id="Razorpayupdate" name="submit"
                                                    class="btn btn-sm btn-primary px-4"
                                                    data-url="{{ route('sms-setting.update') }}">{{ __('site.sms-setting.save-update') }}</button>
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
