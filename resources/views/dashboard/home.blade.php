<x-main-dashboard>
    @section('title', $title)
    @push('page_styles')
        <style>
            .bg-img-sdd {
                background-image: url("{{ asset('UpgradeSDD.png') }}");
                background-size: 100% 100%;
            }
        </style>
    @endpush
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
                <div class="col-12 col-xl-12">
                    <div class="card bg-img-sdd">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-xl-7 m-auto pt-3 pb-5">
                                    <h3 class="text-white text-center mt-3">{{ __('dashboard.upgrade_plan_to') }}</h3>
                                    <!--begin::Items-->
                                    <center>
                                        <a href="{{ route('PackageList') }}"
                                            class="btn bg-primary rounded-30 text-white text-center mt-5 mb-3">{{ __('dashboard.upgrade_plan') }}
                                        </a>
                                        <div class="d-flex align-items-center mt-3">
                                            <div class="col-md-6">
                                                <div class="m-0">
                                                    <span class="fw-bold d-block text-white"> <i
                                                            class="bi bi-calendar3-range-fill mx-2"></i>{{ __('dashboard.add_more_website') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="m-0">
                                                    <span class="fw-bold d-block text-white"> <i
                                                            class="bi bi-hourglass-split mx-2"></i>
                                                        {{ __('dashboard.hourly_monitering') }}</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach ($overview as $detail)
                        <div class="col-12 col-xl-3">
                            <div class="card p-4">
                                <div class="card-header">
                                    <h4>
                                        <i class="bi bi-calendar3 me-1"></i> {{ $detail['title'] }}
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <span class="fw-semibold fs-1">{{ $detail['count'] }}</span>
                                    <p class="fw-semibold">{{ __('dashboard.website') }}</p>
                                    <div class="flex-nowrap d-flex flex-row">
                                        @foreach ($detail['checked'] as $val)
                                            @php
                                                $logo = $val['favicon_name'] ?? $val['website']['favicon_name'];
                                                if ($logo == 'favicon.png') {
                                                    $img = "<i class='bi bi-globe fs-2'></i>";
                                                } else {
                                                    $img = "<img src='" . asset('upload/favicon/' . $logo) . "'>";
                                                }

                                            @endphp
                                            <div
                                                title="{{ withouthttpsDomain($val['domainName'] ?? $val['website']['domainName']) }}">
                                                {!! $img !!}
                                            </div>
                                        @endforeach
                                        <a>
                                            <span class="fw-bold">+{{ $detail['count'] }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <!--begin::Page title-->
                    <div class="d-flex flex-column justify-content-center flex-wrap me-3 ">
                        <!--begin::Title-->
                        <div>
                            <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0">
                                {{ __('dashboard.websites') }}
                            </h1>
                        </div>

                    </div>

                    </i>
                    <div class="ms-auto me-2">
                        <span class="btn btn-sm fw-bold"> {{ __('dashboard.status_info') }} </span>
                        <span class="btn btn-sm fw-bold btn-success" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="{{ __('dashboard.up') }}"> &nbsp; </span>
                        <span class="btn btn-sm fw-bold btn-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="{{ __('dashboard.down') }}"> &nbsp;</span>
                        <span class="btn btn-sm fw-bold btn-light" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="{{ __('dashboard.failed') }}"> &nbsp; </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3 mx-3">
                        <!--begin::Secondary button-->
                        <a href="{{ route('websiteList') }}" class="btn btn-sm fw-bold btn-primary">
                            {{ __('dashboard.see_all_website') }}</a>
                        <!--end::Primary button-->
                    </div>
                    <!--end::Actions-->
                </div>
                <div class="row mt-3">
                    @forelse($websites as $web)
                        @php
                            $status = \App\Models\CrawlingLog::where(['websiteID' => $web->websiteID])
                                ->select(
                                    DB::raw("CASE WHEN status = '0' THEN 'danger'
                                                    WHEN status = '1' THEN 'success'
                                                    ELSE 'secondary'
                                                    END AS status"),
                                    'crawlTime',
                                )
                                ->latest()
                                ->first();

                            if ($web['favicon_name'] == 'favicon.png') {
                                $img = "<i class='bi bi-globe fs-2'></i>";
                            } else {
                                $img = "<img src='" . asset('upload/favicon/' . $web['favicon_name']) . "'>";
                            }

                        @endphp
                        <div class="col-12 col-xl-4">
                            <div class="card">
                                <div class="card-body mb-5">
                                    <div class="d-flex justify-content-start align-item-center">
                                        <div class="mx-1">
                                            {!! $img !!}
                                        </div>
                                        <div class="mx-1">
                                            {{ withouthttpsDomain($web['domainName']) }}
                                        </div>
                                        <div class="mx-1">
                                            <div class="spinner-grow spinner-grow-sm text-{{ $status->status ?? '' }}">
                                                <span class="visually-hidden">{{ __('dashboard.loading') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive mt-5">
                                        <table class="table align-middle gs-0 gy-4 my-0">
                                            <tbody>
                                                <tr>
                                                    <th>{{ __('dashboard.checked') }}</th>
                                                    <td class="text-end">
                                                        <span
                                                            class="fw-bold">{{ findFrequency($web->frequency) }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('dashboard.last_updated') }}</th>
                                                    <td class="text-end">
                                                        {{ $status->crawlTime ?? __('dashboard.nan') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ __('dashboard.last_down') }}</th>
                                                    <td class="text-end">
                                                        @php
                                                            echo isset($status->status) && $status->status != 'secondary' ? $status->crawlTime ?? __('dashboard.nan') : __('dashboard.nan');
                                                        @endphp
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</x-main-dashboard>
