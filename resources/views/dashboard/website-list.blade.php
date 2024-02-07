<x-main-dashboard>
    @php
        $title = __('site.website.title');
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
                                    <input type="search" id="WebsiteSearch" class="form-control"
                                        placeholder="{{ __('site.website.search-website') }}" />
                                </div>
                                <div class="col-lg-2 col-7">
                                    <select name="tagSearch" id="tagSearch" class="form-control select2TagSearch"
                                        multiple="multiple" placeholder="Select Tags" style="width: 100%">
                                        @foreach (explode(',', $tagSearch) as $val)
                                            <option value="{{ $val }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col display-none-sm"></div>
                                <div class="col-md-3 col-5 text-end">
                                    @if ($is_add_website)
                                        <a href="javascript:vaid(0)" data-bs-toggle="modal"
                                            data-bs-target="#createWebsite" class="btn btn-primary createWebsite">
                                            {{ __('site.website.add-website') }}

                                        </a>
                                    @else
                                        <a href="{{ route('PackageList') }}" class="btn btn-primary">
                                            {{ __('site.website.buy-more') }}
                                        </a>
                                    @endif
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
                        <table id="WebsiteTable" class="table table-striped" data-URL="{{ route('websiteDataTable') }}"
                            data-update-URL="{{ route('websiteupdate') }}"
                            data-Delete-URL="{{ route('websiteDelete') }}"
                            data-status-URL="{{ route('WebsiteStatusURL') }}"
                            data-cc_email_list="{{ route('cc_email_list') }}"
                            data-tag-list="{{ route('tag-list-load') }}">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start fw-bold text-uppercase">
                                    <th>{{ __('site.website.list.s-n') }}</th>
                                    <th>{{ __('site.website.list.domain') }}</th>
                                    <th>Tags</th>
                                    <th>SSL Status</th>
                                    <th>{{ __('site.website.list.frequency') }}</th>
                                    <th>{{ __('site.website.list.status') }}</th>
                                    <th class="text-end">{{ __('site.website.list.action') }}</th>
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
    @include('modal.add-website')
</x-main-dashboard>
