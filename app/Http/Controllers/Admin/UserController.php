<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Throwable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\HasContentAuthorization;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * @throws Exception
     */
    use HasContentAuthorization;

    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax() || $request->has('draw')) {
            $users = User::query()->select(['id', 'name', 'email', 'created_at']);

            return DataTables::eloquent($users)
                ->editColumn('name', function (User $user) use ($request) {
                    if ($request->user()->is($user)) {
                        return e($user->name) . ' <span class="badge bg-info ms-1">You</span>';
                    }

                    return e($user->name);
                })
                ->addColumn('role', function (User $user) {
                    return $user->roles->pluck('name')->implode(', ') ?: '—';
                })
                ->addColumn('action', function (User $user) use ($request) {
                    if ($request->user()->is($user)) {
                        return '<span class="text-muted">Manage from profile</span>';
                    }

                    $editUrl = route('admin.users.edit', $user->id);
                    $deleteUrl = route('admin.users.destroy', $user->id);

                    $editButton = '';
                    if (Gate::allows('user-edit')) {
                        $editButton = '<a href="' . $editUrl . '" class="custom-edit">
                    <i class="fa-solid fa-pen-to-square me-1 text-secondary"></i>
                    </a>';
                    }
                    $deleteForm = '';
                    if (Gate::allows('user-delete')) {
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
                ->rawColumns(['name', 'action'])
                ->toJson();
        }

        return $this->authorizeContent('user-index','pages.users.index');
    }



    public function create()
    {
        $guard = config('auth.defaults.admin_guard');
        $roles = Role::query()->where('guard_name', $guard)->orderBy('name')->get();

        return $this->authorizeContent('user-create','pages.users.create', compact('roles'));
    }

    /**
     * @throws Throwable
     */
    public function store(UserRequest $request)
    {
        $validated = $request->all();

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'], // hashed by cast
            ]);

            if (!empty($validated['role'] ?? null)) {
                $user->syncRoles([$validated['role']]);
            }
        });

        return to_route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        // $this->authorize('update', $user);

        $guard = config('auth.defaults.admin_guard');
        $roles = Role::query()->where('guard_name', $guard)->orderBy('name')->get();
        $selectedRole = $user->roles->first()?->name;

        return $this->authorizeContent('user-edit','pages.users.create', compact('user', 'roles', 'selectedRole'));
    }

    /**
     * @throws Throwable
     */
    public function update(UserRequest $request, User $user)
    {
        // $this->authorize('update', $user);

        $validated = $request->all();

        DB::transaction(function () use ($validated, $user) {
            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'] ?? null)) {
                $data['password'] = $validated['password']; // hashed by cast
            }

            $user->update($data);

            if (array_key_exists('role', $validated)) {
                if (!empty($validated['role'])) {
                    $user->syncRoles([$validated['role']]);
                } else {
                    $user->syncRoles([]);
                }
            }
        });

        return to_route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // $this->authorize('delete', $user);
        $this->authorizeAction('user-delete');
        $user->delete();

        return to_route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
