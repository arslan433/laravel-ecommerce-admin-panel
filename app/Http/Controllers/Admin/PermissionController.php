<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)

    {
        if ($request->wantsJson() || $request->ajax() || $request->has('draw')) {
            $permissions = Permission::query();


            return DataTables::eloquent($permissions)
                ->addColumn('id', function ($permission) {
                    return $permission->id;
                })
                ->addColumn('name', function ($permission) {
                    return $permission->name ?? '-';
                })
                ->addColumn('action', function ($permission) {

                    $editUrl   = route('admin.permissions.edit', $permission->id);
                    $deleteUrl = route('admin.permissions.destroy', $permission->id);

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

        return view('pages.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|alpha_dash|unique:permissions,name',
            ],
            [
                'name.unique' => 'Permission already exists',
            ]
        );
        Permission::create([
            'name' => $validated['name'],
            'guard_name' => config('permission.default.guard'),
        ]);
        return to_route('admin.permissions.index')->with('success', 'Permission created successfully');
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
    public function edit(Permission $permission)
    {
        //        $permission = Permission::where('id', $id)->first();
        return view('pages.permissions.create', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|alpha_dash|unique:permissions,name,' . $permission->id,
        ], [
            'name.unique' => 'Permission already exists',
        ]);
        $permission->update([
            'name' => $validated['name'],
            'guard_name' => config('permission.default.guard'),
        ]);
        return to_route('admin.permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return to_route('admin.permissions.index')->with('success', 'Permission deleted successfully');
    }

    public function syncPermissions()
    {
        Artisan::call('app:insert-permissions');
        return back()->with('success', trim(Artisan::output()));
    }
}
