<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRoleController extends Controller
{
    /**
     * İcazə veriləcək admin panel modulları.
     */
    private array $modules = [
        'dashboard' => 'İdarə paneli',
        'restaurants' => 'Restoranlar',
        'branches' => 'Filiallar',
        'users' => 'İstifadəçilər',
        'plans' => 'Paketlər',
        'licenses' => 'Lisenziyalar',
        'payments' => 'Ödənişlər',
        'campaigns' => 'Endirimlər və Kampaniyalar',
        'admin_roles' => 'Admin rolları',
        'audit_logs' => 'Audit tarixçəsi',
    ];

    /**
     * Admin rollarının siyahısı.
     */
    public function index()
    {
        $roles = AdminRole::withCount('users')
            ->with('permissions')
            ->latest()
            ->get();

        return view('admin.admin-roles.index', compact('roles'));
    }

    /**
     * Yeni rol yaratma səhifəsi.
     */
    public function create()
    {
        $modules = $this->modules;

        return view('admin.admin-roles.create', compact('modules'));
    }

    /**
     * Yeni rolu bazaya əlavə edir.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name',
            'description' => 'nullable|string|max:3000',
        ]);

        $role = AdminRole::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'is_system' => false,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($this->modules as $moduleKey => $moduleName) {
            $role->permissions()->create([
                'module' => $moduleKey,
                'can_view' => $request->has("permissions.$moduleKey.view"),
                'can_create' => $request->has("permissions.$moduleKey.create"),
                'can_update' => $request->has("permissions.$moduleKey.update"),
                'can_delete' => $request->has("permissions.$moduleKey.delete"),
            ]);
        }

        $role->load('permissions');

        AuditLogger::log(
            module: 'admin_roles',
            action: 'created',
            eventKey: 'audit.admin_roles.created',
            description: 'Yeni admin rolu yaradıldı.',
            auditable: $role,
            newValues: [
                'role' => $role->toArray(),
                'permissions' => $role->permissions->toArray(),
            ]
        );

        return redirect()
            ->route('admin.admin-roles.index')
            ->with('success', 'Admin rolu uğurla yaradıldı.');
    }

    /**
     * Rolu redaktə etmə səhifəsi.
     */
    public function edit(AdminRole $adminRole)
    {
        $modules = $this->modules;

        $permissions = $adminRole->permissions
            ->keyBy('module');

        return view('admin.admin-roles.edit', compact(
            'adminRole',
            'modules',
            'permissions'
        ));
    }

    /**
     * Rol məlumatlarını yeniləyir.
     */
    public function update(Request $request, AdminRole $adminRole)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name,' . $adminRole->id,
            'description' => 'nullable|string|max:3000',
        ]);

        $adminRole->load('permissions');

        $oldValues = [
            'role' => $adminRole->toArray(),
            'permissions' => $adminRole->permissions->toArray(),
        ];

        $adminRole->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $adminRole->id,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        foreach ($this->modules as $moduleKey => $moduleName) {
            $adminRole->permissions()->updateOrCreate(
                [
                    'module' => $moduleKey,
                ],
                [
                    'can_view' => $request->has("permissions.$moduleKey.view"),
                    'can_create' => $request->has("permissions.$moduleKey.create"),
                    'can_update' => $request->has("permissions.$moduleKey.update"),
                    'can_delete' => $request->has("permissions.$moduleKey.delete"),
                ]
            );
        }

        $adminRole->load('permissions');

        AuditLogger::log(
            module: 'admin_roles',
            action: 'updated',
            eventKey: 'audit.admin_roles.updated',
            description: 'Admin rolu və icazələri yeniləndi.',
            auditable: $adminRole,
            oldValues: $oldValues,
            newValues: [
                'role' => $adminRole->fresh()->toArray(),
                'permissions' => $adminRole->permissions->toArray(),
            ]
        );

        return redirect()
            ->route('admin.admin-roles.index')
            ->with('success', 'Admin rolu yeniləndi.');
    }

    /**
     * Rolu silir.
     */
    public function destroy(AdminRole $adminRole)
    {
        if ($adminRole->is_system) {
            return redirect()
                ->back()
                ->with('error', 'Sistem rolları silinə bilməz.');
        }

        if ($adminRole->users()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Bu rola bağlı istifadəçilər var. Əvvəlcə istifadəçilərin rolunu dəyişin.');
        }

        $adminRole->load('permissions');

        $oldValues = [
            'role' => $adminRole->toArray(),
            'permissions' => $adminRole->permissions->toArray(),
        ];

        AuditLogger::log(
            module: 'admin_roles',
            action: 'deleted',
            eventKey: 'audit.admin_roles.deleted',
            description: 'Admin rolu silindi.',
            auditable: $adminRole,
            oldValues: $oldValues
        );

        $adminRole->delete();

        return redirect()
            ->route('admin.admin-roles.index')
            ->with('success', 'Admin rolu silindi.');
    }
}
