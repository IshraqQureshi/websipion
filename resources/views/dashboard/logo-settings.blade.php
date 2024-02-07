<x-main-dashboard>
    @php
        $title = __('site.logo-settings.title');
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
                <!--begin::Row-->
                <form id="FormID" data-URl="{{ route('LogoUpdate') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $Logo['id'] }}">
                    <div class="card p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12">
                                    <img src="{{ asset('upload/logo/' . $Logo['favicon']) }}" height="90" alt="favicon">
                                </div>
                                <div class="col-md-12">
                                    <img src="{{ asset('upload/logo/' . $Logo['logo']) }}" height="90" alt="logo">
                                </div>
                                <div class="col-md-12">
                                    <img src="{{ asset('upload/logo/' . $Logo['dark_logo']) }}" height="90" alt="logo">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-4 col-md-12">
                                    <label class="required fw-semibold mb-2">{{ __('site.logo-settings.favicon') }}</label>
                                    <input type="file" name="favicon" id="favicon" class="form-control mb-lg-0"
                                        accept=".png" />
                                    <span class="text-danger error-text favicon_error"></span>
                                </div>

                                <div class="mb-4 col-md-12">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold mb-2">{{ __('site.logo-settings.logo') }}</label>
                                    <input type="file" name="logo" id="logo" class="form-control mb-lg-0"
                                        accept=".png" />
                                    <span class="text-danger error-text logo_error"></span>
                                    <!--end::Input-->
                                </div>

                                <div class="mb-4 col-md-12">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold mb-2">{{ __('site.logo-settings.logo-dark') }}</label>
                                    <input type="file" name="dark_logo" id="dark_logo" class="form-control mb-lg-0"
                                        accept=".png" />
                                    <span class="text-danger error-text dark_logo_error"></span>
                                    <!--end::Input-->
                                </div>
                                <div>
                                    <center>
                                        <button type="button" class="btn btn-primary" id="LogoSubmit">
                                            <span class="indicator-label">{{ __('site.logo-settings.save-update') }}</span>
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-main-dashboard>
