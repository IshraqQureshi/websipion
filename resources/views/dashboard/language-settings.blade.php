<x-main-dashboard>
    @php
        $title = __('site.language-settings.title');
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
                        <div class="card p-0">
                            <div class="card-body">

                                <span class="hideSMTP">
                                    <form method="POST" id="FromID" data-url="{{ Route('save-language') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 col-12 mt-5">
                                                <div class="row d-flex justify-content-start">
                                                    <div class="col-lg-2 col-6 text-end"><label class="form-label mt-2">
                                                            {{ __('site.language-settings.Default') }}</label>
                                                    </div>
                                                    <div class="col-lg-1"></div>
                                                    <div class="col-lg-5 col-6">
                                                        <select class="form-control" id="language" name="language">
                                                            <option value="">--select--</option>
                                                            @foreach (Config::get('languages') as $lang => $language)
                                                                <option value="{{ $lang }}"
                                                                    {{ Auth::user()->default_language == $lang ? 'selected' : '' }}>
                                                                    {{ $language }}
                                                            @endforeach
                                                        </select>
                                                        <div class="mt-5">
                                                            <button type="button" class="btn btn-primary"
                                                                id="LogoSubmit">
                                                                <span
                                                                    class="indicator-label">{{ __('site.language-settings.save-update') }}</span>
                                                            </button>
                                                        </div>

                                                    </div>
                                                    <i class="bi bi-info-circle fs-5 text-dark" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        data-bs-original-title="you can set the default language for your dashboard or interface. Choose your preferred language from the options provided to have all text, menus, and elements displayed in that language by default.">
                                                    </i>
                                                </div>

                                            </div>

                                        </div>

                                    </form>
                                </span>


                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
            </section>

        </div>
    </div>
</x-main-dashboard>
