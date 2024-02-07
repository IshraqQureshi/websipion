<header>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-lg-0">
                </ul>
                <div class="dropdown">

                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                {{-- {{ Config::get('languages')[App::getLocale()] }} --}}
                                {{-- <h1 class="mb-0 text-sm text-gray-600">
                                    <i class="fa-solid fa-language fas fs-4 me-1"></i>
                                </h1> --}}
                                <div class="me-3 list-style-type-none">
                                    <a class="dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                        <i class="bi bi-translate bi-sub fs-3"></i>
                                        <span class="badge badge-notification bg-primary me-3">{{ Config::get('languages')[App::getLocale()] }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                                        @foreach (Config::get('languages') as $lang => $language)
                                            @if ($lang != App::getLocale())
                                                <li class="dropdown-item notification-item">
                                                        <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{$language}}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </a>


                </div>

                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">{{ auth()->user()->name }}</h6>
                                <p class="mb-0 text-sm text-gray-600">
                                    @if (auth()->user()->role == '1')
                                        Admin
                                    @else
                                        User
                                    @endif
                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <img src="{{ asset('assets/compiled/jpg/1.jpg') }}" />
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                        style="min-width: 11rem">
                        <li>
                            <h6 class="dropdown-header">Hello, {{ auth()->user()->name }}</h6>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('profile', Auth::user()->id ) }}"><i class="icon-mid bi bi-person me-2"></i>Profile</a>
                        </li>

                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('signOut') }}"><i
                                    class="icon-mid bi bi-box-arrow-left me-2"></i>
                                Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
