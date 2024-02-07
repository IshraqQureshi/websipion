<x-main-dashboard>
    @php
        $title = __('site.email-notification.title');
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
                <form id="FromID" method="post"  method = "post">
                    <input type="hidden" name="url" value="{{ route('siteUpDownSave') }}" id = "url"/>
                    <div class="card p-3">
                        <div class="row">
                            {{--<input type="hidden" id="id" name="id" value="{{ $email->id ?? '' }}" >--}}
                            @csrf

                            <input type="hidden" value="{{$settings->id ?? ''}}" name='id'>
                            <div class="col-md-12">
                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    {{-- dd(__('site'),__LINE__,__FILE__) --}}

                                    <input type="checkbox" name="add_mail" id="status_title"
                                         class="form-check-input remember me-2" {{$settings->site_add_on_off == '1' ? 'checked' : ''}}>
                                <label class="form-check-label fs-7 text-gray-600">Send an email when a new site is added.</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>

                                <div class="fv-row mb-4 col-md-12 fv-plugins-icon-container">
                                    {{--<label>{{ __('site.email-template.statustitle') }}</label>--}}

                                    <input type="checkbox" name="up_down_mail" id="title"
                                        class="form-check-input remember me-2" {{$settings->site_up_on_off == '1' ? 'checked' : ''}}>
                                    <label class="form-check-label fs-7 text-gray-600">Send an email when the website is down and another email when the website is up again, without sending continuous emails in between.</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>




                                <div>
                                    <center>
                                        <button type="submit" class="btn btn-primary" id="UpdateSubmit">
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
