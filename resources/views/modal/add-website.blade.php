<div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="createWebsite" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">{{ __('site.website.pop.title') }}</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="FromID" data-URL="{{ route('websitesave') }}">
                    <div class="row">

                        <input type="hidden" name="id">

                        <div class="col-md-2">
                            <label>{{ $label }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <select name="ownerID" id="ownerID" class="form-control select2" style="width: 100%">
                                <option value="" selected>--Select--</option>
                                @foreach ($client as $key => $val)
                                    <option value="{{ $val->id }}" data-frequency="{{ $val->frequency }}">
                                        {{ $val->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text ownerID_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>{{ __('site.website.pop.domain') }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <input type="url" class="form-control" name="domainName"
                                placeholder="https://yourdomain.com">
                            <span class="text-danger error-text domainName_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>{{ __('site.website.pop.notify') }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <select name="email_cc_recipients[]" id="Select2emailCC" class="form-control Select2emailCC ShowDataemailCC"
                                multiple style="width: 100%">
                            </select>
                            <span class="text-danger error-text email_cc_recipients_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>{{ __('site.website.pop.frequency') }}</label>
                        </div>

                        <div class="col-md-10 form-group mb-4">
                            <select name="frequency" id="frequency" class="form-control select2" style="width: 100%">
                                <option value="" selected>--Select--</option>
                                @foreach (frequency() as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text frequency_error"></span>
                        </div>

                        @if (@$smsSettings->twilio_on_off == 'on')
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10 form-group mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="sms_notification"
                                        name="sms_notification">
                                    <label class="form-check-label" for="sms_notification">
                                        {{ __('site.website.pop.sms') }}
                                    </label>
                                    <span class="text-danger error-text sms_notification_error"></span>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-2">
                            <label>Tags</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <select name="tags[]" id="tags" class="form-control select2Tags" multiple
                                style="width: 100%">
                            </select>
                        </div>

                        <div class="col-md-2 SSLCertificate d-none">
                            <label>
                                SSL certificate expiry check
                            </label>
                        </div>

                        <div class="col-10 form-check p-0 SSLCertificate d-none">
                            <input class="form-check-input mx-3" type="checkbox" name="ssl_check">
                        </div>

                        @csrf
                        <div class="col-sm-12 mt-3 d-flex justify-content-center">
                            <button type="button" id="save" class="btn btn-primary me-1 mb-1">
                                {{ __('site.website.pop.submit') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- EDIT WEBSITE --}}

<div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="editWebsite" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">{{ __('site.website.pop.edit') }}</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="UpdateFromID">
                    <div class="row">
                        <input type="hidden" name="id">
                        <div class="col-md-2">
                            <label>{{ __('site.website.pop.domain') }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <input type="url" class="form-control" name="domainName"
                                placeholder="https://yourdomain.com">
                            <span class="text-danger error-text domainName_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>Notify Email</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <select name="email_cc_recipients[]" id="Select2emailCC"
                                class="form-control Select2emailCCEdit" multiple style="width: 100%">
                            </select>
                            <span class="text-danger error-text email_cc_recipients_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>Tags</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <select name="tags[]" id="tags" class="form-control select2TagsEdit" multiple
                                style="width: 100%">
                            </select>
                            <span class="text-danger error-text tags_error"></span>
                        </div>

                        <div class="col-md-2 SSLCertificate d-none">
                            <label>
                                SSL certificate expiry check
                            </label>
                        </div>

                        <div class="col-10 form-check p-0 SSLCertificate d-none">
                            <input class="form-check-input mx-3" type="checkbox" name="ssl_check">
                        </div>

                        @csrf
                        <div class="col-sm-12 mt-3 d-flex justify-content-center">
                            <button type="button" id="update" class="btn btn-primary me-1 mb-1">
                                {{ __('site.website.pop.update-save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
