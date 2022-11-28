<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title' ,'slug','added_by', 'cat_id', 'child_cat_id', 'summary', 'description', 'price', 'discount' , 'image' ,'brand','vendor_id','status'];

    public function getRules(){
        return [
            'title' => 'required|string',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'sometimes|image|max:5000',
            'brand' => 'nullable|string',
            'vendor_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive',
            'other_images.*' => 'sometimes|image|max:5000'
        ];
    }

    public function category_info(){
        return $this->hasOne('App\Models\Category','id', 'cat_id');
    }


    public function child_category_info(){
        return $this->hasOne('App\Models\Category','id', 'child_cat_id');
    }

    public function vendor_info(){
        return $this->hasOne('App\User','id', 'vendor_id');
    }

    public function product_images(){
        return $this->hasMany('App\Models\ProductImage','product_id','id');
    }

    public function getAllProducts($status = false){
        if($status == false) {
            return $this->with(['category_info', 'child_category_info', 'vendor_info'])->orderBy('id', 'DESC')->get();
        } else {
            return $this->where('status','active')->orderBy('id', 'DESC')->paginate(24);

        }
    }

    public function getAllProductsByVendor($vendor_id){
        return $this->with(['category_info','child_category_info','vendor_info'])->where('added_by',$vendor_id)->orWhere('vendor_id', $vendor_id)->orderBy('id','DESC')->get();

    }

    public function getProductsByCatId($cat_id){
        return $this->where('status','active')->where('cat_id', $cat_id)->orderBy('id','DESC')->paginate(32);
    }

    public function getProductsBySubCatId($child_cat_id){
        return $this->where('status','active')->where('child_cat_id', $child_cat_id)->orderBy('id','DESC')->paginate(32);
    }

    public function getById($id){
        return $this->with('product_images')->find($id);
    }

    public function reviews(){
        return $this->hasMany('App\Models\ProductReview','product_id', 'id')->with('user_info')->where('status','active');
    }

    public function related_products(){
        return $this->hasMany('App\Models\Product', 'cat_id','cat_id')->where('status','active')->limit(6);
    }

    public function getProductBySlug($slug){
        return $this->with(['product_images','reviews', 'related_products', 'category_info'])->where('slug',$slug)->first();
    }

    public function getSlug($title){
        $slug = \Str::slug($title);

        $found = $this->where('slug',$slug.".html")->count();
        if($found > 0){
            $slug .=  date('Ymdhis');
        }

        return $slug.".html";
    }
}
