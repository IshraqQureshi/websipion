<div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="createClient" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">{{ __('site.clients.add-client-title') }}</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="FromID" data-URL="{{ route('ClientSave') }}">
                    <div class="row">

                        <input type="hidden" name="id">

                        <div class="col-md-2">
                            <label>{{ __('site.clients.form.name') }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('site.clients.form.name') }}">
                            <span class="text-danger error-text name_error"></span>
                        </div>


                        <div class="col-md-2">
                            <label>{{ __('site.clients.form.email') }}</label>
                        </div>
                        <div class="col-md-10 form-group mt-1 mb-4">
                            <input type="email" class="form-control" name="email"
                                placeholder="{{ __('site.clients.form.email') }}">
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>{{ __('site.clients.form.mobile') }}</label>
                        </div>
                        <div class="col-md-10 form-group mt-1 mb-4">
                            <input type="number" class="form-control" name="mobile"
                                placeholder="{{ __('site.clients.form.mobile') }}">
                            <span class="text-danger error-text mobile_error"></span>
                        </div>

                        <div class="col-md-2">
                            <label>{{ __('site.clients.form.password') }}</label>
                        </div>
                        <div class="col-md-10 form-group mt-1 mb-4">
                            <input type="password" class="form-control" name="password"
                                placeholder="{{ __('site.clients.form.password') }}">
                            <span class="text-danger error-text password_error"></span>
                        </div>

                        <div class="col-md-2"></div>
                        <div class="col-md-10 ">
                            <label for="status">
                                <div class="form-check form-check-inline mx-2">
                                    <label class="form-check-label" for="inlineRadio1">Admin</label>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="1">
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="inlineRadio2">Client</label>
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        value="2" checked>
                                </div>
                            </label>
                        </div>

                        @csrf
                        <div class="col-sm-12 mt-3 d-flex justify-content-center">
                            <button type="button" id="Create" class="btn btn-primary me-1 mb-1">
                                {{ __('site.clients.form.submit') }}
                            </button>
                            <button type="button" id="update" class="btn btn-primary me-1 mb-1">
                                {{ __('site.clients.form.save-update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
