

<x-main-dashboard>
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
                            <li class="breadcrumb-item domainGet active" aria-current="page">
                                {{ pageTitle()[2] }}
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ pageTitle()[3] }}
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
                                <div class="col-lg-2 col-7">
                                    <input type="search" id="CrawlDetailsSearch"
                                        class="form-control" placeholder="Search Website" />
                                </div>
                                <div class="col display-none-sm"></div>
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body py-4 table-responsive">
                        <!--begin::Table-->
                        <table id="CrawlDetailsTable" class="table table-striped" data-URL="{{ route('CrawlDataTable') }}">
                            <!--begin::Table head-->
                            <thead>
                                <tr class="text-start fw-bold text-uppercase">
                                    <th>{{ __('site.crawl-details.s-n') }}</th>
                                    <th>{{ __('site.crawl-details.domain') }}</th>
                                    <th>{{ __('site.crawl-details.frequency') }}</th>
                                    <th>{{ __('site.crawl-details.Crawl') }}</th>
                                    <th>{{ __('site.crawl-details.status') }}</th>
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
