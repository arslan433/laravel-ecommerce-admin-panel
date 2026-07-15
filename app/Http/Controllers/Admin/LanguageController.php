<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Traits\HasContentAuthorization;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;



class LanguageController extends Controller
{
    use HasContentAuthorization;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax() || $request->has('draw')) {
            $languages = Language::query();


            return DataTables::eloquent($languages)
                ->addColumn('id', function ($language) {
                    return $language->id;
                })
                ->addColumn('name', function ($language) {
                    return $language->name ?? '-';
                })
                ->addColumn('action', function ($language) {

                    $editUrl = route('admin.languages.edit', $language->id);
                    $deleteUrl = route('admin.languages.destroy', $language->id);

                    $editButton = '';

                    if (Gate::allows('language-edit')) {
                        $editButton = '<a href="' . $editUrl . '" class="custom-edit">
                    <i class="fa-solid fa-pen-to-square me-1 text-secondary"></i>
                    </a>';
                    }
                    $deleteForm = '';
                    if (Gate::allows('language-delete')) {
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

        return $this->authorizeContent('language-index', 'pages.languages.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->authorizeContent('language-create', 'pages.languages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LanguageRequest $request)
    {
        // dd($request->all());
        $validated = $request->all();

        DB::transaction(function () use ($validated) {
            Language::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
                'directory' => $validated['directory'] ?? null,
                'sort_order' => (int)($validated['sort_order'] ?? 0),
                'default' => (bool)($validated['default'] ?? false),
                'status' => (bool)($validated['status'] ?? false),
            ]);
        });

        return to_route('admin.languages.index')->with('success', 'Language created successfully.');
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
    public function edit(Language $language)
    {
        return $this->authorizeContent('language-edit', 'pages.languages.create', compact('language') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
