<x-main-dashboard>
    @php
        $title = __('site.profile.title');
    @endphp
    @section('title', $title)
    <div id="main-content">
        <div class="page-heading">
            <div class="row">
                <div class="col-6 col-md-6 order-md-1 order-first">
                    <h3>{{ $title }}</h3>
                </div>
                <div class="col-6 col-md-6 order-md-2 order-last">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ul class="nav nav-tabs fs-4 fw-semibold">
                            <!--begin:::Tab item-->
                            <li class="nav-item ms-auto">

                                <a href="{{ route('home') }}" class="btn btn-primary btn-sm">{{ __('site.profile.back') }}
                                </a>
                                <a href="{{ route('EditProfile', Auth::user()->id) }}"
                                    class="btn btn-info btn-sm">{{ __('site.profile.edit') }}
                                </a>
                            </li>
                            <!--end:::Tab item-->
                        </ul>
                    </nav>
                </div>

            </div>

            <section class="section">
                <div class="row mt-2 mb-5">
                    <div class="flex-column-fluid">
                        <div class="d-flex flex-column flex-lg-row">
                            <!--begin::Sidebar-->
                            <div class="col-lg-4 col-12 flex-column">
                                <!--begin::Card-->
                                <div class="card mb-5">
                                    <!--begin::Card body-->
                                    <div class="card-body">
                                        <!--begin::Summary-->
                                        <!--begin::User Info-->
                                        <div class="d-flex flex-center flex-column py-5">
                                            <!--begin::Avatar-->
                                            <div class="mb-3 text-center">
                                                <img src="{{ asset('assets/media/avatars/300-1.jpg') }}"
                                                    class="w-25 rounded-circle" alt="image" />
                                            </div>
                                            <!--end::Avatar-->
                                            <!--begin::Name-->
                                            <a href="#"
                                                class="fs-3 fw-bold mb-3 text-center">{{ $user->name }}</a>
                                            <!--end::Name-->
                                        </div>
                                        <!--end::User Info-->


                                        <!--end::Summary-->
                                        <!--begin::Details toggle-->
                                        <div class="d-flex fs-4 py-1">
                                            <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                                href="#userProfileView" role="button" aria-expanded="false"
                                                aria-controls="userProfileView">{{ __('site.profile.details') }}
                                                <span class="ms-2 rotate-180">
                                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </div>
                                        </div>
                                        <!--end::Details toggle-->
                                        <!--begin::Details content-->
                                        <div id="userProfileView" class="collapse show">
                                            <div class="pb-2 fs-6">
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.name') }}</div>
                                                <div class="text-gray-600">
                                                    {{ $user->name }}
                                                </div>
                                                <!--begin::Details item-->
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.email') }}</div>
                                                <div class="text-gray-600">
                                                    <a href="#"
                                                        class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                                                </div>
                                                <!--begin::Details item-->
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.address') }}</div>
                                                <div class="text-gray-600">
                                                    {{ $user->address == '' ? '' : $user->address }}
                                                </div>
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.zip') }}</div>
                                                <div class="text-gray-600">{{ $user->zipCode }}</div>
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.city') }}</div>
                                                <div class="text-gray-600">{{ $user->city }}</div>
                                                <!--begin::Details item-->
                                                <!--begin::Details item-->
                                                <div class="fw-bold mt-3">{{ __('site.profile.state') }}</div>
                                                <div class="text-gray-600">{{ $user->state }}</div>

                                                <div class="fw-bold mt-3">{{ __('site.profile.country') }}</div>
                                                <div class="text-gray-600">{{ $user->country }}</div>

                                                <div class="fw-bold mt-3">{{ __('site.profile.gst-number') }}</div>
                                                <div class="text-gray-600">{{ $user->gstNumber }}</div>


                                                <!--begin::Details item-->
                                            </div>
                                        </div>
                                        <!--end::Details content-->
                                    </div>
                                    <!--end::Card body-->
                                </div>

                            </div>
                            <!--end::Sidebar-->
                            <!--begin::Content-->
                            <div class="col-lg-8 ms-4 profileOverview">
                                <!--begin:::Tabs-->

                                <!--end:::Tabs-->

                                <div class="card pt-4 mb-5">
                                    <!--begin::Card header-->
                                    <div class="card-header">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>{{ __('site.profile.website') }} </h2>
                                        </div>
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0 pb-5">
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed gy-5">
                                                <!--begin::Table head-->
                                                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-muted">
                                                        <th class="min-w-100px">{{ __('site.profile.domain') }}</th>
                                                        <th>{{ __('site.profile.frequency') }}</th>
                                                        <th>{{ __('site.profile.status') }}</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->
                                                <tbody class="fs-6 fw-semibold text-gray-600">
                                                    @if (!empty($website->toArray()))
                                                        @foreach ($website as $values)
                                                            @php
                                                                if ($values->favicon_name == 'favicon.png') {
                                                                    $img = "<i class='bi bi-globe fs-2'></i>";
                                                                } else {
                                                                    $logo =  asset('upload/favicon/' . $values->favicon_name);
                                                                    $img = "<img src='$logo'>";
                                                                }
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-5 position-relative">
                                                                            <div class="rounded-circle">
                                                                                {!!$img !!}
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex flex-column justify-content-center">
                                                                            <a
                                                                                class="mb-1 text-gray-800 text-hover-primary">{{ str_replace('http://', '', str_replace('https://', '', $values->domainName)) }}</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-info fw-bold px-3 py-1">{{ $values->frequency }}</span>
                                                                </td>
                                                                <td>
                                                                    @if ($values->status == 1)
                                                                        <span
                                                                            class="badge bg-success fw-bold px-3 py-1">Active</span>
                                                                    @elseif ($values->status == 0)
                                                                        <span
                                                                            class="badge bg-danger fw-bold px-3 py-1">Inactive</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <th>No website found.</th>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Card body-->
                                </div>

                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h2>{{ __('site.profile.transactions') }}</h2>
                                        </div>
                                        <!--end::Card title-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body py-0">
                                        <!--begin::Table wrapper-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table
                                                class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5">

                                                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-muted text-uppercase gs-0">
                                                        <th class="min-w-100px">{{ __('site.profile.package') }}</th>
                                                        <th>{{ __('site.profile.transaction_id') }}</th>
                                                        <th>{{ __('site.profile.payment') }}</th>
                                                        <th>{{ __('site.profile.mode') }}</th>
                                                        <th>{{ __('site.profile.date') }}</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>

                                                <!--begin::Table body-->
                                                <tbody>
                                                    @foreach ($paymentdetails as $val)
                                                        <tr>
                                                            <td class="min-w-70px">
                                                                <span
                                                                    class="badge bg-success fw-bold px-3 py-1">{{ $val->Getpackage->packageName }}</span>
                                                            </td>
                                                            <td>{{ $val->transactionID }}</td>
                                                            <td>{{ $val->totalPayment }}</td>
                                                            <td>{{ $val->paymentMode }}</td>
                                                            <td>{{ date('d-m-Y : h:i:s A', $val->transactionTime) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                            <!--end::Table-->
                                        </div>
                                        <!--end::Table wrapper-->
                                    </div>
                                    <!--end::Card body-->
                                </div>

                            </div>
                            <!--end::Content-->
                        </div>

                    </div>
                </div>
            </section>

        </div>
    </div>
</x-main-dashboard>
