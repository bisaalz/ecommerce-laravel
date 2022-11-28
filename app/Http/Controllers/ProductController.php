<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product = null;
    protected $category = null;
    protected $user = null;
    protected $product_image = null;
    protected $product_review = null;

    public function __construct(Product $product, Category $category, User $user, ProductImage $product_image, ProductReview $product_review)
    {
        $this->product = $product;
        $this->product_review = $product_review;
        $this->product_image = $product_image;
        $this->user = $user;
        $this->category = $category;
    }

    public function getAllProduct(){
        $this->product = $this->product->where('status','active')->orderBy('id','DESC')->paginate(40);
        return view('home.product-list')->with('products', $this->product);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->product = $this->product->getAllProducts();
        return view('admin.product.index')->with('product_data', $this->product);
    }


    public function getproductsByVendor(){
        $this->product = $this->product->getAllProductsByVendor(request()->user()->id);
        return view('vendor.product.index')->with('product_data', $this->product);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats = $this->category->getAllParents();
        $return_cats = array();
        if($parent_cats) {
            foreach ($parent_cats as $key=>$cat_info){
                $return_cats[$cat_info->id] =  $cat_info->title;
            }
        }
        $vendors = $this->user->where('role','vendor')->where('status','active')->orderBy('name','ASC')->get();
        $return_vendor = array(
            request()->user()->id => request()->user()->name
        );
        if($vendors){
            foreach($vendors as $vendor_info){
                $return_vendor[$vendor_info->id] = $vendor_info->name;
            }

        }
        return view('admin.product.form')
            ->with('vendor', $return_vendor)
            ->with('parent_cats', $return_cats);
    }

    public function getSearchResult(Request $request){
        // SELECT * FROM products WHERE status = 'active' AND (title  LIKE '%'.$request->search.'%' OR summary LIKE '%'.$request->search.'%')
        // %test%
        $this->product = $this->product->where('status','active')
                                        ->where(function($query){
                                            global $request;
                                            return $query->Where(
                                                'title','LIKE','%'.$request->search.'%')
                                                ->orWhere('summary', 'LIKE', '%'.$request->search.'%')
                                                ->orWhere('description', 'LIKE', '%'.$request->search.'%');
                                        })->paginate(24);
        return view('home.product-list')->with('products',$this->product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->product->getRules();
        $request->validate($rules);

        $data = $request->all();
        $data['added_by'] = $request->user()->id;
        $data['slug'] = $this->product->getSlug($request->title);

        if($request->image){
            $file_name = uploadImage($request->image, "product");
            if($file_name){
                $data['image'] = $file_name;
            } else {
                $data['image'] = null;
            }
        }

        $this->product->fill($data);
        $success = $this->product->save();

        if($success){
            if($request->other_images){
                foreach($request->other_images as $other_images){
                    $file = uploadImage($other_images, 'product');
                    if($file){
                        $temp = array(
                            'product_id' => $this->product->id,
                            'image_name' => $file
                        );
                        ProductImage::insert($temp);
                    }
                }
            }
            $request->session()->flash('success','Product added successfully.');
        } else {
            $request->session()->flash('error','Problem adding product.');
        }
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->product = $this->product->getById($id);
        if(!$this->product){
            request()->session()->flash('error','Product not found.');
            return redirect()->route('product.index');
        }


        $parent_cats = $this->category->getAllParents();
        $return_cats = array();
        if($parent_cats) {
            foreach ($parent_cats as $key=>$cat_info){
                $return_cats[$cat_info->id] =  $cat_info->title;
            }
        }
        $vendors = $this->user->where('role','vendor')->where('status','active')->orderBy('name','ASC')->get();
        $return_vendor = array(
            request()->user()->id => request()->user()->name
        );
        if($vendors){
            foreach($vendors as $vendor_info){
                $return_vendor[$vendor_info->id] = $vendor_info->name;
            }

        }

        $return_child_cats= array();

        if($this->product->child_cat_id != null){
            $child_cats = $this->category->getAllChildCategoriesFromParent($this->product->cat_id);
            if($child_cats){
                foreach($child_cats as $children){
                    $return_child_cats[$children->id] = $children->title;
                }
            }
        }
        return view('admin.product.form')
            ->with('vendor', $return_vendor)
            ->with('product', $this->product)
            ->with('child_cats', $return_child_cats)
            ->with('parent_cats', $return_cats);
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
        $this->product = $this->product->find($id);
        if(!$this->product){
            $request->session()->flash('error', 'product not found.');
            return redirect()->route('product.index');
        }

        $rules = $this->product->getRules();
        $request->validate($rules);

        $data = $request->all();

        if($request->image){
            $file_name = uploadImage($request->image, "product");
            if($file_name){
                $data['image'] = $file_name;
                if(file_exists(public_path().'/uploads/product/'.$this->product->image)){
                    unlink(public_path().'/uploads/product/'.$this->product->image);
                }
            }
        }



        $this->product->fill($data);
        $success = $this->product->save();

        if($success){
            if($request->other_images){
                foreach($request->other_images as $other_images){
                    $file = uploadImage($other_images, 'product');
                    if($file){
                        $temp = array(
                            'product_id' => $this->product->id,
                            'image_name' => $file
                        );
                        ProductImage::insert($temp);
                    }
                }
            }

            if(isset($request->del_image)){
                foreach($request->del_image as $del_image){
                    $del_success =  $this->product_image->where('image_name',$del_image)->delete();
                    if($del_success){
                        if(file_exists(public_path().'/uploads/product/'.$del_image)){
                            unlink(public_path().'/uploads/product/'.$del_image);
                        }
                    }
                }
            }
            $request->session()->flash('success','Product updated successfully.');
        } else {
            $request->session()->flash('error','Problem updating product.');
        }
        return redirect()->route('product.index');
    }


    public function submitProductReview(Request $request){
        $data = $request->all();
        $data['product_id'] = $request->product_id;
        $data['user_id'] = $request->user()->id;
        $data['status'] = 'active';

        $this->product_review->fill($data);
        $success = $this->product_review->save();
        if($success){
            $request->session()->flash('success','Review submited successfully.');
        } else {
            $request->session()->flash('error','Problem adding review.');
        }
        return redirect()->back();
    }

    public function getProductDetail(Request $request){
        $this->product = $this->product->getProductBySlug($request->slug);
        // dd($this->product);

        if(!$this->product){
            $request->session()->flash('status','Product not found');
            return view('error.404');
        }

        return view('home.product-detail')->with('product',$this->product);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->product = $this->product->getById($id);
        if(!$this->product){
            request()->session()->flash('error','Product not found.');
            return redirect()->route('product.index');
        }

        $image = $this->product->image;
        $related_images = $this->product->product_images;

        $del = $this->product->delete();
        if($del){

            if($image != null && file_exists(public_path().'/uploads/product/'.$image)){
                unlink(public_path().'/uploads/product/'.$image);
            }

            if($related_images){
                foreach($related_images as $del_image){
                    if($del_image->image_name != null && file_exists(public_path().'/uploads/product/'.$del_image->image_name)){
                        unlink(public_path().'/uploads/product/'.$del_image->image_name);
                    }
                }
            }
            request()->session()->flash('success','Product deleted successfully.');
        } else {
            request()->session()->flash('error','Product could not be deleted at this moment.');
        }
        return redirect()->route('product.index');
    }
}
