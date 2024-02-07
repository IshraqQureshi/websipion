<?php

use App\Http\Controllers\InstallHelperController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\WebGuard;

Route::post('/purchasecodeverify', [App\Http\Controllers\SocialWithLoginController::class, 'verifyPurchaseCode'])->name('purchasecodeverify');
Route::post('login', [\App\Http\Controllers\AuthController::class, 'Login'])->name('Login')->middleware('prevent-back-button');
Route::get('register', [\App\Http\Controllers\AuthController::class, 'RegisterView'])->name('RegisterView');
Route::post('register-save', [\App\Http\Controllers\AuthController::class, 'Register'])->name('Register')->middleware('mail');
Route::get('verify-account/{id}', [\App\Http\Controllers\AuthController::class, 'verify'])->name('verifyEmail');

Route::get('forgot-password', [\App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('send-link', [\App\Http\Controllers\AuthController::class, 'forgotPasswordSendLink'])->name('forgotPasswordSendLink')->middleware('mail');
Route::get('password-reset/{id}', [\App\Http\Controllers\AuthController::class, 'passwordChange'])->name('passwordChange');
Route::post('password-change-save', [\App\Http\Controllers\AuthController::class, 'passwordChangeSave'])->name('passwordChangeSave');

Route::get('signout', [\App\Http\Controllers\AuthController::class, 'signOut'])->name('signOut');
Route::post('/crawl-domain', [App\Http\Controllers\AuthController::class, 'crawlDomainFormHeader']);


//social with login
Route::prefix('google')->name('google.')->group(function () {
    Route::get('login', [App\Http\Controllers\SocialWithLoginController::class, 'loginWithGoogle'])->name('login')->middleware('socialsetting');
    Route::any('callback', [App\Http\Controllers\SocialWithLoginController::class, 'callbackFromGoogle'])->name('callback')->middleware('socialsetting');
});

Route::get('auth/linkedin', [App\Http\Controllers\SocialWithLoginController::class, 'linkedinRedirect'])->name('linkedinRedirect')->middleware('socialsetting');
Route::get('auth/linkedin/callback', [App\Http\Controllers\SocialWithLoginController::class, 'linkedinCallback'])->name('linkedin-callback')->middleware('socialsetting');
//social with login end


// webhook
Route::post('paypal-webhook-listener', [\App\Http\Controllers\Admin\PaymentController::class, 'paypalWebhook'])->name('paypal.webhook');
Route::post('razorpay-webhook', [\App\Http\Controllers\Admin\PaymentController::class, 'razorpayWebhook'])->name('razorpayWebhook');

//language switching
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\Admin\HelpController@switchLang']);

Route::prefix('dashboard')->middleware([WebGuard::class,'prevent-back-button'])->group(function () {
    Route::get('home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');

    // ClientsController
    Route::get('clients', [\App\Http\Controllers\Admin\ClientsController::class, 'index'])->name('ClientsView');
    Route::get('clients-dataTable', [\App\Http\Controllers\Admin\ClientsController::class, 'dataTable'])->name('ClientsDataTable');
    Route::post('client-save', [\App\Http\Controllers\Admin\ClientsController::class, 'save'])->name('ClientSave');
    Route::post('update-client', [\App\Http\Controllers\Admin\ClientsController::class, 'update'])->name('updateClient');
    Route::post('client-delete', [\App\Http\Controllers\Admin\ClientsController::class, 'delete'])->name('ClientDelete');
    Route::post('client-status', [\App\Http\Controllers\Admin\ClientsController::class, 'status'])->name('statusURL');
    Route::get('profile/{id}', [\App\Http\Controllers\Admin\ClientsController::class, 'profile'])->name('profile');
    Route::get('profile/edit/{id}', [\App\Http\Controllers\Admin\ClientsController::class, 'edit'])->name('EditProfile');
    Route::post('profile-save', [\App\Http\Controllers\Admin\ClientsController::class, 'saveProfile'])->name('saveProfile');


    // WebsitesController
    Route::get('website-list', [App\Http\Controllers\Admin\WebsitesController::class, 'index'])->name('websiteList');
    Route::post('cc-email-list', [App\Http\Controllers\Admin\WebsitesController::class, 'cc_email_list'])->name('cc_email_list');
    Route::post('tag-list-load', [App\Http\Controllers\Admin\WebsitesController::class, 'tag_list'])->name('tag-list-load');
    Route::post('website-save', [App\Http\Controllers\Admin\WebsitesController::class, 'save'])->name('websitesave')->middleware('mail');
    Route::post('website-update', [App\Http\Controllers\Admin\WebsitesController::class, 'update'])->name('websiteupdate');
    Route::get('website-dataTable', [App\Http\Controllers\Admin\WebsitesController::class, 'datatable'])->name('websiteDataTable');
    Route::post('website-delete', [\App\Http\Controllers\Admin\WebsitesController::class, 'delete'])->name('websiteDelete');
    Route::post('website-status', [\App\Http\Controllers\Admin\WebsitesController::class, 'status'])->name('WebsiteStatusURL');

    // CrawlingController
    Route::get('{name}/crawl-details', [App\Http\Controllers\Admin\CrawlingController::class, 'index'])->name('CrawlDetails');
    Route::get('crawl-dataTable', [App\Http\Controllers\Admin\CrawlingController::class, 'datatable'])->name('CrawlDataTable');

    Route::get('crawl-log', [App\Http\Controllers\Admin\CrawlingController::class, 'crawlLog'])->name('crawlLog');
    Route::get('crawl-log-datatable', [App\Http\Controllers\Admin\CrawlingController::class, 'crawlLogDatatable'])->name('crawlLogDatatable');
    Route::post('crawl-manually', [App\Http\Controllers\Admin\CrawlingController::class, 'crawlManually'])->name('crawlManually');
    Route::post('crawl-log-all-delete', [App\Http\Controllers\Admin\CrawlingController::class, 'deleteAllLogs'])->name('deleteAllLogs');
    Route::post('delete-scheduling', [App\Http\Controllers\Admin\CrawlingController::class, 'CrawlDeleteScheduling'])->name('CrawlDeleteScheduling');


    // PackagesController
    Route::get('packages-list', [App\Http\Controllers\Admin\PackagesController::class, 'index'])->name('PackagesList');
    Route::post('packages-save', [App\Http\Controllers\Admin\PackagesController::class, 'save'])->name('PackagesSave');
    Route::get('packages-dataTable', [App\Http\Controllers\Admin\PackagesController::class, 'datatable'])->name('packagesDataTable');
    Route::post('packages-status', [\App\Http\Controllers\Admin\PackagesController::class, 'status'])->name('packagesStatusURL');
    Route::post('packages-delete', [\App\Http\Controllers\Admin\PackagesController::class, 'delete'])->name('packageDelete');
    Route::get('packages', [\App\Http\Controllers\Admin\PackagesController::class, 'PackageList'])->name('PackageList');


    // PaymentController
    Route::post('payment-save-razorpay', [\App\Http\Controllers\Admin\PaymentController::class, 'PaymentSaveRazorpay'])->name('PaymentSaveRazorpay');
    Route::post('payment-stripe', [\App\Http\Controllers\Admin\PaymentController::class, 'PaymentStripe'])->name('PaymentSaveStripe');
    Route::any('stripe-success', [\App\Http\Controllers\Admin\PaymentController::class, 'stripeSuccess'])->name('stripeSuccess');
    Route::post('payment-paypal', [\App\Http\Controllers\Admin\PaymentController::class, 'PaymentPaypal'])->name('PaymentSavePayPal');
    Route::any('paypal-success', [\App\Http\Controllers\Admin\PaymentController::class, 'successPaypal'])->name('successPaypal');

    // TransactionHistory
    Route::get('transaction-history', [\App\Http\Controllers\Admin\TransactionHistory::class, 'index'])->name('TransactionHistory');
    Route::get('transaction-datatable', [\App\Http\Controllers\Admin\TransactionHistory::class, 'datatable'])->name('transactionHistoryDataTable');
    Route::any('invoice/{type}/{id}', [\App\Http\Controllers\Admin\TransactionHistory::class, 'invoice'])->name('invoice');

    //GatewaySettingsController
    Route::get('payment-gateway-settings', [\App\Http\Controllers\Admin\GatewaySettingsController::class, 'index'])->name('GatewaySettingsView');
    Route::post('gateway-settings-update', [\App\Http\Controllers\Admin\GatewaySettingsController::class, 'GatewaySettingsUpdate'])->name('GatewaySaveUpdate');

    //SMTPSettingsController
    Route::get('smtp-settings', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'index'])->name('SMTPSettingsView');
    Route::post('smtp-update', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'UpdateSMTP'])->name('UpdateSMTP');
    Route::post('aws-update', [\App\Http\Controllers\Admin\SMTPSettingsController::class, 'UpdateAWS'])->name('UpdateAWS');

    // LogoSettingsController
    Route::get('logo-settings', [\App\Http\Controllers\Admin\LogoSettingsController::class, 'index'])->name('LogoSettingsView');
    Route::post('logo-update', [\App\Http\Controllers\Admin\LogoSettingsController::class, 'LogoUpdate'])->name('LogoUpdate');


    // HelpController
    Route::get('help', [\App\Http\Controllers\Admin\HelpController::class, 'help'])->name('Help');
    Route::get('help-content', [\App\Http\Controllers\Admin\HelpController::class, 'index'])->name('HelpController');
    Route::post('help-update', [\App\Http\Controllers\Admin\HelpController::class, 'update'])->name('HelpUpdateController');

    // EmailController
    Route::get('email-template', [\App\Http\Controllers\Admin\EmailController::class, 'index'])->name('emailView');
    Route::post('email-template-save', [\App\Http\Controllers\Admin\EmailController::class, 'save'])->name('emailSave');
    Route::post('email-send-test', [\App\Http\Controllers\Admin\EmailController::class, 'testEmail'])->name('testEmail')->middleware('mail');


    //mail setting
    Route::get('email-notification-settings',[\App\Http\Controllers\Admin\EmailController::class, 'upmail'])->name('mail-setting');
    Route::post('mail-updownsave',[\App\Http\Controllers\Admin\EmailController::class, 'updownsave'])->name('siteUpDownSave');

    // RespondersController
    Route::get('auto-responder', [App\Http\Controllers\Admin\RespondersController::class, 'index'])->name('responders');
    Route::post('responders-get-input', [App\Http\Controllers\Admin\RespondersController::class, 'respondersGetInput']);
    Route::post('responders-config-save', [App\Http\Controllers\Admin\RespondersController::class, 'RespondersConfigSave']);
    Route::post('responders-default-set', [App\Http\Controllers\Admin\RespondersController::class, 'defaultSet'])->name('ResponderDefaultSet');
    Route::post('responders-set-campaign-id', [App\Http\Controllers\Admin\RespondersController::class, 'SetCampaignID']);

    // SMS Setting
    Route::get('sms-setting', [App\Http\Controllers\Admin\SMSSettingController::class, 'index'])->name('sms-setting');
    Route::post('sms-settings-update', [App\Http\Controllers\Admin\SMSSettingController::class, 'SmsSettingsUpdate'])->name('sms-setting.update');

    // Social Auth Setting
    Route::get('social-auth-setting', [App\Http\Controllers\Admin\SocialAuthController::class, 'index'])->name('social-auth-setting');
    Route::post('social-auth-settings-update', [\App\Http\Controllers\Admin\SocialAuthController::class, 'update'])->name('social-auth-setting-update');

    // Language Setting
    Route::get('language-settings', [App\Http\Controllers\Admin\HelpController::class, 'languageSettings'])->name('language-settings');
    Route::post('save-language-settings', [App\Http\Controllers\Admin\HelpController::class, 'saveLanguage'])->name('save-language');

    // SignupController
    Route::get('auth-page-settings', [App\Http\Controllers\Admin\SignupController::class, 'index'])->name('SignupSettingView');
    Route::post('auth-page-settings-update', [App\Http\Controllers\Admin\SignupController::class, 'saveUpdate'])->name('SignupSettingsUpdate');

    // TagController
    Route::get('tags-list', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('tagsList');
    Route::get('tags-dataTable', [\App\Http\Controllers\Admin\TagController::class, 'dataTable'])->name('TagsDataTable');
    Route::post('tags-save', [\App\Http\Controllers\Admin\TagController::class, 'save'])->name('TagSave');
    Route::post('tags-delete', [\App\Http\Controllers\Admin\TagController::class, 'delete'])->name('deleteTag');

});

// error
Route::get('/error', function () {
    abort(500);
});


if (file_exists(storage_path('installed'))) {
    Route::get('/', [\App\Http\Controllers\AuthController::class, 'LoginView'])->name('LoginView');
} else {
    Route::get('/', function () {
        return redirect('/install');
    });
}
