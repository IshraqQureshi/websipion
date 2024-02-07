<div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="createPackages" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">{{ __('site.packages-list.form.title') }}</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="FromID" data-URL="{{ route('PackagesSave') }}">
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="card">
                            <div class="card-title">
                                <h3 class="tile-packageForm">{{ __('site.packages-list.form.price-settings') }}</h3>
                                <hr>
                            </div>
                            <div class="row">
                                <!--begin::Scroll-->
                                <div class=" mb-5 col-md-6 ">
                                    <!--begin::Label-->
                                    <label class="fw-semibold mb-2">{{ __('site.packages-list.form.name') }}</label>
                                    <input type="text" name="packageName" id="packageName" class="form-control">
                                    <span class="text-danger error-text packageName_error"></span>
                                </div>

                                <div class=" mb-5 col-md-6">
                                    <label class="fw-semibold mb-2">{{ __('site.packages-list.form.frequency') }}
                                    </label>
                                    <select class="form-control select2" name="crawlFrequency" id="crawlFrequency"
                                        style="width: 100%">
                                        <option value="" selected>--select--</option>
                                        @foreach (frequency() as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text crawlFrequency_error"></span>
                                </div>

                            </div>
                            <div class="card-title">
                                <h3 class="tile-packageForm">{{ __('site.packages-list.form.price-settings') }}</h3>
                                <hr>
                            </div>

                            <div class="row">

                                <div class=" mb-2 col-md-2">
                                    <input class="form-check-input typeSubscription" name="type" type="radio"
                                        value="Fixed">
                                    <label class="form-check-label" for="type">
                                        {{ __('site.packages-list.form.fixed') }}
                                    </label>
                                </div>

                                <div class=" mb-2 col-md-3">
                                    <input class="form-check-input typeSubscription" name="type" type="radio"
                                        value="Subscription">
                                    <label class="form-check-label" for="type">
                                        {{ __('site.packages-list.form.subscription') }}
                                    </label>
                                    <div class="fv-plugins-message-container invalid-feedback"></div>
                                </div>

                                <span class="text-danger error-text type_error"></span>
                                <div class=" mb-5 col-md-7"></div>


                                <div class=" mb-2 col-md-6 mt-4" id="price" style="">
                                    <!--begin::Label-->
                                    <label class="fw-semibold mb-2"
                                        id="price">{{ __('site.packages-list.form.price') }}</label>
                                    <input type="text" name="price" id="price" class="prices form-control">
                                    <span class="text-danger error-text price_error"></span>
                                </div>

                                <div class=" mb-2 paymentType col-md-6 mt-4" style="display: none;">

                                    <label class="paymentType fw-semibold mb-2"
                                        style="display: none;">{{ __('site.packages-list.form.Type') }} </label>
                                    <select class="form-select paymentType" name="paymentType" id="paymentType"
                                        data-control="select2" data-placeholder="Select an option"
                                        style="display: none;">
                                        <option value="">--select--</option>
                                        <option value="yearly">Yearly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                    <span class="text-danger error-text paymentType_error"></span>
                                </div>
                                @csrf
                                <div class="col-sm-12 mt-5 d-flex justify-content-center">
                                    <button type="button" id="save" class="btn btn-primary">
                                        {{ __('site.packages-list.form.submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
