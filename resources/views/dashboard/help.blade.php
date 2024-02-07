<x-main-dashboard>
    @php
        $title = __('site.help-content.title')
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
                <form class="form" id="FromID" method="post" data-URL="{{ route('HelpUpdateController') }}">
                    <div class="card p-3">
                        <div class="row">
                            <input type="hidden" id="id" name="id" value="{{ $help->id }}">
                            <div class="col-md-12">
                                <div class="fv-row mb-4 col-md-12">
                                    <textarea name="help_content" id="summernote" class="form-control" rows="10">{{ $help->help_content }}</textarea>
                                </div>
                                @csrf
                                <div>
                                    <center>
                                        <button type="button" class="btn btn-primary" id="HelpSubmit">
                                            <span class="indicator-label">{{ __('site.help-content.save-update') }}</span>
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
