<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\authController;
use App\Http\Controllers\InflowController;
use App\Http\Controllers\OutflowController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\resetPasswordController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\stockController;
use App\Http\Controllers\WarehousesController;
use App\Mail\restorePasswordMail;
use App\Models\inflow;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

Route::get('/registration', [RegistrationController::class, 'registration']);
Route::post('/registration/store', [RegistrationController::class, 'store']);
Route::get('/', [authController::class, 'signin'])->name('login');
Route::post('/', [authController::class, 'attempt_signin']);
Route::get('/test', [settingsController::class, 'test']);
Route::get('/clear-cache', function() {
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('optimize');
    Artisan::call('cache:clear');
    return redirect('/dashboard')->with('msg', 'Project Optimized');
});

Route::get("/password/forgot/{userName}",[resetPasswordController::class, 'verify']);
Route::get("/password/restore/{email}/{token}",[resetPasswordController::class, 'restore']);
Route::post("/password/restore",[resetPasswordController::class, 'store']);

Route::middleware('auth')->group(function (){
    Route::get('/dashboard', [authController::class, 'dashboard']);
    Route::get('/logout', [authController::class, 'logout']);
    Route::get('/settings', [settingsController::class, 'settings']);
    Route::get('/activities', [settingsController::class, 'activity']);
    Route::get('/clearActivityLogSA', [settingsController::class, 'clear_log']);
    Route::get('/deleteActivityLogSA/{id}', [settingsController::class, 'delete_log']);
    Route::post('settings/save/basics', [settingsController::class, 'saveBasics']);
    Route::post('settings/save/userName', [settingsController::class, 'saveUserName']);
    Route::post('settings/save/password', [settingsController::class, 'savePassword']);
    Route::post('settings/setLanguage', [settingsController::class, 'changeLanguage']);

    Route::get('/products', [ProductsController::class, 'products']);
    Route::get('/product/add', [ProductsController::class, 'productAdd']);
    Route::get('/product/trashed', [ProductsController::class, 'productsTrashed']);
    Route::get('/product/delete/{id}', [ProductsController::class, 'productDelete']);
    Route::get('/product/restore/{id}', [ProductsController::class, 'productRestore']);
    Route::get('/product/edit/{id}', [ProductsController::class, 'productEdit']);
    Route::post('/product/add', [ProductsController::class, 'productSave']);
    Route::post('/product/update/{id}', [ProductsController::class, 'productUpdate']);
    Route::post('product/updateImage/{id}', [ProductsController::class, 'productImageUpdate']);

    Route::get('/calculateSQF/{unit}/{width}/{length}', function($unit, $width, $length) {
        return calculateSQF($unit, $width, $length);
    });


    Route::get('/warehouse', [WarehousesController::class, 'warehouse']);
    Route::get('/warehouse/add', [WarehousesController::class, 'warehouseAdd']);
    Route::post('/warehouse/add', [WarehousesController::class, 'warehouseSave']);
    Route::get('/warehouse/edit/{id}', [WarehousesController::class, 'warehouseEdit']);
    Route::post('/warehouse/update/{id}', [WarehousesController::class, 'warehouseUpdate']);

    Route::get('/accounts', [AccountsController::class, 'accounts']);
    Route::get('/account/add', [AccountsController::class, 'addAccount']);
    Route::post('/account/add', [AccountsController::class, 'saveAccount']);
    Route::get('/account/edit/{id}', [AccountsController::class, 'editAccount']);
    Route::post('/account/update/{id}', [AccountsController::class, 'updateAccount']);
    Route::get('/account/statement/{id}', [AccountsController::class, 'statement']);
    Route::get('/account/details/{id}/{from}/{to}', [AccountsController::class, 'details']);
    Route::get('/statement/pdf/{id}/{from}/{to}',[AccountsController::class, 'printStatement']);

    Route::get('/accounts/deposit', [AccountsController::class, 'deposit']);
    Route::post('/accounts/deposit', [AccountsController::class, 'saveDeposit']);
    Route::get('/deposit/details/{from}/{to}', [AccountsController::class, 'depositDetails']);
    Route::get('/deposit/delete/{ref}', [AccountsController::class, 'depositDelete']);

    Route::get('/accounts/withdraw', [AccountsController::class, 'withdraw']);
    Route::post('/accounts/withdraw', [AccountsController::class, 'saveWithdraw']);
    Route::get('/withdraw/details/{from}/{to}', [AccountsController::class, 'withdrawDetails']);
    Route::get('/withdraw/delete/{ref}', [AccountsController::class, 'withdrawDelete']);

    Route::get('/accounts/transfer', [AccountsController::class, 'transfer']);
    Route::post('/accounts/transfer', [AccountsController::class, 'saveTransfer']);
    Route::get('/account/change/{id}', [AccountsController::class, 'ChangeStatus']);
    Route::get('/transfer/details/{from}/{to}', [AccountsController::class, 'transferDetails']);
    Route::get('/transfer/delete/{ref}', [AccountsController::class, 'transferDelete']);

    Route::get('/accounts/expense', [AccountsController::class, 'expense']);
    Route::post('/accounts/expense', [AccountsController::class, 'saveExpense']);
    Route::get('/expense/details/{from}/{to}', [AccountsController::class, 'expenseDetails']);
    Route::get('/expense/delete/{ref}', [AccountsController::class, 'expenseDelete']);

    Route::get('/receiving',[InflowController::class, 'receiving']);
    Route::post('/receiving',[InflowController::class, 'CreateReceiving']);
    Route::get('/inflow/edit/{id}',[InflowController::class, 'editReceiving']);
    Route::post('/inflow/edit/{id}',[InflowController::class, 'updateReceiving']);
    Route::get('/receiving/add_items/{id}',[InflowController::class, 'addItemsReceiving']);
    Route::get('/inflow/history/',[InflowController::class, 'history']);
    Route::get('/inflow/add_pro',[InflowController::class, 'addPro']);
    Route::get('/inflow/get_items/{id}',[InflowController::class, 'get_items']);
    Route::get('/get_unit/{id}',[InflowController::class, 'get_unit']);
    Route::get('/inflow/get_price/{id}',[InflowController::class, 'get_price']);
    Route::get('/inflow/update/qty/{id}/{qty}',[InflowController::class, 'updateQty']);
    Route::get('/inflow/update/price/{id}/{price}',[InflowController::class, 'updatePrice']);
    Route::get('/inflow/delete/item/{id}',[InflowController::class, 'deleteItem']);
    Route::get('/inflow/pdf/{id}',[InflowController::class, 'print']);


    Route::get('/invoice',[OutflowController::class, 'invoice']);
    Route::post('/invoice',[OutflowController::class, 'CreateInvoice']);
    Route::get('/invoice/add_items/{id}',[OutflowController::class, 'addItemsInvoice']);
    Route::get('/invoice/history/',[OutflowController::class, 'history']);
    Route::post('/outflow/edit/{id}',[OutflowController::class, 'updateInvoice']);
    Route::get('/outflow/add_pro',[OutflowController::class, 'addPro']);
    Route::get('/outflow/get_items/{id}',[OutflowController::class, 'get_items']);
    Route::get('/outflow/update/qty/{id}/{qty}',[OutflowController::class, 'updateQty']);
    Route::get('/outflow/update/price/{id}/{price}',[OutflowController::class, 'updatePrice']);
    Route::get('/outflow/delete/item/{id}',[OutflowController::class, 'deleteItem']);
    Route::get('/outflow/pdf/{id}',[OutflowController::class, 'print']);
    Route::get('/get_price/{id}',[OutflowController::class, 'get_price']);
    Route::get('/get_qty/{id}',[OutflowController::class, 'get_qty']);
    Route::get('/get_warehouse/{id}',[OutflowController::class, 'get_warehouse']);

    Route::get('/stock/{id}',[stockController::class, 'stock']);
    Route::get('/stock/get_items/{id}/{from}/{to}',[stockController::class, 'items']);
    Route::get('/stock/get_items/{id}/{from}/{to}',[stockController::class, 'items']);
    Route::get('/stock/pdf/{id}/{from}/{to}',[stockController::class, 'print']);

    Route::get('/users', [authController::class, 'users']);
    Route::get('/user/add', [authController::class, 'addUser']);
    Route::post('/user/create', [authController::class, 'create']);
    Route::get('/user/edit/{id}', [authController::class, 'edit']);
    Route::post('/user/update/{id}', [authController::class, 'update']);
    Route::post('/user/assignRoles/{id}', [authController::class, 'assignRoles']);
    Route::post('/user/assignPermissions/{id}', [authController::class, 'assignPermissions']);

    Route::get('/roles', [rolesController::class, 'index']);
    Route::get('/role/delete/{id}', [rolesController::class, 'delete']);
    Route::get('/role/edit/{id}', [rolesController::class, 'edit']);
    Route::post('/role/update/{id}', [rolesController::class, 'update']);
    Route::post('/role/assignPermissions/{id}', [rolesController::class, 'assignPermissions']);
    Route::get('/reset', function() {
        Artisan::call('migrate:fresh --seed');

        return redirect('/dashboard')->with('msg', 'Reset Successful');
    });

});
