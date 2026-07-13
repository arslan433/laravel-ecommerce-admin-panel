<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws Exception
     */
    public function index(Request $request)
    {

        if ($request->wantsJson() || $request->ajax() || $request->has('draw')){
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
                        return '-';
                    }

                    $editUrl   = route('admin.roles.edit', $role->id);
                    $deleteUrl = route('admin.roles.destroy', $role->id);

                      return '
                        <div class="d-flex align-items-center gap-2">
                         <a href="' . $editUrl . '" class="btn btn-light border-light text-dark rounded-pill px-3 py-1 text-sm shadow-sm fw-medium custom-action-btn hover-bg-slate">
                          <i class="bi bi-pencil-square me-1 text-secondary"></i> Edit
                         </a>
        
                          <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure             you want to delete this item?\')">
                           ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                          <button type="submit" class="btn btn-link text-danger text-decoration-none rounded-pill px-3 py-1 text-sm fw-medium custom-action-btn hover-bg-danger-subtle">
                            <i class="bi bi-trash3 me-1"></i> Delete
                             </button>
                            </form>
                         </div>
                ';
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

        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('pages.roles.create', compact('permissions'));
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

        $role = Role::create(['name' => $validated['name'],'guard_name' => config('permission.default.guard')]);
        if($request->permissions){
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
        $permissions = Permission::all();
        $role_permissions = $role->permissions->pluck('id')->toArray();
        return view('pages.roles.create', compact('role', 'permissions', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role = Role::findOrFail($role->id);

        if ($role->name === 'super-admin') {
//            dd($role->name);
            return back()->with('error', 'Super Admin role cannot be edited.');
        }
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
        ]);

        $role->update(['name' => $validated['name'],'guard_name' => config('permission.default.guard')]);
//        if($request->permissions){
            $role->syncPermissions($request->permissions);
//        }
        return to_route('admin.roles.index')->with('success', 'Role updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role = Role::findOrFail($role->id);

        if ($role->name === 'super-admin') {
//            dd($role->name);
            return back()->with('error', 'Super Admin role cannot be edited.');
        }

        $role->delete();
        return to_route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
