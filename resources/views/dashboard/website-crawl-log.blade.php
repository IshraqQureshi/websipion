<x-main-dashboard>
    @php
        $title = __('site.crawl-log.title');
    @endphp
    @section('title', $title)
    @push('page_styles')
        <style>
            #overlay-loader {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .loader {
                border: 16px solid #f3f3f3;
                border-top: 16px solid #3498db;
                border-radius: 50%;
                width: 120px;
                height: 120px;
                animation: spin 2s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
    @endpush
    <div id="overlay-loader">
        <div class="loader"></div>
    </div>
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
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="row">
                                <div class="col-lg-2 col-12">
                                    <input type="search" id="CrawlDetailsSearch" class="form-control"
                                        placeholder="Search Website" />
                                </div>
                                <div class="col-md-6">

                                </div>
                                <div class="col-md-4 mtt-sm-2 text-end">
                                    <div class="row gx-0">

                                        <div class="col-md-4">
                                            <div class="d-flex flex-nowrap me--7">
                                           <div> <i class="bi bi-info-circle fs-5 text-dark me-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Set the frequency of auto-cleaning of crawl logs.">
                                        </i></div>
                                        <div>
                                            <select name="select2DeleteLog" id="select2DeleteLog"
                                                class="form-control select2DeleteLog h-32px" placeholder="Select"
                                                data-id="{{ $crawldeletescheduling->id ?? '' }}"
                                                data-url="{{ route('CrawlDeleteScheduling') }}" style="width: 100%">
                                                <option value=" " data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == ' ' ? 'selected' : '' }}>
                                                    Clear Manually</option>
                                                <option value="daily"  data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == 'daily' ? 'selected' : '' }}>
                                                    Clear Daily</option>
                                                <option value="weekly"  data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == 'weekly' ? 'selected' : '' }}>
                                                    Clear Weekly</option>
                                                <option value="everyTwoDays"  data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == 'everyTwoDays' ? 'selected' : '' }}>
                                                    Clear in 2 Days</option>
                                                <option value="everyFiveDays"  data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == 'everyFiveDays' ? 'selected' : '' }}>
                                                    Clear in 5 Days</option>
                                                <option value="monthly"  data-image="{{ asset('clear.png') }}"
                                                    {{ ($crawldeletescheduling->delete_type ?? '') == 'monthly' ? 'selected' : '' }}>
                                                    Clear Monthly</option>
                                            </select>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-8 mtt-sm-2 ">

                                            <a class="btn btn-info btn-sm  text-white crawlManually">
                                                <i class="bi bi-bug"></i> {{ __('site.crawl-log.crawl-live') }}
                                            </a>
                                            <a class="btn btn-danger btn-sm mx-2 deleteAllLogs cursor-pointer">
                                                <i class="bi bi-trash"></i> {{ __('site.crawl-log.all-delete') }}
                                            </a>
                                            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-arrow-left"></i> {{ __('site.crawl-log.back') }}
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4 table-responsive">
                        <!--begin::Table-->
                        <table id="CrawlDetailsTable" class="table table-striped"
                            data-URL="{{ route('crawlLogDatatable') }}"
                            data-deleteAllLogs="{{ route('deleteAllLogs') }}"
                            data-crawlManually="{{ route('crawlManually') }}">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start fw-bold text-uppercase">
                                    <th> {{ __('site.crawl-log.list.s-n') }}</th>
                                    <th>{{ __('site.crawl-log.list.domain') }}</th>
                                    <th>{{ __('site.crawl-log.list.frequency') }}</th>
                                    <th>{{ __('site.crawl-log.list.crawltime') }}</th>
                                    <th>{{ __('site.crawl-log.list.Status') }}</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <tbody class="fw-semibold">

                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
            </section>

        </div>
    </div>
</x-main-dashboard>
