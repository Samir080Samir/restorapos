<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Audit history siyahısı.
     */
    public function index(Request $request)
    {
        $query = AuditLog::with([
            'user',
            'restaurant',
            'branch',
        ])->latest();

        /*
        |--------------------------------------------------------------------------
        | Multi Tenant Logic
        |--------------------------------------------------------------------------
        | Super admin → hər şeyi görür
        | Restaurant owner → yalnız öz restoranını görür
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->restaurant_id
            && ! auth()->user()->isSuperAdmin()
        ) {
            $query->where(
                'restaurant_id',
                auth()->user()->restaurant_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filterlər
        |--------------------------------------------------------------------------
        */

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        $logs = $query->paginate(25);

        /*
        |--------------------------------------------------------------------------
        | Filter məlumatları
        |--------------------------------------------------------------------------
        */

        $modules = AuditLog::select('module')
            ->distinct()
            ->pluck('module');

        $actions = AuditLog::select('action')
            ->distinct()
            ->pluck('action');

        return view('admin.audit-logs.index', compact(
            'logs',
            'modules',
            'actions'
        ));
    }
}
