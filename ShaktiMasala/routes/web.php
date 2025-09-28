<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\Usercontroller;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\AuthCheckMiddleware;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Sale;
use App\Models\SalesHistory;
use Illuminate\Support\Facades\Route;


Route::view('/', 'Dashboard')->middleware(AuthCheckMiddleware::class);

Route::post('/login', [Usercontroller::class, 'Login']);

// User Section
Route::view('/registration', 'RegistrationPage');   //Registration Page
Route::view('/login_page', 'LoginPage');   //Registration Page
Route::post('/register', [Usercontroller::class, 'UserRegistration']); //User registration

Route::group(['middleware' => AuthCheckMiddleware::class], function () {

    // Products Routes
    Route::view('/production', 'Production');
    Route::post('/add_product', [ProductController::class, 'AddProduct']); //add product
    Route::get('/products', [ProductController::class, 'GetProductDetails']);
    Route::get('/populate_product/{id}', [ProductController::class, 'PopulateProduct']);
    Route::put('/UpdateProduct', [ProductController::class, 'UpdateProduct']);
    Route::delete('/ProductDelete', [ProductController::class, 'DeleteProduct']);
    Route::get('/overview', [ProductController::class, 'ProductOverview']);

    // Sales Routes
    Route::view('/sales', 'Sales');
    Route::view('/salesmanage', 'SalesManage');
    Route::post('/add_sales', [SaleController::class, 'AddSalesData']);
    Route::get('/pendings', [CustomerController::class, 'PaymentDetails']);
    Route::put('/update_customer_payment', [SaleController::class, 'UpdateCustomers']);
    Route::get('/unpaid_cus', [SaleController::class, 'PartiallyPaidPaymentCustomers']);
    Route::get('/todays_sales', [SaleController::class, 'TodaySalesData']);

    // Sales Management Routes
    Route::get('/partial_emi/{id}', [SaleController::class, 'PopulatingPartialPaidData']);
    Route::put('/update_unpaid', [SaleController::class, 'UpdateUnpaidCustomers']);

    // Sales History Routes
    Route::get('/history', [SalesHistoryController::class, 'GetSalesHistory']);

    // Billings Routes
    Route::get('/bill/{id}', function ($id) {
        // 
        $customer = SalesHistory::find($id);
        $sales = Sale::where('customer_id', $id)->get();
        return view('Bills', ['customer' => $customer, 'sales' => $sales]);
    });
    Route::get('/invoice/{id}', [CustomerController::class, 'GetSalesHistoryFromInvoice']);


    Route::post('/logout', [Usercontroller::class, 'Logout']); //Logout
    Route::post('/add_product_type', [ProductTypeController::class, 'AddProductType']);
    Route::delete('/delete_type', [ProductTypeController::class, 'DeleteProductType']);
    Route::get('/product_type', [ProductTypeController::class, 'GetProductType']);
    Route::view('/inventory', 'Inventory');
    Route::view('/customer_details', 'CustomerDetails');
    Route::view('/product_consting', 'ProductCosting');
    Route::view('/expenses', 'Expenses');
    Route::view('/pl_statement', 'PLStatement');
    Route::view('/set_product_type', 'ProductTypeSection');
    Route::view('/saleshistory', 'SalesHistory');
});
