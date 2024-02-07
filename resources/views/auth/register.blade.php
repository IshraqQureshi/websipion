<x-auth>
    @section('title', $title)
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">

                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="">
                            <a href=""><img src="{{ LogoGet()['logo'] }}" class="login-logo" /></a>
                        </a>
                    </div>
                    <h1>{{ __('auth.signup') }}</h1>

                    <form id="FromID" data-urlinsert="{{ route('Register') }}">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ __('auth.name') }}" name="name" />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <span class="text-danger error-text name_error"></span>

                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ __('auth.email') }}" name="email" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <span class="text-danger error-text email_error"></span>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" id="password"
                                placeholder="{{ __('auth.password') }}" name="password" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <span class="text-danger error-text password_error"></span>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="show-password">
                                <span id="passmsg">{{ __('auth.password-show') }}</span>
                            </div>

                        </div>
                        @csrf
                        <button type="button" id="register" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            {{ __('auth.signup') }}
                        </button>
                    </form>


                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">
                            {{ __('auth.already-account') }}
                            <a href="{{ route('LoginView') }}" class="font-bold">{{ __('auth.login') }}</a>
                        </p>
                    </div>
                    <center> Version {{ env('Version') }}</center>
                </div>

            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right" class="login.bg"></div>
            </div>
        </div>
        <style type="text/css">
            #auth #auth-right {
                background: url({{ asset('assets/media/WDD-Transperent-BG-2.webp') }}), linear-gradient(90deg, #2d499d, #3f5491);
                background-size: contain, cover;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
    </div>
</x-auth>
