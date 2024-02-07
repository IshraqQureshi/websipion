<x-main-dashboard>
    @php
        $title = __('site.profile-edit.title');
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
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ pageTitle()[3] }}
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ pageTitle()[4] }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </x-breadcrumb-header>

            <section class="section">
                <form id="FromID" data-url="{{ route('saveProfile') }}">
                    <div class="card p-5">
                        <div class="mb-5">
                            <div class="row">
                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <input type="hidden" id="id" name="id" value="{{ $user->id }}">

                                    @csrf

                                    <label class="fw-semibold mb-2">{{ __('site.profile-edit.Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="" value="{{ $user->name }}" />
                                    <span class="text-danger error-text name_error"></span>

                                    <!--end::Input-->
                                </div>


                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label
                                        class="required fw-semibold mb-2">{{ __('site.profile-edit.Email') }}</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="" value="{{ $user->email }}" />
                                    <span class="text-danger error-text email_error"></span>

                                    <!--end::Input-->
                                </div>


                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label class="fw-semibold mb-2">{{ __('site.profile-edit.Mobile') }}</label>
                                    <input type="number" name="mobile" id="mobile" class="form-control"
                                        placeholder="" value="{{ $user->mobile }}" />
                                    <span class="text-danger error-text mobile_error"></span>

                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-4 col-md-8">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold mb-2">{{ __('site.profile-edit.Address') }}
                                    </label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="" value="{{ $user->address }}" />
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold mb-2">{{ __('site.profile-edit.Country') }}</label>
                                    <select class="form-select select2" name="country" id="country"
                                        data-control="select2" data-placeholder="Select an option">
                                        <option></option>
                                        @foreach ($country as $val)
                                            <option value="{{ $val->id }}"
                                                {{ $user->country == $val->id ? 'selected' : '' }}>{{ $val->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold mb-2">{{ __('site.profile-edit.State') }}</label>
                                    <input type="text" name="state" id="state" class="form-control"
                                        placeholder="" value="{{ $user->state }}" />
                                    <!--end::Input-->
                                </div>


                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold mb-2">{{ __('site.profile-edit.City') }}</label>
                                    <input type="text" name="city" id="city" class="form-control"
                                        placeholder="" value="{{ $user->city }}" />
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-4 col-md-4">
                                    <!--begin::Label-->
                                    <label class="fw-semibold mb-2">{{ __('site.profile-edit.Zip') }}</label>
                                    <input type="text" name="zipCode" id="zipCode" class="form-control"
                                        placeholder="" value="{{ $user->zipCode }}" />
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-4 col-md-6">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold mb-2">{{ __('site.profile-edit.GST') }}</label>
                                    <input type="text" name="gstNumber" id="gstNumber" class="form-control"
                                        placeholder="" value="{{ $user->gstNumber }}" />
                                    <!--end::Input-->
                                </div>

                                <div class="fv-row mb-4 col-md-6">
                                    <label class="fw-semibold mb-2">{{ __('site.profile-edit.Password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="" />
                                    <!--end::Input-->
                                </div>

                                <div class="mt-2">
                                    <button type="button" class="btn btn-primary" id="UpdateProfile">
                                        <span class="indicator-label">{{ __('site.profile-edit.update') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

        </div>
    </div>
</x-main-dashboard>
