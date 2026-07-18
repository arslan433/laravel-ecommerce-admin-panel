<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\CategoryDescription;
use Illuminate\Http\Request;
use App\Traits\HasContentAuthorization;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    use HasContentAuthorization;

    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->wantsJson() || $request->ajax() || $request->has('draw')) {
            $categories = Category::query()
                // ->leftJoin('category_description as cd', 'cd.category_id', '=', 'categories.id')
                // ->where('cd.language_id', getAdminDefaultLang())
                // ->select('cd.name')->get();
                ->leftJoin('category_descriptions as cd', function ($join) {
                    $join->on('categories.id', '=', 'cd.category_id')
                        ->where('cd.language_id', getAdminDefaultLang());
                })
                ->select([
                    'categories.id',
                    'categories.status',
                    'categories.sort_order',
                    //'categories.image',
                    'cd.name as category_name',
                ]);


            return DataTables::eloquent($categories)
                ->editColumn('status', function ($category) {
                    return $category->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($category) {

                    $editUrl = route('admin.categories.edit', $category->id);
                    $deleteUrl = route('admin.categories.destroy', $category->id);

                    $editButton = '';

                    if (Gate::allows('category-edit')) {
                        $editButton = '<a href="' . $editUrl . '" class="custom-edit">
                    <i class="fa-solid fa-pen-to-square me-1 text-secondary"></i>
                    </a>';
                    }
                    $deleteForm = '';
                    if (Gate::allows('category-delete')) {
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
                ->rawColumns(['status', 'action'])
                ->toJson();
        }

        return $this->authorizeContent('category-index', 'pages.categories.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return $this->authorizeContent('category-create', 'pages.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->all();

        $slug = str($request->translations[1]['name'])->slug();

        DB::transaction(function () use ($slug, $request, $validated) {
            $image_path = "";
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');

                $path = public_path('assets/images/categories');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file_name = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                $image->move($path, $file_name);
                $image_path = 'images/categories/' . $file_name;
            }
                    //    dd($request->all());
            $category = Category::create(array_merge($validated, [
                'image' => $image_path,
                'slug' => $slug
            ]));


            foreach ($request->input('translations', []) as $language_id => $data) {
                CategoryDescription::create([
                    'category_id' => $category->id,
                    'language_id' => $language_id,
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'title_tag' => $data['title_tag'],
                    'alt_tag' => $data['alt_tag'] ?? '',
                    'meta_description' => $data['meta_description'],
                    'meta_keywords' => $data['meta_keywords'],
                ]);
            }
        });

        return to_route('admin.categories.index')->with('success', 'Category created successfully.');
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
    public function edit(Category $category)
    {
        // $categories = Category::all();
        $description = $category->descriptions->keyBy('language_id');
        $categories = Category::with('description')->where('parent_id', 0)->get();


        return $this->authorizeContent('category-edit', 'pages.categories.create', compact('category', 'categories', 'description'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->all();

        DB::transaction(function () use ($request, $validated, $category) {
            $image = $category->image ?? null;
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image')->store('images/categories', 'public');
            }


            $category->update(array_merge($validated, [
                'image' => $image,
            ]));

            foreach ($request->input('translations', []) as $language_id => $data) {
//                dd($data);
                CategoryDescription::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'language_id' => $language_id,
                    ],
                    [
                        'name' => $data['name'] ?? '',
                        'description' => $data['description'] ?? '',
                        'title_tag' => $data['title_tag'] ?? '',
                        'alt_tag' => $data['alt_tag'] ?? '',
                        'meta_description' => $data['meta_description'] ?? '',
                        'meta_keywords' => $data['meta_keywords'] ?? '',
                    ]
                );
            }

        });

        return to_route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorizeAction('category-delete');
         DB::transaction(function () use ($category) {
            $category->descriptions()->delete();
            $category->deleteWithImages();
        });

        return to_route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
