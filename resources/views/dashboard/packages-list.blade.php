<x-main-dashboard>
    @php
        $title = __('site.packages-list.title')
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
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="row">
                                <div class="col-lg-2 col-7">
                                    <input type="search" id="PackageSearch"
                                        class="form-control" placeholder="{{ __('site.packages-list.search') }}" />
                                </div>
                                <div class="col display-none-sm"></div>
                                <div class="col-md-3 col-5 text-end">
                                    <a href="javascript:vaid(0)" data-bs-toggle="modal" data-bs-target="#createPackages" class="btn btn-primary createPackage">
                                      {{ __('site.packages-list.add-packages')}}
                                    </a>
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
                        <table id="PackagesTable" class="table table-striped" data-URL="{{ route('packagesDataTable') }}" data-update-URL="" data-Delete-URL="{{ route('packageDelete') }}" data-status-URL="{{ route('packagesStatusURL') }}">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start fw-bold text-uppercase">
                                    <th>{{ __('site.packages-list.list.S-n')}}</th>
                                    <th>{{ __('site.packages-list.list.name')}}</th>
                                    <th>{{ __('site.packages-list.list.frequency')}}</th>
                                    <th>{{ __('site.packages-list.list.type')}}</th>
                                    <th>{{ __('site.packages-list.list.type')}}</th>
                                    <th>{{ __('site.packages-list.list.price')}}</th>
                                    <th>{{ __('site.packages-list.list.status')}}</th>
                                    <th class="text-end">{{ __('site.packages-list.list.action')}}</th>
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
    @include('modal.add-packages')
</x-main-dashboard>
