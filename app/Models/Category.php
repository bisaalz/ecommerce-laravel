<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title','slug','summary','image','status','is_parent','parent_id','added_by'];
    public function getValidationRules(){
        return [
            'title' => 'required|string',
            'summary' => 'nullable|string',
            'image' => 'sometimes|image|max:5000',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id'
        ];
    }

    public function getAllParents(){
        return $this->where('is_parent', 1)->orderBy('title','ASC')->get();
    }

    public function parent_info(){
        return $this->hasOne('App\Models\Category', 'id', 'parent_id');
    }

    public function getChildCategoriesId($parent_id){
        return $this->where('parent_id', $parent_id)->pluck('id');    // SELECT id FROM categories WHERE parent_id = $parent_id
    }

    public function getAllCategories(){
        return $this->with('parent_info')->orderBy('id','DESC')->get();
    }

    public function child_cats(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }

    public function getCategories(){
        return $this->with('child_cats')->where('is_parent',1)->where('status','active')->get();
    }

    public function shiftChildToParent($ids){
        $data = array(
            'is_parent' => 1
        );
        return $this->whereIn('id', $ids)->update($data);    // UPDATE categories SET is_parent = 1 WHERE id IN
    }


    public function getAllChildCategoriesFromParent($id){
        return $this->where('parent_id', $id)->orderBy('title','ASC')->get();
    }

    public function getSlug($title){
        $slug = \Str::slug($title);

        $found = $this->where('slug',$slug.".html")->count();

        if($found  > 0){
            $slug .= date('Ymdhis');
        }

        return $slug.".html";

    }
}
