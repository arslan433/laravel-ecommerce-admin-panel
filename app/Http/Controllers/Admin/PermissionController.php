<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use App\Traits\HasContentAuthorization;



class PermissionController extends Controller
{
    use HasContentAuthorization;

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

                    $editUrl = route('admin.permissions.edit', $permission->id);
                    $deleteUrl = route('admin.permissions.destroy', $permission->id);

                    $editButton = '';

                    if (Gate::allows('permission-edit')) {
                        $editButton = '<a href="' . $editUrl . '" class="custom-edit">
                    <i class="fa-solid fa-pen-to-square me-1 text-secondary"></i>
                    </a>';
                    }
                    $deleteForm = '';
                    if (Gate::allows('permission-delete')) {
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

        return $this->authorizeContent('permission-create', 'pages.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->authorizeContent('permission-create', 'pages.permissions.create');
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
        return $this->authorizeContent('permission-edit', 'pages.permissions.create', compact('permission'));
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
        $this->authorizeAction('permission-delete');
        $permission->delete();
        return to_route('admin.permissions.index')->with('success', 'Permission deleted successfully');
    }

    public function syncPermissions()
    {
        Artisan::call('app:insert-permissions');
        return back()->with('success', trim(Artisan::output()));
    }
}
