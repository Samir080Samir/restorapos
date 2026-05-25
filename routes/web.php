<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RestaurantController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\LicenseController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Owner\PosTerminalController;
use App\Http\Controllers\Owner\OwnerRoleController;
use App\Http\Controllers\Owner\OwnerStaffController;
use App\Http\Controllers\Owner\OwnerBranchController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\MenuCategoryController;
use App\Http\Controllers\Owner\MenuDepartmentController;
use App\Http\Controllers\Owner\TableManagementController;
use App\Http\Controllers\Owner\CustomerController as OwnerCustomerController;
use App\Http\Controllers\Owner\CustomerDebtController as OwnerCustomerDebtController;

use App\Http\Controllers\Staff\TableReservationController;
use App\Http\Controllers\Staff\StaffLoginController;
use App\Http\Controllers\Staff\PosOrderController;
use App\Http\Controllers\Staff\CustomerController as StaffCustomerController;

use App\Http\Controllers\QrMenu\QrMenuController;

use App\Models\Restaurant;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route('owner.login');
});

/*
|--------------------------------------------------------------------------
| STAFF / POS TERMINAL LOGIN
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->name('staff.')->group(function () {

    Route::get('/login', [StaffLoginController::class, 'login'])->name('login');
    Route::post('/terminal/check', [StaffLoginController::class, 'checkTerminal'])->name('terminal.check');
    Route::post('/pin-login', [StaffLoginController::class, 'pinLogin'])->name('pin-login');
    Route::get('/dashboard', [StaffLoginController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [StaffLoginController::class, 'logout'])->name('logout');
    Route::post('/terminal/reset', [StaffLoginController::class, 'resetTerminal'])->name('terminal.reset');
    Route::post('/orders', [PosOrderController::class, 'store'])
        ->name('orders.store');
    Route::get('/orders/open-checks', [PosOrderController::class, 'openChecks'])
        ->name('orders.open-checks');
    Route::get('/orders/table/{table}', [PosOrderController::class, 'active'])
        ->name('orders.active');
    Route::post('/orders/new-check', [PosOrderController::class, 'newCheck'])
        ->name('orders.new-check');
    Route::post('/orders/move-table', [PosOrderController::class, 'moveTable'])
        ->name('orders.move-table');
    Route::post('/orders/merge-tables', [PosOrderController::class, 'mergeTables'])
        ->name('orders.merge-tables');
    Route::post('/orders/merge-checks', [PosOrderController::class, 'mergeChecks'])
        ->name('orders.merge-checks');
    Route::post('/orders/print-bill', [PosOrderController::class, 'printBill'])
        ->name('orders.print-bill');
    Route::post('/orders/unlock-bill', [PosOrderController::class, 'unlockBill'])
        ->name('orders.unlock-bill');
    Route::post('/orders/complete-payment', [PosOrderController::class, 'completePayment'])
        ->name('orders.complete-payment');

    /*
    |--------------------------------------------------------------------------
    | Staff POS Customers
    |--------------------------------------------------------------------------
    */

    Route::get('/customers/search', [StaffCustomerController::class, 'search'])
        ->name('customers.search');

    Route::post('/customers', [StaffCustomerController::class, 'store'])
        ->name('customers.store');

    Route::post('/reservations', [TableReservationController::class, 'store'])
        ->name('reservations.store');

    Route::post('/reservations/{id}/cancel', [TableReservationController::class, 'cancel'])
        ->name('reservations.cancel');
    Route::post('/reservations/{id}/complete', [TableReservationController::class, 'complete'])
        ->name('reservations.complete');
});

/*
|--------------------------------------------------------------------------
| OWNER PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('owner')->name('owner.')->group(function () {

    Route::get('/login', function () {
        return view('owner.auth.login');
    })->name('login');

    Route::post('/check-brand', function (Request $request) {

        $brandName = trim($request->brand_name ?? '');

        if ($brandName === '') {
            return response()->json([
                'exists' => false,
                'message' => 'Brend adı boşdur.',
            ]);
        }

        $restaurant = Restaurant::whereRaw(
            'LOWER(name) = ?',
            [mb_strtolower($brandName)]
        )->first();

        if (! $restaurant) {
            return response()->json([
                'exists' => false,
                'message' => 'Brend tapılmadı.',
            ]);
        }

        Session::put([
            'owner_pending_restaurant_id'    => $restaurant->id,
            'owner_pending_restaurant_name'  => $restaurant->name,
            'owner_pending_restaurant_email' => $restaurant->email,
        ]);

        return response()->json([
            'exists'           => true,
            'message'          => 'Brend tapıldı.',
            'restaurant_id'    => $restaurant->id,
            'restaurant_name'  => $restaurant->name,
            'restaurant_email' => $restaurant->email,
        ]);
    })->name('check-brand');

    Route::post('/login-submit', function (Request $request) {

        $restaurantId = Session::get('owner_pending_restaurant_id');

        if (! $restaurantId) {
            return response()->json([
                'success' => false,
                'message' => 'Əvvəlcə brend adını yoxlayın.',
            ]);
        }

        $restaurant = Restaurant::find($restaurantId);

        if (! $restaurant) {
            return response()->json([
                'success' => false,
                'message' => 'Restoran tapılmadı.',
            ]);
        }

        $email = trim($request->email ?? '');
        $code  = trim($request->code ?? '');

        if ($email !== $restaurant->email) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail düzgün deyil.',
            ]);
        }

        if ($code === '') {
            return response()->json([
                'success' => false,
                'message' => 'Parol düzgün deyil.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Owner login
        |--------------------------------------------------------------------------
        */

        $ownerLogin = $restaurant->owner_password &&
            Hash::check($code, $restaurant->owner_password);

        if ($ownerLogin) {

            Session::put([
                'owner_restaurant_id'    => $restaurant->id,
                'owner_restaurant_name'  => $restaurant->name,
                'owner_restaurant_email' => $restaurant->email,
                'owner_user_type'        => 'owner',
                'owner_user_id'          => null,
                'owner_branch_id'        => null,
            ]);

            Session::forget([
                'owner_selected_branch_id',
                'owner_selected_branch_name',
            ]);

            return response()->json([
                'success'  => true,
                'redirect' => route('owner.dashboard'),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Panel staff login
        |--------------------------------------------------------------------------
        */

        $staffUser = User::with('branch')
            ->where('restaurant_id', $restaurant->id)
            ->where('login_type', 'panel')
            ->where('staff_code', $code)
            ->where('is_active', true)
            ->first();

        if (! $staffUser) {
            return response()->json([
                'success' => false,
                'message' => 'Parol düzgün deyil.',
            ]);
        }

        Session::put([
            'owner_restaurant_id'    => $restaurant->id,
            'owner_restaurant_name'  => $restaurant->name,
            'owner_restaurant_email' => $restaurant->email,
            'owner_user_type'        => 'staff',
            'owner_user_id'          => $staffUser->id,
            'owner_branch_id'        => $staffUser->branch_id,
        ]);

        if ($staffUser->branch_id) {

            Session::put([
                'owner_selected_branch_id'   => $staffUser->branch_id,
                'owner_selected_branch_name' => optional($staffUser->branch)->name ?? 'Filial',
            ]);

            return response()->json([
                'success'  => true,
                'redirect' => route('branch.dashboard'),
            ]);
        }

        Session::forget([
            'owner_selected_branch_id',
            'owner_selected_branch_name',
        ]);

        return response()->json([
            'success'  => true,
            'redirect' => route('owner.dashboard'),
        ]);
    })->name('login-submit');

    Route::get('/dashboard', function () {

        if (! Session::has('owner_restaurant_id')) {
            return redirect()->route('owner.login');
        }

        return view('owner.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Owner Branches
    |--------------------------------------------------------------------------
    */

    Route::get('/branches', [OwnerBranchController::class, 'index'])->name('branches.index');
    Route::get('/branches/{branch}/edit', [OwnerBranchController::class, 'edit'])->name('branches.edit');
    Route::put('/branches/{branch}', [OwnerBranchController::class, 'update'])->name('branches.update');

    Route::post('/branches/switch', function (Request $request) {

        $branchId = $request->branch_id;

        if ($branchId) {

            $branch = \App\Models\Branch::where('restaurant_id', session('owner_restaurant_id'))
                ->where('id', $branchId)
                ->where('status', 'active')
                ->first();

            if ($branch) {

                session([
                    'owner_selected_branch_id'   => $branch->id,
                    'owner_selected_branch_name' => $branch->name,
                    'owner_branch_preview'       => true,
                ]);

                return redirect()->route('branch.dashboard');
            }
        }

        session()->forget([
            'owner_selected_branch_id',
            'owner_selected_branch_name',
            'owner_branch_preview',
        ]);

        return redirect()->route('owner.dashboard');
    })->name('branches.switch');

    /*
    |--------------------------------------------------------------------------
    | Owner Menu Products
    |--------------------------------------------------------------------------
    */

    Route::prefix('menu/products')
        ->name('menu.products.')
        ->group(function () {

            Route::get('/', [ProductController::class, 'index'])
                ->name('index');

            Route::get('/create', [ProductController::class, 'create'])
                ->name('create');

            Route::post('/store', [ProductController::class, 'store'])
                ->name('store');

            Route::get('/{product}/edit', [ProductController::class, 'edit'])
                ->name('edit');

            Route::put('/{product}', [ProductController::class, 'update'])
                ->name('update');
        });

    /*
    |--------------------------------------------------------------------------
    | Owner Menu Categories
    |--------------------------------------------------------------------------
    */

    Route::prefix('menu/categories')
        ->name('menu.categories.')
        ->group(function () {

            Route::get('/', [MenuCategoryController::class, 'index'])
                ->name('index');

            Route::get('/create', [MenuCategoryController::class, 'create'])
                ->name('create');

            Route::post('/store', [MenuCategoryController::class, 'store'])
                ->name('store');

            Route::get('/{category}/edit', [MenuCategoryController::class, 'edit'])
                ->name('edit');

            Route::put('/{category}', [MenuCategoryController::class, 'update'])
                ->name('update');

            Route::delete('/{category}', [MenuCategoryController::class, 'destroy'])
                ->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Owner Menu Departments
    |--------------------------------------------------------------------------
    */

    Route::prefix('menu/departments')
        ->name('menu.departments.')
        ->group(function () {

            Route::get('/', [MenuDepartmentController::class, 'index'])
                ->name('index');

            Route::get('/create', [MenuDepartmentController::class, 'create'])
                ->name('create');

            Route::post('/store', [MenuDepartmentController::class, 'store'])
                ->name('store');

            Route::get('/{department}/edit', [MenuDepartmentController::class, 'edit'])
                ->name('edit');

            Route::put('/{department}', [MenuDepartmentController::class, 'update'])
                ->name('update');

            Route::delete('/{department}', [MenuDepartmentController::class, 'destroy'])
                ->name('destroy');
        });

    /*
    |--------------------------------------------------------------------------
    | Owner Staff Roles
    |--------------------------------------------------------------------------
    */

    Route::get('/staff/roles', [OwnerRoleController::class, 'index'])->name('staff.roles.index');
    Route::get('/staff/roles/create', [OwnerRoleController::class, 'create'])->name('staff.roles.create');
    Route::post('/staff/roles', [OwnerRoleController::class, 'store'])->name('staff.roles.store');
    Route::get('/staff/roles/{role}/edit', [OwnerRoleController::class, 'edit'])->name('staff.roles.edit');
    Route::put('/staff/roles/{role}', [OwnerRoleController::class, 'update'])->name('staff.roles.update');

    /*
    |--------------------------------------------------------------------------
    | Owner Staff Users
    |--------------------------------------------------------------------------
    */

    Route::get('/staff/users', [OwnerStaffController::class, 'index'])->name('staff.users.index');
    Route::get('/staff/users/create', [OwnerStaffController::class, 'create'])->name('staff.users.create');
    Route::post('/staff/users', [OwnerStaffController::class, 'store'])->name('staff.users.store');
    Route::get('/staff/users/{user}/edit', [OwnerStaffController::class, 'edit'])->name('staff.users.edit');
    Route::put('/staff/users/{user}', [OwnerStaffController::class, 'update'])->name('staff.users.update');

    /*
|--------------------------------------------------------------------------
| Owner Tables
|--------------------------------------------------------------------------
*/
    Route::get('/tables', [TableManagementController::class, 'tablesIndex'])
        ->name('tables.index');

    Route::get('/tables/manage', [TableManagementController::class, 'index'])
        ->name('tables.manage');

    Route::post('/tables/areas', [TableManagementController::class, 'storeArea'])
        ->name('tables.areas.store');

    Route::post('/tables/store', [TableManagementController::class, 'storeTable'])
        ->name('tables.store');

    Route::post('/tables/layout/save', [TableManagementController::class, 'saveLayout'])
        ->name('tables.layout.save');

    Route::delete('/tables/{table}', [TableManagementController::class, 'destroyTable'])
        ->name('tables.destroy');

    Route::put('/tables/{table}', [TableManagementController::class, 'updateTable'])
        ->name('tables.update');

    Route::post('/tables/areas/sort', [TableManagementController::class, 'sortAreas'])
        ->name('tables.areas.sort');

    /*
    |--------------------------------------------------------------------------
    | Owner Reservations
    |--------------------------------------------------------------------------
    */

    Route::get('/reservations', [\App\Http\Controllers\Owner\TableReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/create', [\App\Http\Controllers\Owner\TableReservationController::class, 'create'])
        ->name('reservations.create');

    Route::post('/reservations', [\App\Http\Controllers\Owner\TableReservationController::class, 'store'])
        ->name('reservations.store');

    Route::post('/reservations/{id}/cancel', [\App\Http\Controllers\Owner\TableReservationController::class, 'cancel'])
        ->name('reservations.cancel');

    Route::post('/reservations/{id}/complete', [\App\Http\Controllers\Owner\TableReservationController::class, 'complete'])
        ->name('reservations.complete');


    /*
    |--------------------------------------------------------------------------
    | POS Terminals
    |--------------------------------------------------------------------------
    */

    Route::get('/pos-terminals', [PosTerminalController::class, 'index'])->name('pos-terminals.index');
    Route::get('/pos-terminals/create', [PosTerminalController::class, 'create'])->name('pos-terminals.create');
    Route::post('/pos-terminals', [PosTerminalController::class, 'store'])->name('pos-terminals.store');
    Route::get('/pos-terminals/{pos_terminal}/edit', [PosTerminalController::class, 'edit'])->name('pos-terminals.edit');
    Route::put('/pos-terminals/{pos_terminal}', [PosTerminalController::class, 'update'])->name('pos-terminals.update');
    Route::delete('/pos-terminals/{pos_terminal}', [PosTerminalController::class, 'destroy'])->name('pos-terminals.destroy');
    Route::patch('/pos-terminals/{pos_terminal}/toggle', [PosTerminalController::class, 'toggle'])->name('pos-terminals.toggle');
    Route::patch('/pos-terminals/{pos_terminal}/reset', [PosTerminalController::class, 'reset'])->name('pos-terminals.reset');

    /*
    |--------------------------------------------------------------------------
    | Owner Customers / Customer Debts
    |--------------------------------------------------------------------------
    */

    Route::get('/customers', [OwnerCustomerController::class, 'index'])
        ->name('customers.index');

    Route::post('/customers', [OwnerCustomerController::class, 'store'])
        ->name('customers.store');

    Route::get('/customers/{customer}', [OwnerCustomerController::class, 'show'])
        ->name('customers.show');

    Route::get('/customer-debts', [OwnerCustomerDebtController::class, 'index'])
        ->name('customer-debts.index');

    Route::post('/customer-debts/{debt}/pay', [OwnerCustomerDebtController::class, 'pay'])
        ->name('customer-debts.pay');

    Route::post('/customer-debts/{debt}/close', [OwnerCustomerDebtController::class, 'close'])
        ->name('customer-debts.close');

    /*
    |--------------------------------------------------------------------------
    | Owner Logout
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', function () {

        Session::forget([
            'owner_pending_restaurant_id',
            'owner_pending_restaurant_name',
            'owner_pending_restaurant_email',
            'owner_restaurant_id',
            'owner_restaurant_name',
            'owner_restaurant_email',
            'owner_user_type',
            'owner_user_id',
            'owner_branch_id',
            'owner_selected_branch_id',
            'owner_selected_branch_name',
        ]);

        return redirect()->route('owner.login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| BRANCH PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('branch')->name('branch.')->group(function () {

    Route::get('/dashboard', function () {

        if (! Session::has('owner_restaurant_id')) {
            return redirect()->route('owner.login');
        }

        if (! Session::has('owner_branch_id') && ! Session::has('owner_selected_branch_id')) {
            return redirect()->route('owner.dashboard');
        }

        return view('branch.dashboard');
    })->name('dashboard');

    Route::post('/logout', function () {

        Session::forget([
            'owner_pending_restaurant_id',
            'owner_pending_restaurant_name',
            'owner_pending_restaurant_email',
            'owner_restaurant_id',
            'owner_restaurant_name',
            'owner_restaurant_email',
            'owner_user_type',
            'owner_user_id',
            'owner_branch_id',
            'owner_selected_branch_id',
            'owner_selected_branch_name',
        ]);

        return redirect()->route('owner.login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| Public QR Menu
|--------------------------------------------------------------------------
*/
Route::get('/menu/{restaurantSlug}', [QrMenuController::class, 'showRestaurant'])
    ->name('public.qr-menu.restaurant');

Route::get('/menu/{restaurantSlug}/table/{tableCode}', [QrMenuController::class, 'show'])
    ->name('public.qr-menu.show');


/*
|--------------------------------------------------------------------------
| Laravel Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| SUPER ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'super_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('restaurants', RestaurantController::class);
        Route::resource('branches', BranchController::class);
        Route::resource('plans', PlanController::class);
        Route::resource('licenses', LicenseController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('campaigns', CampaignController::class);
        Route::resource('users', UserController::class);
        Route::resource('admin-roles', AdminRoleController::class);

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

Route::get('/debug-restaurants', function () {
    return \App\Models\Restaurant::select('id', 'name', 'slug')->get();
});

require __DIR__ . '/auth.php';
