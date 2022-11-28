<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $category = null;
    protected $product = null;

    public function __construct(Category $category, Product $product){
        $this->category = $category;
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->category = $this->category->getAllCategories();
        return view('admin.category.index')->with('category_data', $this->category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = $this->category->getAllParents();
        $return_parent = array(
            '' => 'Select Any One'
        );
        foreach($parent_cats as $cat_info){
            $return_parent[$cat_info->id] = $cat_info->title;
        }

        return view('admin.category.form')->with('parent_cats', $return_parent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['added_by'=>$request->user()->id]);
        $rules = $this->category->getValidationRules();
        $request->validate($rules);


        $data = $request->all();
        $data['slug'] = $this->category->getSlug($data['title']);
        $data['is_parent'] = $request->input('is_parent', 0);

        if($data['is_parent'] == 1){
            $data['parent_id'] = null;
        }
        if($request->image){
            $file_name = uploadImage($request->image, 'categories');
            if($file_name){
                $data['image'] = $file_name;
            } else {
                $data['image'] = null;
            }
        }

        $this->category->fill($data);
        $success = $this->category->save();
        if($success){
            $request->session()->flash('success','Category Added successfully.');
        }else {
            $request->session()->flash('error','Problem while adding category');
        }
        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->category = $this->category->find($id);
        if(!$this->category){
            request()->session()->flash('error','category not found');
            return redirect()->route('category.index');
        }
        $parent_cats = $this->category->getAllParents();
        $return_parent = array(
            '' => 'Select Any One'
        );
        foreach($parent_cats as $cat_info){
            $return_parent[$cat_info->id] = $cat_info->title;
        }

        return view('admin.category.form')
            ->with('category', $this->category)
            ->with('parent_cats', $return_parent);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = $this->category->getValidationRules();
        $request->validate($rules);

        $this->category = $this->category->find($id);

        $data = $request->all();

        $data['is_parent'] = $request->input('is_parent', 0);

        if($data['is_parent'] == 1){
            $data['parent_id'] = null;
        }

        if($request->image){
            $file_name = uploadImage($request->image, 'categories');
            if($file_name){
                $data['image'] = $file_name;
            } else {
                $data['image'] = null;
            }
        }

        $this->category->fill($data);
        $success = $this->category->save();
        if($success){
            $request->session()->flash('success','Category updateded successfully.');
        }else {
            $request->session()->flash('error','Problem while updating category');
        }
        return redirect()->route('category.index');
    }

    public function getProductsBySlug(Request $request){
        $this->category = $this->category->where('slug', $request->slug)->first();
        if(!$this->category){
            $request->session()->flash('status','Category not found');
           return view('error.404');
        }

        $this->product = $this->product->getProductsByCatId($this->category->id);
        return view('home.category')->with('products',$this->product);
    }

    public function getProductByChildSlug(Request $request){
        $this->category = $this->category->where('slug', $request->slug)->first();
        if(!$this->category){
            $request->session()->flash('status','Category not found');
            return view('error.404');
        }

        $this->product = $this->product->getProductsBySubCatId($this->category->id);
        return view('home.category')->with('products',$this->product);
    }

    public function getChildCategoryFromParent(Request $request){
        $child_category = $this->category->getAllChildCategoriesFromParent($request->category_id);

        if($child_category->count() > 0){
            return response()->json(['success' => true, 'data' => $child_category]);
        } else {
            return response()->json(['success' => false, 'data' => $child_category]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category = $this->category->find($id);

        if(!$this->category){
            request()->session()->flash('error','Category not found');
            return redirect()->route('category.index');
        }

        $child_cats = $this->category->getChildCategoriesId($id);


        $image = $this->category->image;

        $del = $this->category->delete();
        if($del){
            if($image != null && file_exists(public_path().'/uploads/categories/'.$image)){
                unlink(public_path().'/uploads/categories/'.$image);
            }
            if($child_cats){
                $this->category->shiftChildToParent($child_cats);
            }
            // UPDATE categories SET is_parent=1 WHERE id IN (3,4,5)
            request()->session()->flash('success', 'Category deleted successfully.');
        } else {
            request()->session()->flash('error', 'Category could not be deleted at this moment.');
        }
        return redirect()->route('category.index');
    }
}
