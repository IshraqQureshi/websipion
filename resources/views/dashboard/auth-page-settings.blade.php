<x-main-dashboard>
    @php
        $title =  $title;
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
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card p-5">
                            <div class="card-body">
                                <form id="FromID" enctype="multipart/form-data" data-URL="{{ route('SignupSettingsUpdate') }}">
                                    <div class="row mt-5">
                                        <input type="hidden" name="id" id="id" value="{{ $data->id ?? '' }}">
                                        <div class="col-md-12">
                                            <h5> Sign Up </h5>
                                            <div class="form-check form-switch">
                                                <label>Enable / Disable</label>
                                                <input class="form-check-input" type="checkbox" id="signup_on_off" name="signup_on_off"
                                                {{ $data->signup_on_off ?? '' == 'on' ? 'checked' : '' }} >
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-5">
                                            <h5>Forgot password? </h5>
                                            <div class="form-check form-switch">
                                                <label>Enable / Disable</label>
                                                <input class="form-check-input" type="checkbox" id="password_on_off" name="password_on_off"
                                                {{ $data->password_on_off ?? '' == 'on' ? 'checked' : '' }} >
                                            </div>
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
                        <!-- end card -->
                    </div>
            </section>

        </div>
    </div>
</x-main-dashboard>
