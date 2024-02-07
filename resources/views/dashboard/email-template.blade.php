<x-main-dashboard>
    @php
        $title = __('site.email-template.title');
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
                <form id="FromID" method="post" data-URL="{{ route('emailSave') }}">
                    <div class="card p-3">
                        <div class="row">
                            <input type="hidden" id="id" name="id" value="{{ $email->id ?? '' }}" >
                            @csrf
                            <div class="col-md-12">
                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    <label>{{ __('site.email-template.emailtitle') }}</label>
                                    <input type="text" name="status_title" id="status_title"
                                        value="{{ $email->status_title ?? '' }}" class="form-control">
                                </div>

                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    <label>{{ __('site.email-template.statustitle') }}</label>
                                    <input type="text" name="title" id="title" value="{{ $email->title ?? '' }}"
                                        class="form-control">
                                </div>

                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    <label>{{ __('site.email-template.body') }}</label>
                                    <textarea name="text" id="text" class="form-control" rows="3">{{ $email->text ?? '' }}</textarea>
                                </div>

                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    <label>{{ __('site.email-template.footer-text') }}</label>
                                    <textarea name="short_text" id="short_text" class="form-control" rows="2">{{ $email->short_text ?? '' }}</textarea>
                                </div>


                                <div>
                                    <center>
                                        <button type="button" class="btn btn-primary" id="UpdateSubmit">
                                            <span class="indicator-label">{{ __('site.email-template.save-update') }}</span>
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
