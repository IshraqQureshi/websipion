<div id="sidebar">
    <div class="sidebar-wrapper active">
        @include('layouts.admin.sidebar-head')
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">{{ __('sidebar.menu') }}</li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'home' ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>{{ __('dashboard.dashboard') }}</span>
                    </a>
                </li>

                @if (auth()->user()->role == 1 || auth()->user()->role == 3)
                    <li class="sidebar-item {{ Route::currentRouteName() == 'ClientsView' ? 'active' : '' }}">
                        <a href="{{ route('ClientsView') }}" class="sidebar-link">
                            <i class="bi bi-people-fill"></i>
                            <span>{{ __('sidebar.clients') }}</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ Route::currentRouteName() == 'PackagesList' ? 'active' : '' }}">
                        <a href="{{ route('PackagesList') }}" class="sidebar-link">
                            <i class="bi bi-bar-chart-steps"></i>
                            <span>{{ __('sidebar.packages') }}</span>
                        </a>
                    </li>
                @endif
                <li class="sidebar-item {{ Route::currentRouteName() == 'PackageList' ? 'active' : '' }}">
                    <a href="{{ route('PackageList') }}" class="sidebar-link">
                        <i class="bi bi-columns-gap"></i>
                        <span>{{ __('sidebar.buy_packages') }}</span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'tagsList' ? 'active' : '' }}">
                    <a href="{{ route('tagsList') }}" class="sidebar-link">
                        <i class="bi bi-tags-fill"></i>
                        <span>{{ __('sidebar.tags') }}</span>
                    </a>
                </li>

                <li
                    class="sidebar-item {{ Route::currentRouteName() == 'websiteList' || Route::currentRouteName() == 'CrawlDetails' ? 'active' : '' }}">
                    <a href="{{ route('websiteList') }}" class="sidebar-link">
                        <i class="bi bi-globe-central-south-asia"></i>
                        <span>{{ __('dashboard.website') .' List'  }}</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Route::currentRouteName() == 'crawlLog' ? 'active' : '' }}">
                    <a href="{{ route('crawlLog') }}" class="sidebar-link">
                        <i class="bi bi-bug-fill"></i>
                        <span>
                            {{ __('sidebar.crawl_log') }}
                        </span>
                    </a>
                </li>

                <li class="sidebar-item {{ Route::currentRouteName() == 'TransactionHistory' ? 'active' : '' }}">
                    <a href="{{ route('TransactionHistory') }}" class="sidebar-link">
                        <i class="bi bi-credit-card-fill"></i>
                        <span>{{ __('sidebar.payment_history') }}</span>
                    </a>
                </li>
                @if (auth()->user()->role == 1 || auth()->user()->role ==3)
                    <li
                        class="sidebar-item has-sub {{ Route::currentRouteName() == 'GatewaySettingsView' || Route::currentRouteName() == 'SMTPSettingsView' || Route::currentRouteName() == 'LogoSettingsView' || Route::currentRouteName() == 'HelpController' || Route::currentRouteName() == 'emailView' || Route::currentRouteName() == 'responders' || Route::currentRouteName() == 'sms-setting' || Route::currentRouteName() == 'social-auth-setting' || Route::currentRouteName() == 'language-settings' || Route::currentRouteName() == 'SignupSettingView' ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-gear-fill"></i>
                            <span>{{  __('sidebar.settings') }}</span>
                        </a>

                        <ul class="submenu" style="submenu-height: 521px;">
                            <li class="submenu-item">
                                <a href="{{ route('LogoSettingsView') }}" class="submenu-link">{{  __('sidebar.logo') }}</a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('HelpController') }}" class="submenu-link">{{ __('sidebar.help_content') }}</a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('emailView') }}" class="submenu-link">{{ __('sidebar.email_template') }}</a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('responders') }}" class="submenu-link">
                                    <span>{{ __('sidebar.auto_responders') }}</span>
                                </a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('mail-setting') }}" class="submenu-link">
                                    <span>{{ __('sidebar.email_notification_settings') }}</span>
                                </a>
                            </li>

                            <li
                                class="submenu-item {{ Route::currentRouteName() == 'GatewaySettingsView' ? 'active' : '' }}">
                                <a href="{{ route('GatewaySettingsView') }}" class="submenu-link">{{ __('sidebar.payment_settings') }}</a>
                            </li>

                            <li class="submenu-item">
                                <a href="{{ route('SMTPSettingsView') }}" class="submenu-link">{{ __('sidebar.smtp_settings') }}</a>
                            </li>

                            <li class="submenu-item ">
                                <a href="{{ route('sms-setting') }}" class="submenu-link">{{ __('sidebar.sms_settings') }}</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('social-auth-setting') }}" class="submenu-link">{{ __('sidebar.auth_settings') }}</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('SignupSettingView')}}" class="submenu-link">{{ __('sidebar.signup_settings') }}</a>
                            </li>
                            <li class="submenu-item">
                                <a href="{{ route('language-settings')}}" class="submenu-link">{{ __('sidebar.lang_settings') }}</a>
                            </li>

                        </ul>
                    </li>
                @endif


                <li class="sidebar-item {{ Route::currentRouteName() == 'Help' ? 'active' : '' }}">
                    <a href="{{ route('Help') }}" class="sidebar-link">
                        <i class="bi bi-info-circle"></i>
                        <span>{{ __('sidebar.help') }}</span>
                    </a>
                </li>

            </ul>
            <ul class="vs"> {{ __('sidebar.version') }}: {{ env('Version') }} </ul>
        </div>
    </div>
</div>
