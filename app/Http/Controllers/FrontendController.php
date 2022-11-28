<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use Mail;
use App\Models\Banner;
use App\Models\Product;

class FrontendController extends Controller
{
    protected $banner = null;
    protected $category = null;
    protected $product = null;

    public function __construct(Banner $banner, Category $category, Product $product){
        $this->banner = $banner;
        $this->category = $category;
        $this->product = $product;

    }

    public function index(){
        $this->banner = $this->banner->where('status','active')->orderBy('id','DESC')->limit(5)->get();
        $this->category = $this->category->where('status','active')->where('is_parent',1)->orderBy('title', 'ASC')->limit(8)->get();
        $this->product = $this->product->getAllProducts(true);
        return view('home.index')
            ->with('banner', $this->banner)
            ->with('category', $this->category)
            ->with('products', $this->product);
    }

    public function submitFeedback(Request $request){
        //
        Mail::to('admin@ecommerce.com')->send(new Contact($request->all()));

        $request->session()->flash('status','Mail send');
        return redirect()->route('contact-us');
    }
}
