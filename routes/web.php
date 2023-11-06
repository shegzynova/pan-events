<?php

use App\Http\Controllers\AbstractController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventUserController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('test', function () {
    // Call the custom Artisan command
    Artisan::call('update:institution');

    // Get the output of the command
    $output = Artisan::output();

    // You can use the output for any further processing or display
    return view('welcome', ['output' => $output]);
});

Route::get('/', function () {
    return Redirect::to('login');
});

Route::get('update-notification/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'updateNot'])->name('update-notification');
Route::post('send-sms', [\App\Http\Controllers\Admin\UserController::class, 'sendSms'])->name('send-sms');
Route::post('send-email', [\App\Http\Controllers\Admin\UserController::class, 'sendEmail'])->name('send-email');

//Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['role:admin', 'auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Events
    Route::get('/events', [AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [AdminEventController::class, 'create'])->name('events.create');
    Route::post('/events', [AdminEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [AdminEventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::put('/events/{event}/publish', [AdminEventController::class, 'publish'])->name('events.publish');

    Route::get('generate-reference', [TransactionController::class, 'genTranxRef'])->name('generate.reference');
    Route::post('load-transactions', [TransactionController::class, 'loadUserTransactions'])->name('get_user_transactions');

    //Settings
    Route::get('generate-reference', [TransactionController::class, 'genTranxRef'])->name('generate.reference');
    Route::get('clear-cache', function () {
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        echo 'Artisan Cleared';
        return redirect()->back()->with('success', 'Cache cleared');
    })->name('clear.cache');

    Route::get('clear-cache', function () {
        \Illuminate\Support\Facades\Artisan::call('config:cache');
        echo 'Artisan Config Cached';
        return redirect()->back()->with('success', 'Config cached');
    })->name('config.cache');

    Route::any('settings', [SettingController::class, 'index'])->name('settings.index');

    Route::get('messages', [\App\Http\Controllers\Admin\MessagesController::class, 'index'])->name('messages');

    Route::resource('hotels', App\Http\Controllers\Admin\HotelController::class)
        ->names([
            'index' => 'hotels.index',
            'store' => 'hotels.store',
            'show' => 'hotels.show',
            'update' => 'hotels.update',
            'destroy' => 'hotels.destroy',
            'create' => 'hotels.create',
            'edit' => 'hotels.edit',
        ]);

    Route::resource('transactions', App\Http\Controllers\Admin\TransactionController::class)
        ->names([
            'index' => 'transactions.index',
            'store' => 'transactions.store',
            'show' => 'transactions.show',
            'update' => 'transactions.update',
            'destroy' => 'transactions.destroy',
            'create' => 'transactions.create',
            'edit' => 'transactions.edit',
        ]);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)
        ->names([
            'index' => 'users.index',
            'store' => 'users.store',
            'show' => 'users.show',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
            'create' => 'users.create',
            'edit' => 'users.edit',
        ]);
    Route::resource('event-users', App\Http\Controllers\Admin\EventUserController::class)
        ->names([
            'index' => 'eventUsers.index',
            'store' => 'eventUsers.store',
            'show' => 'eventUsers.show',
            'update' => 'eventUsers.update',
            'destroy' => 'eventUsers.destroy',
            'create' => 'eventUsers.create',
            'edit' => 'eventUsers.edit',
        ]);
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationsController::class)
        ->names([
            'index' => 'reservations.index',
            'store' => 'reservations.store',
            'show' => 'reservations.show',
            'update' => 'reservations.update',
            'destroy' => 'reservations.destroy',
            'create' => 'reservations.create',
            'edit' => 'reservations.edit',
        ]);
    Route::resource('exhibition-types', App\Http\Controllers\Admin\ExhibitionTypeController::class)
        ->names([
            'index' => 'exhibitionTypes.index',
            'store' => 'exhibitionTypes.store',
            'show' => 'exhibitionTypes.show',
            'update' => 'exhibitionTypes.update',
            'destroy' => 'exhibitionTypes.destroy',
            'create' => 'exhibitionTypes.create',
            'edit' => 'exhibitionTypes.edit',
        ]);
    Route::resource('exhibitions', App\Http\Controllers\Admin\ExhibitionController::class)
        ->names([
            'index' => 'exhibitions.index',
            'store' => 'exhibitions.store',
            'show' => 'exhibitions.show',
            'update' => 'exhibitions.update',
            'destroy' => 'exhibitions.destroy',
            'create' => 'exhibitions.create',
            'edit' => 'exhibitions.edit',
        ]);
    Route::resource('exhibition-purchases', App\Http\Controllers\Admin\ExhibitionPurchaseController::class)
        ->names([
            'index' => 'exhibitionPurchases.index',
            'store' => 'exhibitionPurchases.store',
            'show' => 'exhibitionPurchases.show',
            'update' => 'exhibitionPurchases.update',
            'destroy' => 'exhibitionPurchases.destroy',
            'create' => 'exhibitionPurchases.create',
            'edit' => 'exhibitionPurchases.edit',
        ]);

    Route::resource('notifications', App\Http\Controllers\Admin\NotificationController::class)
        ->names([
            'index' => 'notifications.index',
            'store' => 'notifications.store',
            'show' => 'notifications.show',
            'update' => 'notifications.update',
            'destroy' => 'notifications.destroy',
            'create' => 'notifications.create',
            'edit' => 'notifications.edit',
        ]);

    Route::resource('abstracts', App\Http\Controllers\Admin\AbstractController::class)
        ->names([
            'index' => 'abstracts.index',
            'store' => 'abstracts.store',
            'show' => 'abstracts.show',
            'update' => 'abstracts.update',
            'destroy' => 'abstracts.destroy',
            'create' => 'abstracts.create',
            'edit' => 'abstracts.edit',
        ]);

    Route::get('settings/roles', [App\Http\Controllers\Admin\RolesController::class, 'index'])->name('settings.roles');
    Route::get('settings/roles/create', [App\Http\Controllers\Admin\RolesController::class, 'create'])->name('settings.roles.create');
    Route::post('settings/roles/store', [App\Http\Controllers\Admin\RolesController::class, 'store'])->name('settings.roles.store');
    Route::patch('settings/roles/update/{id}', [App\Http\Controllers\Admin\RolesController::class, 'update'])->name('settings.roles.update');
    Route::delete('settings/roles/destroy', [App\Http\Controllers\Admin\RolesController::class, 'destroy'])->name('settings.roles.destroy');
    Route::get('settings/roles/edit/{id}', [App\Http\Controllers\Admin\RolesController::class, 'edit'])->name('settings.roles.edit');

    Route::get('abstracts/{abstract}/approve', [\App\Http\Controllers\Admin\AbstractController::class, 'approve'])->name('abstracts.approve');
    Route::get('abstracts/{abstract}/decline', [\App\Http\Controllers\Admin\AbstractController::class, 'decline'])->name('abstracts.decline');

    Route::get('abstracts/{abstract}/approve_full_paper', [\App\Http\Controllers\Admin\AbstractController::class, 'approve_full_paper'])->name('abstracts.approve_full_paper');
    Route::get('abstracts/{abstract}/decline_full_paper', [\App\Http\Controllers\Admin\AbstractController::class, 'decline_full_paper'])->name('abstracts.decline_full_paper');

    Route::get('abstracts/{abstract}/approve_presentation', [\App\Http\Controllers\Admin\AbstractController::class, 'approve_presentation'])->name('abstracts.approve_presentation');
    Route::get('abstracts/{abstract}/decline_presentation', [\App\Http\Controllers\Admin\AbstractController::class, 'decline_presentation'])->name('abstracts.decline_presentation');

    Route::get('send-certificate/{type}', [AdminEventController::class, 'certificate'])->name('send-certificate');

    Route::get('download-receipt/{id}', [\App\Http\Controllers\Admin\EventUserController::class, 'downloadReceipt'])->name('download-receipt');

})->name('admin');

Route::prefix('user')->name('user.')->middleware(['auth', /*'verified',*/'is_user'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events/create{event}', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    //Start Event Registration
//    Route::get('events/register/{id}/start', [EventController::class, 'stepOneGet'])->name('events.step_one_get');
//    Route::post('events/register/{id}/start', [EventController::class, 'stepOnePost'])->name('events.step_one_post');

    Route::get('events/register/{id}/details', [EventController::class, 'stepOneGet'])->name('events.step_one_get');
    Route::post('events/register/{id}/details', [EventController::class, 'stepOnePost'])->name('events.step_one_post');

    Route::get('events/register/{id}/accommodation', [EventController::class, 'stepTwo'])->name('events.step_two');
    Route::post('events/register/{id}/accommodation', [EventController::class, 'stepTwoPost'])->name('events.step_two_post');

    Route::get('events/book-hotel/{id}', [EventController::class, 'bookHotel'])->name('events.book_hotel');
    Route::post('events/book-hotel/{id}', [TransactionController::class, 'bookHotelPay'])->name('events.book_hotel_pay');

    Route::get('events/register/{id}/exhibition', [EventController::class, 'exhibitionGet'])->name('events.register.exhibition_get');
    Route::post('events/register/{id}/exhibition', [EventController::class, 'exhibitionPost'])->name('events.register.exhibition_post');

    Route::get('events/register/{id}/abstract', [EventController::class, 'abstractGet'])->name('events.register.abstract_get');
    Route::post('events/register/{id}/abstract', [EventController::class, 'abstractPost'])->name('events.register.abstract_post');

    Route::get('events/register/{id}/final', [EventController::class, 'finalGet'])->name('events.register.final_get');

    Route::post('pay', [TransactionController::class, 'initPayment'])->name('startPayment');
    Route::get('manual-pay/{id}', [TransactionController::class, 'manualPayment'])->name('startManualPayment');
    Route::post('bank-transfer', [TransactionController::class, 'bankTransfer'])->name('bankTransfer');
    Route::get('verify_payment', [TransactionController::class, 'finalizePayment'])->name('finishPayment');

    Route::get('transactions', [TransactionController::class, 'allTransaction'])->name('transactions');

    Route::get('messages', [MessagesController::class, 'index'])->name('messages');

    Route::get('abstracts', [AbstractController::class, 'index'])->name('abstracts');
    Route::get('abstracts/{id}', [AbstractController::class, 'show'])->name('abstracts.show');
    Route::post('abstracts/{id}/full_paper', [AbstractController::class, 'fullPaper'])->name('abstract.full-paper');

    Route::get('download-receipt/{id}', [EventUserController::class, 'downloadReceipt'])->name('download-receipt');

})->name('user');

Route::get('pdf/{model}', [ExportController::class, 'pdf'])->name('export-pdf');
Route::get('excel/{model}', [ExportController::class, 'excel'])->name('export-excel');
Route::post('paystack-webhook', [TransactionController::class, 'handlePaystackWebhook']);
Route::get('/paystack-callback', [TransactionController::class, 'finalizePayment']);

require __DIR__ . '/auth.php';
