<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

use App\Traits\HasContentAuthorization;



class RoleController extends Controller
{
    use HasContentAuthorization;

    /**
     * Display a listing of the resource.
     * @throws Exception
     */


    public function index(Request $request)
    {

        if ($request->wantsJson() || $request->ajax() || $request->has('draw')) {
            $roles = Role::query();

            return DataTables::eloquent($roles)
                ->addColumn('id', function ($role) {
                    return $role->id;
                })
                ->addColumn('name', function ($role) {
                    return $role->name ?? '-';
                })
                ->addColumn('action', function ($role) {
                    if ($role->name === 'super-admin') {
                        return '<div class="px-5"> - </div>';
                    }

                    $editUrl = route('admin.roles.edit', $role->id);
                    $deleteUrl = route('admin.roles.destroy', $role->id);
                    $editButton = '';
                    if (Gate::allows('role-edit')) {
                        $editButton = '<a href="' . $editUrl . '" class="custom-edit">
                    <i class="fa-solid fa-pen-to-square me-1 text-secondary"></i>
                    </a>';
                    }
                    $deleteForm = '';
                    if (Gate::allows('role-delete')) {
                        $deleteForm = '<form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this item?\')"> '
                            . csrf_field() . ' ' . method_field('DELETE') . ' 
                         <button type="submit" class="custom-delete">
                        <i class="fa-solid fa-trash me-1"></i>
                        </button>
                         </form>';
                    }

                    return '

                        <div class="d-flex align-items-center gap-2">'
                        . $editButton

                        . $deleteForm .
                        '</div>';
                })
                ->filterColumn('name', function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->orderColumn('name', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->orderColumn('id', function ($query, $order) {
                    $query->orderBy('id', $order);
                })
                ->rawColumns(['action', 'name', 'id'])
                ->toJson();
        }

        return $this->authorizeContent('role-index', 'pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        // if (!auth()->user()->can('role-create')) {
        //     return view('components.403-error'); 
        // }
        $permissions = Permission::all();
        return $this->authorizeContent('role-create', 'pages.roles.create', compact('permissions'));

        // return view('pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => config('permission.default.guard')]);
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }
        return to_route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Role $role)
    {
        // if (!auth()->user()->can('role-edit')) {
        //     return view('components.403-error');
        // }
        $permissions = Permission::all();
        $role_permissions = $role->permissions->pluck('id')->toArray();
        return $this->authorizeContent('role-edit', 'pages.roles.create', compact('role', 'permissions', 'role_permissions'));
        // return view('pages.roles.create', compact('role', 'permissions', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::findOrFail($role->id);

        if ($role->name === 'super-admin') {
            return back()->with('error', 'Super Admin role cannot be edited.');
        }
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->syncPermissions($request->permissions);

        $role->update(['name' => $validated['name'], 'guard_name' => config('permission.default.guard')]);
        return to_route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Role $role)
    {
        $this->authorizeAction('role-delete');

        $role = Role::findOrFail($role->id);

        if ($role->name === 'super-admin') {
            return back()->with('error', 'Super Admin role cannot be edited.');
        }

        $role->delete();
        return to_route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
