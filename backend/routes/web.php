<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Marketplace\MarketplaceController@index')->name('marketplace.home');
Route::get('/accept/cookies','Marketplace\MarketplaceController@acceptCookies')->name('marketplace.accept.cookie');
Route::get('/lang/{locale}', 'Marketplace\LocaleController@set_locale')->name('marketplace.set_locale');

Route::get('/products', 'Marketplace\ProductsController@index')->name('marketplace.products');
Route::get('/product/{slug}', 'Marketplace\ProductsController@productDetails')->name('marketplace.product_detail');
Route::get('/products/category/{slug}', 'Marketplace\ProductsController@productsByCategory')->name('marketplace.products.bycategory');

Route::get('/stores', 'Marketplace\StoresController@index')->name('marketplace.stores');
Route::get('/partners','Marketplace\PartnerStoreController@index')->name('marketplace.partners');
Route::get('/partner/{slug}','Marketplace\PartnerStoreController@siglePartnerStore')->name('marketplace.single_partner');
Route::get('/redirect/td/{id}','Marketplace\PartnerStoreController@redirectToTradeDoubler')->middleware('auth:web')->name('redirect.tradedoubler');
Route::get('/partners/category/{slug}','Marketplace\PartnerStoreController@storesByCategory')->name('marketplace.partners_by_cat');
Route::get('/stores/{permalink}', 'Marketplace\StoresController@storeLanding')->middleware('store.visit')->name('marketplace.store_landing');
Route::get('/stores/type/{type}', 'Marketplace\StoresController@storesByType')->name('marketplace.stores.type');

Route::get('/stores/reviews/{permalink}', 'Marketplace\StoresController@storeReviews')->name('marketplace.store_reviews');
Route::get('/search/', 'Marketplace\MarketplaceController@search')->middleware('search')->name('marketplace.search');

Route::get('/stores/category/{slug}', 'Marketplace\StoresController@storesByCategory')->name('marketplace.store_by_cat');

Route::get('/around', 'Marketplace\AroundController@index')->name('marketplace.around');
Route::get('/around/data', 'Marketplace\AroundController@getStores')->name('marketplace.around.ajax');
Route::get('/storesaround','Marketplace\AroundController@storesAround');

Route::get('/mobile','Marketplace\MarketplaceController@mobileApp')->name('marketplace.app');

Route::get('/verify/mail/user/{token}', 'User\UserVerifyController@emailVerify')->name('user.verify.mail');
Route::get('/verify/referral/{referralCode}', 'Auth\ReferralCodeController@checkReferralCode')->name('referral.verify');



//ERRORS
Route::get('/404', 'Marketplace\ErrorController@error404')->name('error.404');


Route::post('/subscribe/newsletter', 'Marketplace\MarketplaceController@subscribeToNewsLetter')->name('marketplace.newsletter_subscribe');


Route::prefix('webhook')->group(function () {
    Route::post('/user/droppay/connection', 'Webhooks\UserDropPayWebhooks@userConnectionWebhook')->name('webhook.droppay_user_connection');
    Route::post('/store/droppay/connection', 'Webhooks\StoreDropPayWebhooks@storeConnectionWebhook')->name('webhook.droppay_store_connection');
    Route::post('/store/droppay/pull','Webhooks\StoreDropPayWebhooks@storePullWebhook')->name('webhook.droppay_store_pull');
    Route::post('/transaction/online/pull','Webhooks\StoreDropPayWebhooks@onlineStoreTransactionWebhook')->name('webhook.droppay_store_online_tr');
    Route::post('/transaction/offline/pull','Webhooks\StoreDropPayWebhooks@offlineStoreTransactionWebhook')->name('webhook.droppay_store_offline_tr');
    Route::get('/td/notify/{id}','Webhooks\TradeDoublerWebhook@transaction')->name('webhook.tradedoubler_notify_transaction');
});


Route::get('/add/favourites/{id}', 'Marketplace\FavouritesController@addToFavourites')->name('marketplace.add_favourite');
Route::get('/remove/favourites/{id}', 'Marketplace\FavouritesController@removeFavourite')->name('marketplace.remove_favourite');
Route::get('/checkout/{slug}', 'Marketplace\CheckoutController@checkOut')->name('marketplace.checkout')->middleware('user.dp.connection');
Route::get('/favourites', 'Marketplace\FavouritesController@index')->name('marketplace.favourites');

Auth::routes();
Route::get('/register/{refferalCode}','Auth\RegisterController@registerWithRefferal')->name('user.refferal_register');


/*INFO Routes */
Route::prefix('legal')->group(function () {
    Route::get('/cookies', 'Marketplace\InfoController@cookies')->name('marketplace.legal.cookies');
    Route::get('/faq', 'Marketplace\InfoController@faq')->name('marketplace.legal.faq');
    Route::get('/jobs', 'Marketplace\InfoController@jobs')->name('marketplace.legal.jobs');
    Route::get('/joinus', 'Marketplace\InfoController@joinUs')->name('marketplace.legal.joinus');
    Route::get('/for_users', 'Marketplace\InfoController@forUsers')->name('marketplace.legal.for_users');
    Route::get('/for_vendors', 'Marketplace\InfoController@forVendors')->name('marketplace.legal.for_vendors');
    Route::get('/privacy', 'Marketplace\InfoController@privacy')->name('marketplace.legal.privacy');
    Route::get('/terms', 'Marketplace\InfoController@terms')->name('marketplace.legal.terms');
    Route::get('/withdrawal','Marketplace\InfoController@rejectRight')->name('marketplace.legal.reject');

    Route::get('/documents/contract','Marketplace\InfoController@sellerContract')->name('marketplace.legal.seller_contract');
    Route::get('/documents/access_conditions','Marketplace\InfoController@accessConditions')->name('marketplace.legal.access_conditions');
    Route::get('/documents/selling_conditions','Marketplace\InfoController@sellingConditions')->name('marketplace.legal.selling_conditions');
});
/*INFO Routes */


Route::prefix('user')->group(function () {
    Route::get('/home', 'User\UserController@index')->name('home');
    Route::get('/notifications', 'User\NotificationController@index')->name('user.notifications');
    Route::get('/notifications/mark/seen', 'User\NotificationController@markAsSeen')->name('user.notifications.seen');
    Route::get('/logout', 'Auth\LoginController@userLogout')->name('user.logout');
    Route::get('/orders', 'User\OrdersController@index')->name('user.orders');
    Route::get('/wallet', 'User\WalletController@index')->name('user.wallet');
    Route::get('/settings', 'User\UserProfileController@index')->name('user.settings');
    Route::get('/droppay','User\DropPayController@index')->name('user.droppay');
    Route::get('/bank/configuration', 'User\BankAccountController@index')->name('user.bank_conf');
    Route::get('/royality', 'User\RoyalityController@index')->name('user.royality');
    Route::get('/cashback/requests','User\CashbackRequestController@index')->name('user.cashback_request');
    Route::get('/help', 'User\HelpController@index')->name('user.help');
    Route::get('/dispute/open/{orderId}','User\DisputeController@openDispute')->name('user.dispute_open');
    Route::get('/verify/phone', 'User\UserVerifyController@getPhoneVerify')->name('user.verify_phone');
    Route::get('/verify/phone/resend','User\UserVerifyController@resendSms')->name('user.verify_phone.resend');


    Route::get('/order/completed/','User\OnlineOrderController@orderCompletedSuccess')->name('order.completed');
    Route::get('/transaction/check/{pullId}','User\OnlineOrderController@checkTransactionStatus')->name('user.onlinetransaction.check');

    Route::post('wallet/filter','User\WalletController@walletByDate')->name('user.wallet.filter');
    Route::post('/update_user', 'User\UserProfileController@update_profile_info')->name('user.update_profile.submit');
    Route::post('/user_adress', 'User\UserProfileController@cor_user_shipping_info')->name('user.cor_adress.submit');
    Route::post('/update/bakinfo', 'User\BankAccountController@update_bank_infos')->name('user.bank_account.submit');
    Route::post('/order/review', 'User\ReviewController@add_review')->name('user.review.submit');
    Route::post('/help/request', 'User\HelpController@sendRequest')->name('user.help.submit');
    Route::post('/verify/phone/user', 'User\UserVerifyController@phoneVerify')->name('user.phone_verify.submit');
    Route::post('/require/cashback','User\CashbackRequestController@requireCashback')->name('user.request.cashback');
    Route::post('/dispute/send','User\DisputeController@submitDispute')->name('user.dispute.submit');


    /*AJAX*/
    Route::get('/notification', 'User\NotificationController@ajax_check_notification')->name('user.check_notification');
    Route::get('/get_address', 'User\UserProfileController@user_address')->name('user.get_address');
    Route::post('/order/create', 'User\OnlineOrderController@createOnlineOrder')->name('user.cart.process');
    Route::get('/order_completed', 'User\OnlineOrderController@order_completed')->name('user.cart_processed');
    Route::get('/droppay/check','User\DropPayController@checkDropPayStatus')->name('user.droppay.check');

});


Route::prefix('admin')->group(function () {

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    Route::get('/locale/{locale}', 'Admin\AdminLangController@setLocale')->name('admin.locale');

    Route::get('/', 'Admin\AdminController@index')->name('admin.home');
    Route::get('/stores', 'Admin\StoresController@index')->name('admin.stores');
    Route::get('/stores/{id}', 'Admin\StoresController@storeDetails')->name('admin.store_details');
    Route::get('/users', 'Admin\UsersController@index')->name('admin.users');
    Route::get('/user/details/{id}', 'Admin\UsersController@userDetails')->name('admin.user_details');
    Route::get('/transactions', 'Admin\TransactionsController@index')->name('admin.transactions');
    Route::get('/transactions/online', 'Admin\TransactionsController@onlineTransactions')->name('admin.online_transactions');
    Route::get('/transactions/offline', 'Admin\TransactionsController@offlineTransactions')->name('admin.offline_transactions');
    Route::get('/transactions/cash','Admin\TransactionsController@cashTransactions')->name('admin.cash_transactions');
    Route::get('/transactions/tradedoubler','Admin\TdTransactionsController@index')->name('admin.td_transactions');
    Route::get('/help/stores', 'Admin\StoreHelpRequest@index')->name('admin.store_help');
    Route::get('/help/stores/manage/{id}', 'Admin\StoreHelpRequest@manageRequest')->name('admin.store_help_single');
    Route::get('/help/stores/show/{id}', 'Admin\StoreHelpRequest@openRequest')->name('admin.store_help_single_show');
    Route::get('/products', 'Admin\ProductsController@index')->name('admin.products');
    Route::get('/cash_invoices','Admin\CashInvoiceController@index')->name('admin.cash_invoices');
    Route::get('/invoices', 'Admin\InvoiceController@index')->name('admin.invoices');
    Route::get('/invoices/download/{id}', 'Admin\InvoiceController@downloadInvoice')->name('admin.invoice.download');
    Route::get('/invoices/xml/download/{id}','Admin\InvoiceController@downloadXML')->name('admin.invoice.download_xml');
    Route::get('/cash/invoices/download/{id}','Admin\CashInvoiceController@downloadInvoice')->name('admin.cash.invoice.download');
    Route::get('/cash/invoices/xml/download/{id}','Admin\CashInvoiceController@downloadXML')->name('admin.cash.invoice.download_xml');
    Route::get('/cash/invoices/paymentmark/{id}','Admin\CashInvoiceController@markAsPaid')->name('admin.cash_invoice.paid');
    Route::get('/cash/invoices/marksent/{id}','Admin\CashInvoiceController@markAsSent')->name('admin.cash_invoice.sent');

    Route::get('/invoices/marksent/{id}','Admin\InvoiceController@markAsSent')->name('admin.invoice.sent');


    Route::get('/cash/status','Admin\CashSystemController@index')->name('admin.cash_status');
    Route::get('/ajax/stores/cash_status','Admin\CashSystemController@getStoreStatus')->name('admin.ajax_cash_status');


    Route::get('/product_categories', 'Admin\ProductCategoryController@index')->name('admin.product_categories');
    Route::get('/product_category/switch/{id}', 'Admin\ProductCategoryController@switchCategoryState')->name('admin.product_category_switch');
    Route::get('/product_category/edit/{id}', 'Admin\ProductCategoryController@showEditForm')->name('admin.product_category_edit');
    Route::get('/store_categories', 'Admin\StoreCategoryController@index')->name('admin.store_categories');
    Route::get('/store_category/switch/{id}', 'Admin\StoreCategoryController@switchStoreCategoryState')->name('admin.store_category.switch');
    Route::get('/store_category/edit/{id}', 'Admin\StoreCategoryController@showStoreCategoryEditForm')->name('admin.store_category.edit');
    Route::get('/orders', 'Admin\OrdersController@index')->name('admin.orders');
    Route::get('/order/details/{id}', 'Admin\OrdersController@orderDetails')->name('admin.order_details');
    Route::get('/newsletter', 'Admin\NewsletterController@index')->name('admin.newsletter');
    Route::get('/app_banners', 'Admin\AppBannersController@index')->name('admin.app_banners');
    Route::get('/app_banners/switch/{id}', 'Admin\AppBannersController@switchBanenrState')->name('admin.app_banners_switch');
    Route::get('/faqs', 'Admin\FaqController@index')->name('admin.faqs');
    Route::get('/faq/switch/{id}', 'Admin\FaqController@switchFaqState')->name('admin.faq.switch');
    Route::get('/faq/edit/{id}', 'Admin\FaqController@showEditFaqForm')->name('admin.faq.edit');
    Route::get('/manage_admins', 'Admin\AdminController@manageAdmins')->name('admin.manage_admins');
    Route::get('/manage_admins/switch/{id}', 'Admin\AdminController@switchAdminState')->name('admin.admin_switch');
    Route::get('/search_history', 'Admin\SearchController@index')->name('admin.search_history');
    Route::get('/td/tracking','Admin\TDTrackingController@index')->name('admin.td_tracking');
    Route::get('/fees', 'Admin\PlattformFeeController@index')->name('admin.fees');
    Route::get('/help/users', 'Admin\UserHelpRequestController@index')->name('admin.help_users');
    Route::get('/help/users/manage/{id}', 'Admin\UserHelpRequestController@showAnswerForm')->name('admin.user_help_single');
    Route::get('/help/users/show/{id}', 'Admin\UserHelpRequestController@showRequest')->name('admin.user_help_single_show');
    Route::get('/store_documents', 'Admin\StoreDocumentsController@index')->name('admin.store_documents');
    Route::get('/store_document/accept/{id}', 'Admin\StoreDocumentsController@acceptDocument')->name('admin.store_document.accept');
    Route::get('/store_document/decline/{id}', 'Admin\StoreDocumentsController@declineDocument')->name('admin.store_document.decline');
    Route::get('/royalties','Admin\RoyaltyController@index')->name('admin.royalties');
    Route::get('/royalties/getters/paid/{id}','Admin\RoyaltyController@markGetterRoyaltiesAsPaid')->name('admin.getters.royalties_paid');
    Route::get('/royalties/stores/paid/{id}','Admin\RoyaltyController@markStoreRoyaltiesAsPaid')->name('admin.stores.royalties_paid');
    Route::get('/cashback_requests/','Admin\CashbackRequestController@index')->name('admin.cashback_requests');
    Route::get('/cashback_request/details/{id}','Admin\CashbackRequestController@requestDetails')->name('admin.cashback_request.details');
    Route::get('/cashback_request/process/{id}','Admin\CashbackRequestController@processTransaction')->name('admin.cashback_request.process');
    Route::get('/ajax/cashback_requests/','Admin\CashbackRequestController@getRequests')->name('admin.ajax.cashback_requests');

    Route::get('/tradedoubler', 'Admin\TradeDoublerController@index')->name('admin.tradedoubler');
    Route::get('/tradedoubler/edit/{id}','Admin\TradeDoublerController@editStore')->name('admin.edit_tradedoubler');
    Route::get('/tradedoubler/discount/edit/{id}','Admin\TradeDoublerController@editStoreDiscount')->name('admin.tradedoubler.discount_edit');
    Route::get('/tradedouber/store/discounts/add/{id}','Admin\TradeDoublerController@newStoreDiscount')->name('admin.tradedoubler.create_discount');
    Route::get('/tradedoubler/discount/switch/{id}','Admin\TradeDoublerController@switchDiscountStatus')->name('admin.tradedoubler.discount.switch');
    Route::post('/tradedoubler/edit/store','Admin\TradeDoublerController@updateTradeDoublerStore')->name('admin.edit_tradedoubler.submit');
    Route::get('/tradedoubler/switch/{id}', 'Admin\TradeDoublerController@switchStoreState')->name('admin.tradedoubler.switch');

    Route::get('/ajax/tradedouber/stores', 'Admin\TradeDoublerController@getTdStores')->name('admin.ajax_tradedoubler');
    Route::get('/ajax/tradedoubler/store/discounts/{id}','Admin\TradeDoublerController@getStoreDiscounts')->name('admin.ajax_tradedoubler_discounts');

    Route::post('/tradedoubler/create', 'Admin\TradeDoublerController@createTdStore')->name('admin.tradedouber.submit');
    Route::post('/tradedoubler/create/discount','Admin\TradeDoublerController@createStoreDiscount')->name('admin.tradedoubler.discount.submit');
    Route::post('/tradedoubler/discount/edit','Admin\TradeDoublerController@editStoreDiscountSubmit')->name('admin.tradedoubler.discount_edit.submit');


    Route::get('/getters', 'Admin\GetterController@index')->name('admin.getters');
    Route::post('/getter/update','Admin\GetterController@updateGetter')->name('admin.getter.update');
    Route::get('/getter/switch/{id}', 'Admin\GetterController@swtichStatus')->name('admin.getters.switch');
    Route::get('/getters/{id}', 'Admin\GetterController@getGetter')->name('admin.getter.details');
    Route::get('/ajax/getters/transactions/{id}','Admin\GetterController@getGetterTransactions')->name('admin.ajax_getter.transactions');
    Route::get('/ajax/getters', 'Admin\GetterController@getGetters')->name('admin.get_getters');

    Route::get('ajax/getters/royalties','Admin\RoyaltyController@getGetterRoyalties')->name('admin.ajax.getters_royalties');
    Route::get('/ajax/stores/royalties','Admin\RoyaltyController@getStoreRoyalties')->name('admin.ajax_store_royalties');

    Route::get('/ajax/td/tracking/data','Admin\TDTrackingController@getTrackingData')->name('admin.ajax_td_tracking');




    Route::post('/help/stores/answer', 'Admin\StoreHelpRequest@answerToRequest')->name('admin.store_help_answer.submit');
    Route::post('/help/users/answer', 'Admin\UserHelpRequestController@answerToRequest')->name('admin.user_help_answer.submit');
    Route::post('/products/new_category', 'Admin\ProductCategoryController@createNewCategory')->name('admin.new_product_category.submit');
    Route::post('/products/category/edit', 'Admin\ProductCategoryController@editProductCategory')->name('admin.product_category_edit.submit');
    Route::post('/stores/new_category', 'Admin\StoreCategoryController@createStoreCategory')->name('admin.new_store_category.submit');
    Route::post('/stores/category/edit', 'Admin\StoreCategoryController@updateStoreCategory')->name('admin.store_category_edit.submit');
    Route::post('/app_banners/create', 'Admin\AppBannersController@createBanner')->name('admin.create_banner.submit');
    Route::post('/faqs/create', 'Admin\FaqController@createFaq')->name('admin.create_faq.submit');
    Route::post('/faqs/update', 'Admin\FaqController@editFaq')->name('admin.faq_update.submit');
    Route::post('/manage_admins/create', 'Admin\AdminController@createAdmin')->name('admin.create_admin.submit');
    Route::post('/fees/update', 'Admin\PlattformFeeController@updateFees')->name('admin.update_fees.submit');
    Route::post('/store/update/fee', 'Admin\StoresController@updateFreebackFee')->name('admin.store_update_fee');
    Route::post('/getters/create', 'Admin\GetterController@createGetter')->name('admin.create_getter.submit');
    Route::post('/store/force/changestatus','Admin\StoresController@storeSwitchStatus')->name('admin.store.forcestatus');

    /*AJAX*/
    Route::get('/ajax/stores', 'Admin\StoresController@getStores')->name('admin.ajax_stores');
    Route::get('/ajax/storereviews/{id}', 'Admin\StoresController@getStoreReviews')->name('admin.ajax_store_reviews');
    Route::get('/ajax/store/products/{id}', 'Admin\StoresController@getStoreProducts')->name('admin.ajax_products');
    Route::get('/ajax/users', 'Admin\UsersController@getUsers')->name('admin.ajax_users');
    Route::get('/ajax/user/transactions/{id}', 'Admin\UsersController@getUserOfflineTransactions')->name('admin.ajax_user_offline_tr');
    Route::get('/ajax/user/onlinetransactions/{id}', 'Admin\UsersController@getUserOnlineTransactions')->name('admin.ajax_user_online_tr');
    Route::get('/ajax/user/searchqueries/{id}', 'Admin\UsersController@getSearchQueries')->name('admin.ajax_user_search_q');
    Route::get('/ajax/user/storevisits/{id}', 'Admin\UsersController@getStoreVisits')->name('admin.ajax_user_store_visits');
    Route::get('/ajax/transactions', 'Admin\TransactionsController@getAllTransactions')->name('admin.ajax_transactions');
    Route::get('/ajax/transactions/tradedoubler','Admin\TdTransactionsController@tdTransactionsData')->name('admin.ajax_td_transactions'); //HERE
    Route::get('ajax/transactions/all/online', 'Admin\TransactionsController@getOnlineTransactions')->name('admin.ajax_all_online_tr');
    Route::get('ajax/transactions/all/offline', 'Admin\TransactionsController@getOfflineTransactions')->name('admin.ajax_all_offline_tr');
    Route::get('ajax/transactions/all/cash', 'Admin\TransactionsController@getCashTransactions')->name('admin.ajax_all_cash_tr');
    Route::get('/ajax/onlinetransactions/{id}', 'Admin\StoresController@getStoreOnlineTransactions')->name('admin.ajax_store_online_tr');
    Route::get('/ajax/offlinetransactions/{id}', 'Admin\StoresController@getStoreOfflineTransactions')->name('admin.ajax_store_offline_tr');
    Route::get('/ajax/cashtransactions/{id}','Admin\StoresController@getStoreCashTransactions')->name('admin.ajax_store_cash_tr');
    Route::get('/ajax/today/onlinetransactions', 'Admin\TransactionsController@todayOnlineTransactions')->name('admin.ajax_today_online_tr');
    Route::get('/ajax/today/offlinetransactions', 'Admin\TransactionsController@todayOfflineTransactions')->name('admin.ajax_today_offline_tr');
    Route::get('/ajax/products', 'Admin\ProductsController@getProducts')->name('admin.ajax_products');
    Route::get('/ajax/invoices', 'Admin\InvoiceController@getInvoices')->name('admin.ajax_get_invoices');
    Route::get('/ajax/cash/invoices','Admin\CashInvoiceController@getCashInvoices')->name('admin.ajax_cash_invoices');
    Route::get('/ajax/product_categories', 'Admin\ProductCategoryController@getProductCategories')->name('admin.ajax_product_categories');
    Route::get('/ajax/store_categories', 'Admin\StoreCategoryController@getStoreCategories')->name('admin.ajax_store_categories');
    Route::get('/ajax/orders', 'Admin\OrdersController@getOrders')->name('admin.ajax_orders');
    Route::get('/ajax/order_products/{id}', 'Admin\OrdersController@getOrderProducts')->name('admin.ajax_order_products');
    Route::get('/ajax/registered_newsletter', 'Admin\NewsletterController@getUsersSubscribed')->name('admin.ajax_registered_newsletter');
    Route::get('/ajax/external_newsletter', 'Admin\NewsletterController@getExternalSubscriptions')->name('admin.ajax_external_newsletter');
    Route::get('/ajax/app_banners', 'Admin\AppBannersController@getAppBanenrs')->name('admin.ajax_app_banners');
    Route::get('/ajax/get_faqs', 'Admin\FaqController@getFaqs')->name('admin.ajax_get_faqs');
    Route::get('/ajax/get_admins', 'Admin\AdminController@getAdmins')->name('admin.ajax_get_admins');
    Route::get('/ajax/get_searches', 'Admin\SearchController@getSearches')->name('admin.ajax_get_searches');
    Route::get('/ajax/store_documents', 'Admin\StoreDocumentsController@getDocuments')->name('admin.ajax_store_documents');
    Route::get('/ajax/store_branches/{id}','Admin\StoresController@getStoreBranches')->name('admin.ajax_store_branches');

});

Route::get('/backend/storage/app/private/{file}', function ($file) {
    return \Illuminate\Support\Facades\Storage::download($file);
})->name('admin.open_document')->middleware('auth:admin');


/* Admin Auth Routes */

/* Admin Auth Routes */


Route::prefix('store')->group(function () {

    Route::group(['middleware' => 'store.desk.select'],function(){
        Route::get('/login', 'Auth\StoreLoginController@showLoginForm')->name('store.login');
        Route::post('/login', 'Auth\StoreLoginController@login')->name('store.login.submit');
        Route::get('/logout', 'Auth\StoreLoginController@logout')->name('store.logout');
        Route::get('/register', 'Auth\StoreRegisterController@showRegisterForm')->name('store.register');
        Route::get('/register/{referralCode}','Auth\StoreRegisterController@registerWithRefferal')->name('store.refferal_register');

        Route::post('/register', 'Auth\StoreRegisterController@register')->name('store.register.submit');
        Route::post('/password/email', 'Auth\StoreForgotPasswordController@sendResetLinkEmail')->name('store.password.email');
        Route::get('/password/reset', 'Auth\StoreForgotPasswordController@showLinkRequestForm')->name('store.password.request');
        Route::post('/password/reset', 'Auth\StoreResetPasswordController@reset')->name('store.password.effective_reset');
        Route::get('/password/reset/{token}', 'Auth\StoreResetPasswordController@showResetForm')->name('store.password.reset');
        Route::get('/verify/mail/store/{token}', 'Store\StoreVerifyController@store_email_verify')->name('store.verify.mail');

        Route::get('/connect/droppay', 'Store\StoreController@connectDropPay')->name('store.connect.dp');
        Route::get('/auth/pull', 'Store\StoreController@authorizePull')->name('store.authorize.pull');
        Route::get('/check/dp/connection','Store\StoreController@ajaxCheckConnection')->name('store.ajax_check_connection');


        Route::get('/approve/cash','Store\CashTransactionController@index')->name('store.approve_cash');
        Route::get('/approve/cash/{id}','Store\CashTransactionController@approveTransaction')->name('store.cash_transaction.confirm');
        Route::get('/decline/cash/{id}','Store\CashTransactionController@declineTransaction')->name('store.cash_transaction.decline');
        Route::get('/notification/transaction/cash','Store\CashTransactionController@getTransactionNotification')->name('store.cash.ajax');



        Route::get('/', 'Store\StoreController@index')->name('store.home'); //->middleware('store.dp.connection');
        Route::get('/settings', 'Store\StoreDetailsController@store_information')->name('store.settings');
        Route::get('/wallet', 'Store\StoreWalletController@index')->name('store.wallet');
        Route::get('/discount', 'Store\DiscountRateController@index')->name('store.discount_rate');
        Route::get('/documents', 'Store\StoreDocumentsController@index')->name('store.documents');
        Route::get('/royality', 'Store\RoyalityController@index')->name('store.royality');

        Route::get('/droppay','Store\DropPayController@index')->name('store.droppay');
        Route::get('/droppay/check/status','Store\DropPayController@checkDropPayStatusAjax')->name('store.droppay.check');

        Route::get('/bank/configuration', 'Store\BankInfoController@index')->name('store.bank_config');
        Route::get('/help', 'Store\HelpController@index')->name('store.help');
        Route::get('/qr', 'Store\QrCodeController@index')->name('store.qr');
        Route::get('/reviews', 'Store\ReviewsController@index')->name('store.reviews');
        Route::get('/address', 'Store\BranchController@index')->name('store.address');

        Route::get('/branches','Store\BranchController@index')->name('store.branches');
        Route::get('/branch/create','Store\BranchController@createBranchView')->name('store.branch.create');
        Route::get('/branch/switch/{id}','Store\BranchController@switchBranchStatus')->name('store.branch.switch');
        Route::get('/branch/edit/{id}','Store\BranchController@editBranchView')->name('store.branch.edit');
        Route::get('/branches/coordinates','Store\BranchController@getBranchesCoordinates')->name('store.branch.coordinates');
        Route::post('/branch/update','Store\BranchController@updateBranch')->name('store.branch.update');
        Route::post('/branch/create/submit','Store\BranchController@createBranch')->name('store.branch.create.submit');

        Route::get('/branch/cashdesk/{id}','Store\CashDeskController@manageCashDeskForBranch')->name('store.branch.cashdesks');
        Route::get('/branch/cashdesk/switch/{branchId}/{deskId}','Store\CashDeskController@switchDeskState')->name('store.branch.cashdesk.switch');
        Route::get('/branch/new/cashdesk/{id}','Store\CashDeskController@addDeskForm')->name('store.branch.cashdesk.create');
        Route::post('/branch/cashdesk/create/','Store\CashDeskController@addDesk')->name('store.branch.cashdesk.new.submit');
        Route::get('/branch/cashdesk/download/{id}','Store\CashDeskController@downloadDeskQR')->name('store.branch.cashdesk.download');

        Route::get('/notifications', 'Store\StoreController@offline_notification')->name('store.notifications');
        Route::get('/manage/products', 'Store\ProductsController@manageProducts')->name('store.products');
        Route::get('/manage/products/edit/{id}', 'Store\ProductsController@edit_product')->name('store.product.edit');
        Route::get('/manage/products/edit/multimedia/{id}', 'Store\ProductsController@editProductMultimedia')->name('store.edit_product_multimedia');
        Route::get('/product/multimedia/delete/{multimedia_id}', 'Store\ProductUpdateController@deleteProductImage')->name('store.product.delete_img');
        Route::get('/product/disable/{id}', 'Store\ProductsController@disable_priduct')->name('store.product.disable');
        Route::get('/product/enable/{id}', 'Store\ProductsController@enableProduct')->name('store.product_enable');
        Route::get('/new/product', 'Store\ProductsController@newProduct')->name('store.new_product');
        Route::get('/orders', 'Store\OrdersController@index')->name('store.orders');
        Route::get('/orders/details/{order_id}', 'Store\OrdersController@order_details')->name('store.order_details');
        Route::get('/order/manage/{order_id}', 'Store\OrdersController@manage_order')->name('store.order.manage');

        Route::get('/invoices', 'Store\InvoiceController@index')->name('store.invoices');
        Route::get('/invoice/download/{invoice_id}', 'Store\InvoiceController@downloadInvoice')->name('store.invoice.download');
        Route::get('/cash/invoices','Store\CashInvoiceController@index')->name('store.cash_invoices');
        Route::get('/cash/invoice/download/{id}','Store\CashInvoiceController@downloadInvoice')->name('store.cash_invoice.download');


        Route::post('/wallet/filter','Store\StoreWalletController@walletByDate')->name('store.wallet.date');
        Route::post('/add/product', 'Store\ProductsController@createProduct')->name('store.add_product');
        Route::post('/edit/product', 'Store\ProductUpdateController@edit_product')->name('store.update_product');
        Route::post('/edit/product/image/front', 'Store\ProductUpdateController@editWebThumb')->name('store.edit_thumb_img');
        Route::post('/edit/product/images/new', 'Store\ProductUpdateController@upload_other_images')->name('store.upload_product_img');
        Route::post('/discount/edit', 'Store\DiscountRateController@update_discount_rate')->name('store.edit.discount');
        Route::post('/qr/generate', 'Store\QrCodeController@createQRcode')->name('store.qr.generate');
        Route::post('/order/complete', 'Store\OrdersController@complete_order')->name('order.process.submit');
        Route::post('/settings/update', 'Store\StoreDetailsController@store_information_update')->name('store.info.update');
        Route::post('/address/update', 'Store\StoreDetailsController@store_address_update')->name('store.address.update');
        Route::post('/bank/configuration/update', 'Store\BankInfoController@updateBankInfos')->name('store.banking.submit');
        Route::post('/help/request', 'Store\HelpController@helpRequest')->name('store.help_request.submit');
        Route::post('/documents/upload', 'Store\StoreDocumentsController@upload_documents')->name('store.documents.submit');
    });

    Route::get('/branches/select/','Store\CashDeskController@selectBranchAndDesk')->name('store.branch.select');
    Route::get('/branches/desks/{branchId}','Store\CashDeskController@getDesksAjax')->name('store.branch.desks.ajax');
    Route::post('/branches/select/submit/','Store\CashDeskController@selectBranchAndDesk')->name('store.branch.submit');

});

