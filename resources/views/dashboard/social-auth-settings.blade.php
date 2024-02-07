<x-main-dashboard>
    @php
        $title =  __('site.social-auth-setting.title')
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
                            <form id="FromID" enctype="multipart/form-data" data-URL="{{ route('social-auth-setting-update') }}">
                                <div class="row mt-5">
                                    <input type="hidden" name="id" id="id" value="{{ $social_settings['id'] ?? '' }}">
                                    <div class="col-md-12">
                                        <h5>Google Auth Settings</h5>
                                        <div class="form-check form-switch">
                                            <label>Enable / Disable</label>
                                            <input class="form-check-input" type="checkbox" id="google_on_off" name="google_on_off"
                                                {{ @$social_settings['google_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Google Client ID</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control"  name="google_client_id" id="google_client_id"
                                            value="{{ $social_settings['google_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Google Secret Key</label>
                                    </div>

                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" name="google_client_secret" id="google_client_secret"
                                            value="{{ $social_settings['google_client_secret'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <label class="mt-4 mb-2">Google Auth callback Url (readonly)</label>
                                        <input readonly class="form-control" type="text" name="google_redirect" id="google_redirect"
                                            value="{{ route('google.callback') }}">
                                    </div>

                                    {{-- Stripe --}}

                                    <div class="col-md-12 mt-5">
                                        <h5>Linkedin </h5>
                                        <label>Enable / Disable</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="linkedin_on_off" name="linkedin_on_off"
                                                {{ @$social_settings['linkedin_on_off'] == 'on' ? 'checked' : '' }}>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client ID</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="linkedin_client_id" name="linkedin_client_id"
                                            value="{{ $social_settings['linkedin_client_id'] ?? '' }}" placeholder="">
                                    </div>


                                    <div class="col-md-2">
                                        <label for="first-name-horizontal">Client Secret</label>
                                    </div>
                                    <div class="col-md-10 form-group">
                                        <input type="text" class="form-control" id="linkedin_client_secret" name="linkedin_client_secret"
                                            value="{{ $social_settings['linkedin_client_secret'] ?? '' }}" placeholder="">
                                    </div>

                                    <div class="col-sm-12 col-md-12">
                                        <label class="mt-4 mb-2">Linkedin Auth callback Url (readonly)</label>
                                        <input readonly class="form-control" type="text" name="linkedin_redirect" id="linkedin_redirect"
                                            value="{{ route('linkedin-callback') }}">
                                    </div>

                                </div>
                                <div class="row mt-5">
                                    @csrf
                                    <center>
                                        <div class="col-md-2 mt-3 mb-2">
                                            <button type="button" id="saveupdate" name="submit"
                                                class="btn btn-sm btn-primary px-4">{{ __('site.social-auth-setting.save-update') }}</button>
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
