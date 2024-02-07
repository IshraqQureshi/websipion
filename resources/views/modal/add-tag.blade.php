<div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="createTags" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header mb-3">
                <h5 class="modal-title">{{ __('site.tags-page.add-tag-title') }}</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="FromID" data-URL="{{ route('TagSave') }}">
                    <div class="row">
                        <input type="hidden" name="id">
                        <div class="col-md-2">
                            <label>{{ __('site.tags-page.form.name') }}</label>
                        </div>
                        <div class="col-md-10 form-group mb-4">
                            <input type="text" class="form-control" name="name"
                                placeholder="{{ __('site.tags-page.form.name') }}">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        @csrf
                        <div class="col-sm-12 mt-3 d-flex justify-content-center">
                            <button type="button" id="Create" class="btn btn-primary me-1 mb-1 d-none">
                                {{ __('site.clients.form.submit') }}
                            </button>

                            <button type="button" id="update" class="btn btn-primary me-1 mb-1 d-none">
                                {{ __('site.clients.form.save-update') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
