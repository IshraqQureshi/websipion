<x-auth>
    @section('title', $title)
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">

                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="">
                            <a href=""><img src="{{ LogoGet()['logo'] }}" class="login-logo" alt="Logo" /></a>
                        </a>
                    </div>
                    <h1>Login</h1>

                    <div class="row text-center d-flex justify-content-center mb-4">
                        @if ($googleLinkedin->google_on_off ?? '' == 'on')
                            <div class="col-md-5 m-2 text-center card py-3">
                                <a href="{{ route('google.login') }}">
                                    <img alt="Logo"
                                        src="{{ asset('assets/media/svg/brand-logos/google-icon.svg') }}"
                                        class="me-3 w-1-6" />
                                    <span>{{ __('auth.sign-in-with-google') }}</span>
                                </a>
                            </div>
                        @endif
                        @if ($googleLinkedin->linkedin_on_off ?? '' == 'on')
                            <div class="col-md-5 m-2 text-center card py-3">
                                <a href="{{ route('linkedinRedirect') }}">
                                    <img alt="Logo" src="{{ asset('assets/media/svg/brand-logos/linkedin-2.svg') }}"
                                        class="me-3 w-1-6" />
                                    <span>{{ __('auth.sign-in-with-linkedin') }}</span>
                                </a>
                            </div>
                        @endif
                    </div>

                    <form id="FromID" method="POST" data-urlinsert="{{ route('Login') }}">
                        <div class="form-group position-relative has-icon-left mb-4 mt-5">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ __('auth.email') }}" name="email" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope ps-2"></i>
                            </div>
                            <span class="text-danger error-text email_error"></span>

                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <input type="password" class="form-control form-control-xl" id="password"
                                placeholder="{{ __('auth.password') }}" name="password" />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock ps-2"></i>
                            </div>
                            <span class="text-danger error-text password_error"></span>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="show-password">
                                <span id="passmsg">{{ __('auth.password-show') }}</span>
                            </div>
                        </div>

                        <div class="col-12 form-check form-check-lg d-flex flex-nowrap align-items-center">
                            <input class="form-check-input remember me-2" type="checkbox"
                                name="remember" id="remember" value="1">
                            <label class="form-check-label fs-7 text-gray-600" for="remember">
                                Remember me
                            </label>
                        </div>


                        @csrf
                        <button type="button" id="login" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                            Login
                        </button>
                    </form>

                    <div class="text-center mt-5 text-lg fs-4">
                        @if ($AuthPageSettings->signup_on_off ?? '' == 'on')
                            <p class="text-gray-600">
                                {{ __('auth.dont-have-account') }}
                                <a href="/register" class="font-bold">{{ __('auth.signup') }}</a>
                            </p>
                        @endif
                        @if ($AuthPageSettings->password_on_off ?? '' == 'on')
                            <p>
                                <a class="font-bold" href="{{ route('forgotPassword') }}">Forgot password?</a>
                            </p>
                        @endif
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
