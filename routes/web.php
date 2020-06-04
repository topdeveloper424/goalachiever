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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/sign-up/member', function () {
    return view('auth.member');
});
Route::get('/sign-up/schoolparticipant', function () {
    return view('auth.school');
});
Route::get('/sign-up/sponsor', function () {
    return view('auth.sponsor');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/check-cron','Controller@checkCron')->name('check_cron');

Route::get('/get-cities','Controller@getCities')->name('get_cities');

//User management -------------------------------------------------------------------
Route::get('/users', 'AdminController@usersPage')->name('users_page');
Route::get('/user', 'AdminController@getUser')->name('get_user');
Route::post('/user', 'AdminController@saveUser')->name('save_user');
Route::post('/reset-pass', 'AdminController@resetPass')->name('reset_pass');
Route::get('/user-logo/{id}', 'AdminController@logoPage')->name('logo_page');
Route::post('logo/upload','AdminController@logoStore')->name('logo_upload');
Route::post('logo/delete','AdminController@logoDelete')->name('logo_delete');

Route::post('/remove-user', 'AdminController@removeUser')->name('remove_user');
Route::get('/profile', 'AdminController@profilePage')->name('profile_page');
Route::post('/reset-user', 'AdminController@resetUser')->name('reset_user');
Route::post('/invite-user', 'AdminController@inviteUser')->name('invite_user');
Route::get('/sign-up/{user_id}', 'Controller@inviteRegister')->name('invite_register');



// Contacts -------------------------------------------------------------------------
Route::get('/vendors', 'ContactController@vendorPage')->name('vendor_page');
Route::get('/sponsors', 'ContactController@sponsorPage')->name('sponsor_page');
Route::get('/participants', 'ContactController@participantPage')->name('participant_page');
Route::post('/save-contact', 'ContactController@saveContact')->name('save_contact');
Route::get('/get-contact', 'ContactController@getContact')->name('get_contact');
Route::post('/remove-contact', 'ContactController@removeContact')->name('remove_contact');


// Goal Settings -------------------------------------------------------------------------
Route::get('/financial-list', 'GoalSettingController@financialListPage')->name('financial_list_page');
Route::get('/educational-list', 'GoalSettingController@educationalListPage')->name('educational_list_page');
Route::get('/career-list', 'GoalSettingController@careerListPage')->name('career_list_page');
Route::get('/personal-list', 'GoalSettingController@personalListPage')->name('personal_list_page');
Route::get('/weight-list', 'GoalSettingController@weightListPage')->name('weight_list_page');
Route::get('/vacation-list', 'GoalSettingController@vacationListPage')->name('vacation_list_page');
Route::get('/insurance-list', 'GoalSettingController@insuranceListPage')->name('insurance_list_page');
Route::get('/retirement-list', 'GoalSettingController@retirementListPage')->name('retirement_list_page');
Route::get('/purchase-list', 'GoalSettingController@purchaseListPage')->name('purchase_list_page');
Route::get('/listing-list', 'GoalSettingController@listingListPage')->name('listing_list_page');
Route::get('/mortgage-list', 'GoalSettingController@mortgageListPage')->name('mortgage_list_page');
Route::get('/booster-list', 'GoalSettingController@boosterListPage')->name('booster_list_page');
Route::get('/report-list', 'GoalSettingController@reportListPage')->name('report_list_page');

Route::get('/financial', 'GoalSettingController@financialPage')->name('financial_page');
Route::post('/update-financial', 'GoalSettingController@updateFinancial')->name('update_financial');
Route::post('/remove-financial', 'GoalSettingController@removeFinancial')->name('remove_financial');


Route::get('/educational', 'GoalSettingController@educationalPage')->name('educational_page');
Route::post('/update-educational', 'GoalSettingController@updateEducational')->name('update_educational');
Route::post('/remove-educational', 'GoalSettingController@removeEducational')->name('remove_educational');

Route::get('/career', 'GoalSettingController@careerPage')->name('career_page');
Route::post('/update-career', 'GoalSettingController@updateCareer')->name('update_career');
Route::post('/remove-career', 'GoalSettingController@removeCareer')->name('remove_career');

Route::get('/personal', 'GoalSettingController@personalPage')->name('personal_page');
Route::post('/update-personal', 'GoalSettingController@updatePersonal')->name('update_personal');
Route::post('/remove-personal', 'GoalSettingController@removePersonal')->name('remove_personal');

Route::get('/weight-loss', 'GoalSettingController@weightLossPage')->name('weight_loss_page');
Route::post('/update-weight-loss', 'GoalSettingController@updateWeightLoss')->name('update_weight_loss');
Route::post('/remove-weight-loss', 'GoalSettingController@removeWeightLoss')->name('remove_weight_loss');

Route::get('/vacation', 'GoalSettingController@vacationPage')->name('vacation_page');
Route::post('/update-vacation', 'GoalSettingController@updateVacation')->name('update_vacation');
Route::post('/remove-vacation', 'GoalSettingController@removeVacation')->name('remove_vacation');

Route::get('/insurance', 'GoalSettingController@insurancePage')->name('insurance_page');
Route::post('/update-insurance', 'GoalSettingController@updateInsurance')->name('update_insurance');
Route::post('/remove-insurance', 'GoalSettingController@removeInsurance')->name('remove_insurance');

Route::get('/retirement', 'GoalSettingController@retirementPage')->name('retirement_page');
Route::post('/update-retirement', 'GoalSettingController@updateRetirement')->name('update_retirement');
Route::post('/remove-retirement', 'GoalSettingController@removeRetirement')->name('remove_retirement');

Route::get('/purchase', 'GoalSettingController@purchasePage')->name('purchase_page');
Route::post('/update-purchase', 'GoalSettingController@updatePurchase')->name('update_purchase');
Route::post('/remove-purchase', 'GoalSettingController@removePurchase')->name('remove_purchase');

Route::get('/listing', 'GoalSettingController@listingPage')->name('listing_page');
Route::post('/update-listing', 'GoalSettingController@updateListing')->name('update_listing');
Route::post('/remove-listing', 'GoalSettingController@removeListing')->name('remove_listing');

Route::get('/mortgage', 'GoalSettingController@mortgagePage')->name('mortgage_page');
Route::post('/update-mortgage', 'GoalSettingController@updateMortgage')->name('update_mortgage');
Route::post('/remove-mortgage', 'GoalSettingController@removeMortgage')->name('remove_mortgage');

Route::get('/goal-report', 'GoalSettingController@goalReportPage')->name('goal_report_page');
Route::get('/report/pdf','GoalSettingController@exportReportPDF')->name('export_report_pdf');
Route::get('/report/csv','GoalSettingController@exportReportCSV')->name('export_report_csv');

Route::get('/goal-booster', 'GoalSettingController@goalBoosterPage')->name('goal_booster_page');
Route::post('/update-booster', 'GoalSettingController@updateBooster')->name('update_booster');
Route::post('/remove-booster', 'GoalSettingController@removeBooster')->name('remove_booster');

Route::post('/add-contribution', 'GoalSettingController@addContribution')->name('add_contribution');
Route::post('/update-contribution', 'GoalSettingController@updateContribution')->name('update_contribution');
Route::post('/remove-contribution', 'GoalSettingController@removeContribution')->name('remove_contribution');

Route::get('/get-cron', 'GoalSettingController@getCron')->name('get_cron');
Route::post('/update-cron', 'GoalSettingController@updateCron')->name('update_cron');

Route::get('/goal-type-page', 'GoalSettingController@goalTypePage')->name('goal_type_page');
Route::get('/goal-type', 'GoalSettingController@getGoalType')->name('get_goal_type');
Route::post('/goal-type', 'GoalSettingController@prodGoalType')->name('prod_goal_type');
Route::delete('/goal-type', 'GoalSettingController@removeGoalType')->name('remove_goal_type');

Route::post('/cash-alert', 'GoalSettingController@cashAlert')->name('cash_alert');
Route::post('/credit-alert', 'GoalSettingController@creditAlert')->name('credit_alert');

Route::get('/insurance-lead-list', 'LeadController@insuranceLeadListPage')->name('insurance_lead_list_page');
Route::get('/get-insurance-lead', 'LeadController@getInsuranceLead')->name('get_insurance_lead');
Route::get('/insurance-lead', 'LeadController@insuranceLeadPage')->name('insurance_lead_page');
Route::post('/insurance-lead', 'LeadController@addInsuranceLead')->name('add_insurance_lead');


Route::get('/retirement-lead-list', 'LeadController@retirementLeadListPage')->name('retirement_lead_list_page');
Route::get('/get-retirement-lead', 'LeadController@getRetirementLead')->name('get_retirement_lead');
Route::get('/retirement-lead', 'LeadController@retirementLeadPage')->name('retirement_lead_page');
Route::post('/retirement-lead', 'LeadController@addRetirementLead')->name('add_retirement_lead');

Route::get('/get-lead-detail', 'LeadController@getLeadDetail')->name('get_lead_detail');
Route::delete('/lead', 'LeadController@removeLead')->name('remove_lead');
Route::get('/lead-csv', 'LeadController@exportCSV')->name('export_csv');


//------------------------------ goal achiever report ------------------------------------------

Route::get('/achiever-report', 'AdminController@achieverReportPage')->name('achiever_report_page');
Route::get('/achiever-reportCSV', 'AdminController@achieverReportCSV')->name('achiever_report_csv');
Route::get('/achiever-reportPDF', 'AdminController@achieverReportPDF')->name('achiever_report_pdf');


//------------------------------------------------ apparel ----------------------------------------------------------

Route::get('/apparel-items', 'ApparelController@apparelItemPage')->name('apparel_item_page');
Route::get('/apparel-item', 'ApparelController@getApparelItem')->name('get_apparel_item');
Route::post('/apparel-item', 'ApparelController@saveApparelItem')->name('save_apparel_item');
Route::post('/remove-apparel-item', 'ApparelController@removeApparelItem')->name('remove_apparel_item');


Route::get('/apparel-orders-list', 'ApparelController@ordersListPage')->name('orders_list_page');
Route::get('/apparel-proceeds-list/{id}', 'ApparelController@apparelProceedListPage')->name('apparel_proceed_list_page');
Route::get('/apparel-proceed/{id}', 'ApparelController@apparelProceedPage')->name('apparel_proceed_page');

Route::get('/main-order/{id}', 'ApparelController@mainOrderPage')->name('main_order_page');
Route::post('/main-order', 'ApparelController@saveMainOrder')->name('save_main_order');
Route::get('/print-order/{id}', 'ApparelController@printMainOrder')->name('print_main_order');

Route::get('/apparel-commission', 'ApparelController@commissionPage')->name('apparel_comm_page');
Route::get('/apparel-UR', 'ApparelController@urCreditsPage')->name('apparel_ur_page');

//------------------------------------------------ Goal Booster BBB----------------------------------------------------

Route::get('/bbb-items', 'BbbController@bbbItemPage')->name('bbb_item_page');
Route::get('/bbb-item', 'BbbController@getBbbItem')->name('get_bbb_item');
Route::post('/bbb-item', 'BbbController@saveBbbItem')->name('save_bbb_item');
Route::post('/remove-bbb-item', 'BbbController@removeBbbItem')->name('remove_bbb_item');


Route::get('/bbb-orders-list', 'BbbController@ordersListPage')->name('bbb_orders_list_page');
Route::get('/bbb-proceeds-list/{id}', 'BbbController@bbbProceedListPage')->name('bbb_proceed_list_page');
Route::get('/bbb-proceed/{id}', 'BbbController@bbbProceedPage')->name('bbb_proceed_page');

Route::get('/bbb-main-order/{id}', 'BbbController@mainOrderPage')->name('bbb_main_order_page');
Route::post('/bbb-main-order', 'BbbController@saveMainOrder')->name('bbb_save_main_order');
Route::get('/bbb-print-order/{id}', 'BbbController@printMainOrder')->name('bbb_print_main_order');

Route::get('/bbb-commission', 'BbbController@commissionPage')->name('bbb_comm_page');
Route::get('/bbb-UR', 'BbbController@urCreditsPage')->name('bbb_ur_page');

//------------------------------------------------ Goal Booster purchase plan----------------------------------------------------

Route::get('/goal-booster-items', 'GoalBoosterController@goalBoosterItemPage')->name('goalBooster_item_page');
Route::get('/goal-booster-item', 'GoalBoosterController@getGoalBoosterItem')->name('get_goalBooster_item');
Route::post('/goal-booster-item', 'GoalBoosterController@saveGoalBoosterItem')->name('save_goalBooster_item');
Route::post('/remove-goal-booster-item', 'GoalBoosterController@removeGoalBoosterItem')->name('remove_goalBooster_item');


Route::get('/goal-booster-orders-list', 'GoalBoosterController@ordersListPage')->name('gb_orders_list_page');
Route::get('/goal-booster-proceeds-list/{id}', 'GoalBoosterController@goalBoosterProceedListPage')->name('goalBooster_proceed_list_page');
Route::get('/goal-booster-proceed/{id}', 'GoalBoosterController@goalBoosterProceedPage')->name('goalBooster_proceed_page');

Route::get('/gb-main-order/{id}', 'GoalBoosterController@mainOrderPage')->name('gb_main_order_page');
Route::post('/gb-main-order', 'GoalBoosterController@saveMainOrder')->name('gb_save_main_order');
Route::get('/gb-print-order/{id}', 'GoalBoosterController@printMainOrder')->name('gb_print_main_order');

Route::get('/goal-booster-commission', 'GoalBoosterController@commissionPage')->name('goalBooster_comm_page');
Route::get('/goal-booster-UR', 'GoalBoosterController@urCreditsPage')->name('goalBooster_ur_page');


//------------------------------------------------ Sponsor ----------------------------------------------------------

Route::get('/sponsor-items', 'SponsorController@sponsorItemPage')->name('sponsor_item_page');
Route::get('/sponsor-item', 'SponsorController@getSponsorItem')->name('get_sponsor_item');
Route::post('/sponsor-item', 'SponsorController@saveSponsorItem')->name('save_sponsor_item');
Route::post('/remove-sponsor-item', 'SponsorController@removeSponsorItem')->name('remove_sponsor_item');


Route::get('/sponsor-orders-list', 'SponsorController@ordersListPage')->name('sponsor_orders_list_page');
Route::get('/sponsor-proceeds-list/{id}', 'SponsorController@sponsorProceedListPage')->name('sponsor_proceed_list_page');
Route::get('/sponsor-proceed/{id}', 'SponsorController@sponsorProceedPage')->name('sponsor_proceed_page');

Route::get('/sponsor-main-order/{id}', 'SponsorController@mainOrderPage')->name('sponsor_main_order_page');
Route::post('/sponsor-main-order', 'SponsorController@saveMainOrder')->name('sponsor_save_main_order');
Route::get('/sponsor-print-order/{id}', 'SponsorController@printMainOrder')->name('sponsor_print_main_order');

Route::get('/sponsor-commission', 'SponsorController@commissionPage')->name('sponsor_comm_page');
Route::get('/sponsor-UR', 'SponsorController@urCreditsPage')->name('sponsor_ur_page');


//------------------------------------------------ Subscriptions ----------------------------------------------------------

Route::get('/subscription-items', 'SubscriptionController@subscriptionItemPage')->name('subscription_item_page');
Route::get('/subscription-item', 'SubscriptionController@getSubscriptionItem')->name('get_subscription_item');
Route::post('/subscription-item', 'SubscriptionController@saveSubscriptionItem')->name('save_subscription_item');
Route::post('/remove-subscription-item', 'SubscriptionController@removeSubscriptionItem')->name('remove_subscription_item');


Route::get('/subscription-orders-list', 'SubscriptionController@ordersListPage')->name('subscription_orders_list_page');
Route::get('/subscription-proceeds-list/{id}', 'SubscriptionController@subscriptionProceedListPage')->name('subscription_proceed_list_page');
Route::get('/subscription-proceed/{id}', 'SubscriptionController@subscriptionProceedPage')->name('subscription_proceed_page');

Route::get('/subscription-main-order/{id}', 'SubscriptionController@mainOrderPage')->name('subscription_main_order_page');
Route::post('/subscription-main-order', 'SubscriptionController@saveMainOrder')->name('subscription_save_main_order');
Route::get('/subscription-print-order/{id}', 'SubscriptionController@printMainOrder')->name('subscription_print_main_order');

Route::get('/subscription-commission', 'SubscriptionController@commissionPage')->name('subscription_comm_page');
Route::get('/subscription-UR', 'SubscriptionController@urCreditsPage')->name('subscription_ur_page');

// -----------------------------------------------forms/videos, podcast -------------------------------------------
Route::get('/form-video', 'FileController@formVideoPage')->name('form_video_page');
Route::post('/upload-form-video', 'FileController@uploadFormVideo')->name('upload_form_video');
Route::post('/form-video', 'FileController@getFormVideo')->name('get_form_video');
Route::get('/download-form-video', 'FileController@downloadFormVideo')->name('download_form_video');
Route::post('/remove-form-video', 'FileController@removeFormVideo')->name('remove_form_video');

Route::get('/podcast', 'FileController@podcastPage')->name('podcast_page');






// Cache -----------------------------------------------------------------------------------
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});