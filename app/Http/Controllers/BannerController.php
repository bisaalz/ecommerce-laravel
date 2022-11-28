<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $banner = null;

    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->banner = $this->banner->get();   // SELECT * FROM banners

        return view('admin.banner.index')
            ->with('banner_data', $this->banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banner.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->banner->getRules();
        $request->validate($rules);

        $data = $request->all();
        $data['added_by'] = $request->user()->id;

        if($request->image){
            $file_name = uploadImage($request->image, "banners");
            if($file_name){
                $data['image'] = $file_name;
            } else {
                $data['image'] = null;
            }
        }

        $this->banner->fill($data);
        $success = $this->banner->save();
        if($success){
            $request->session()->flash('success','Banner added successfully.');
        } else {
            $request->session()->flash('error','Problem while adding banner.');
        }
        return redirect()->route('banner.index');
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
        $this->banner = $this->banner->find($id);
        if(!$this->banner){
            request()->session()->flash('error','Banner not found');
            return redirect()->route('banner.index');
        }

        return view('admin.banner.form')->with('banner', $this->banner);
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
        $rules = $this->banner->getRules('update');
        $request->validate($rules);

        $data = $request->all();
        $this->banner = $this->banner->find($id);

        if($request->image){
            $file_name = uploadImage($request->image, "banners");
            if($file_name){
                $data['image'] = $file_name;

                if(file_exists(public_path().'/uploads/banners/'.$this->banner->image)){
                    unlink(public_path().'/uploads/banners/'.$this->banner->image);
                }
            }
        }

        $this->banner->fill($data);
        $success = $this->banner->save();
        if($success){
            $request->session()->flash('success','Banner updated successfully.');
        } else {
            $request->session()->flash('error','Problem while updating banner.');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->banner = $this->banner->find($id);   // SELECT * FROM banners WHERE id = $id
        if(!$this->banner){
            request()->session()->flash('error','Banner not found');
            return redirect()->route('banner.index');
        }

        $image = $this->banner->image;
        $del = $this->banner->delete();
        if($del){
            // image
            if(!empty($image) && file_exists(public_path().'/uploads/banners/'.$image)){
                unlink(public_path().'/uploads/banners/'.$image);
            }
            request()->session()->flash('success','Banner Deleted successfully');
        }else {
            request()->session()->flash('error','Problem while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
