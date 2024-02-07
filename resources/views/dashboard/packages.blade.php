<x-main-dashboard>
    @php
        $title = __('site.packages.title');
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

            <section>
                <div class="row d-flex flex-wrap">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($package as $key => $val)
                                @php
                                    $type = $val->type == 'Fixed' ? 'OneTime' : $val->type;
                                @endphp
                                <div class="col packageSelected" data-type="{{ $type }}" data-price="{{ $val->price }}"  data-packageID="{{ $val->id }}" data-packageName="{{ $val->packageName }}"  data-paymentType="{{ $val->paymentType }}">
                                    <div class="card pricing text-center shadow-sm">
                                        <div class="card-body">
                                            <span>{{ $val->packageName }}</span>
                                            <div class="time fs-2 fw-bold flex-wrap">
                                                {{ $type }}
                                            </div>
                                            <div class="price fw-semibold opacity-75">Pay {{ $val->paymentType }}</div>
                                            <div class="cost"><span>$ </span> <span
                                                    class="fs-1 fw-bold">{{ $val->price }}</span>
                                                <span>/Website</span>
                                            </div>
                                            <div class="fs-5 fw-semibold opacity-75">
                                                {{ findFrequency($val->crawlFrequency) }}</div>
                                            <span><i class="bi bi-clock-history"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="title-price-card">{{ __('site.packages.title-pay') }}</h6>
                                <h6 class="title-price-second">{{ __('site.packages.website') }}</h6>
                                <div class="form-group w-50 mx-auto position-relative has-icon-left has-icon-right">
                                    <div class="numins minus">
                                        <i class="bi bi-dash-lg mt-1"></i>
                                    </div>
                                    <input type="number" class="form-control priceInput text-center" value="1">
                                    <div class="numdes plus">
                                        <i class="bi bi-plus-lg"></i>
                                    </div>
                                    <center><span class="Packagesmsg text-danger"></span></center>
                                </div>

                                <h5 class="text-center">{{ __('site.packages.total-cost') }}</h5>
                                <input type="hidden" id="paymentType">
                                <input type="hidden" id="packageName">
                                <input type="hidden" id="priceShow">
                                <input type="hidden" id="packageID">
                                <input type="hidden" id="type">
                                <center>
                                    <span class="payType">$</span>
                                    <span class="totalPrice">0</span>
                                    <span class="priceShowType"> USD</span>
                                </center>
                                <center>
                                    <button class="btn icon btn-primary p-2 px-4" id="PayMethod" data-bs-toggle="modal"
                                        data-bs-target="#pay"> &nbsp;
                                        {{ __('site.packages.paynow') }} <i class="bi bi-arrow-up-circle-fill fs-5 ps-2"></i>
                                    </button>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
    @include('modal.payment')
</x-main-dashboard>
