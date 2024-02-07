<x-main-dashboard>
    @php
        $title = __('site.auto-responder.title');
    @endphp
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="page-title mb-5">
                <div class="row">
                    <div class="col-12 col-md-9 order-md-1 order-last">
                        <h3>{{ $title }}</h3>
                    </div>
                    <div class="col-12 col-md-3 order-md-2 order-first">
                        <form id="FromIDdefaultSet" data-urlinsert="{{ URL::to('/dashboard/responders-default-set') }}">
                            <label class="fw-semibold mb-2">{{ __('site.auto-responder.default') }}</label>
                            <select class="form-select" name="defaultSet" id="defaultSet">
                                <option value="">--Select--</option>
                                @foreach ($ActiveResponders as $val)
                                    <option value="{{ $val->id }}" {{ $val->set == 'yes' ? 'selected' : '' }}>
                                        {{ $val->title }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            </div>


            <div class="row">
                @foreach ($nameTitileImg as $responder)
                    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-6">
                        <div class="card border-success mb-3 shadow">
                            <div class="card-header border-success text-white bg-primary">{{ $responder['title'] }}
                            </div>
                            <div class="card-body text-success text-center">
                                <img class="card-img-bottom" src="{{ $responder['icon'] }}" alt="Card image cap">
                                <button class="btn btn-sm btn-warning btn-block responderBtn" data-bs-toggle="modal"
                                    data-bs-target="#configuration-modal"
                                    data-GetInputsURL="{{ URL::to('/dashboard/responders-get-input') }}"
                                    data-whatever="{{ $responder['title'] }}" data-key="{{ $responder['key'] }}">{{ __('site.auto-responder.change') }}</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="configuration-modal"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalTitle">Modal title</h5>
                    <button type="button"class="modalHide btn btn-sm btn-light close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>

                <form data-urlinsert="{{ URL::to('dashboard/responders-config-save') }}" id="FromID" method="post">
                    <div class="modal-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only"></span>
                        </div>
                        <div class="row ShowInputs"></div>
                    </div>
                    @csrf
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary modalHide"
                            data-dismiss="modal">{{ __('site.auto-responder.close') }}</button>
                        <button type="button" id="saveConfig" class="btn btn-sm btn-primary">{{ __('site.auto-responder.save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    {{-- model box 2 --}}
    <div class="modal fade text-left modal-borderless modal-lg" data-bs-backdrop="static" id="campaignlistModel"
        tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h5 class="modal-title">Campaign List</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="FromIDCampaign" data-urlinsert="{{ URL::to('dashboard/responders-set-campaign-id') }}">
                        <div class="row mt-3">
                            <input type="hidden" id="ResponderID" name="ResponderID">
                            <div class="col-md-12 form-group">
                                <select class="form-control showResponder" name="responder_list" id="responder_list">
                                </select>
                            </div>
                            @csrf
                            <div class="col-sm-12 mt-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary mx-2 me-1 mb-1 modalHide"
                                    data-dismiss="modal">{{ __('site.auto-responder.close') }}</button>
                                <button type="button" id="RespondersCampaignID" class="btn btn-primary me-1 mb-1">
                                    {{ __('site.auto-responder.save-update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-main-dashboard>
