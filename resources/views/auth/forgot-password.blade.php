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
                    <h2>Forgot Password</h2>

                    <p>
                        Input your email and we will send you reset password link.
                      </p>

                    <form id="FromID" method="POST" data-urlinsert="{{ route('forgotPasswordSendLink') }}">
                        <div class="form-group position-relative has-icon-left mb-4 mt-5">
                            <input type="text" class="form-control form-control-xl"
                                placeholder="{{ __('auth.email') }}" name="email" />
                            <div class="form-control-icon">
                                <i class="bi bi-envelope ps-2"></i>
                            </div>
                            <span class="text-danger error-text email_error"></span>
                        </div>

                        @csrf
                        <button type="button" id="ForgotPassword" class="btn btn-primary btn-block btn-lg shadow-lg mt-3">
                            Forgot password
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
