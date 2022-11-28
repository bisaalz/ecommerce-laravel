<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
class CartController extends Controller
{

    protected  $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function removeFromCart(Request $request){
        $cart_index = $request->cart_index;
        $quantity = $request->quantity;

        $cart = session('cart');

        unset($cart[$cart_index]);  // cart_index => product, delete

        /*$cart[$cart_index]['quantity'] -= $quantity;
        if($cart[$cart_index]['quantity'] <= 0){
            unset($cart[$cart_index]);  // cart_index => product, delete
        } else {
            $cart[$cart_index]['amount'] = $cart[$cart_index]['quantity']*$cart[$cart_index]['price'];
        }*/

        $request->session()->put('cart', $cart);
        return response()->json(['data'=>$cart,'status'=> true, 'msg'=>"Cart Updated successfully."]);
    }

    public function showCartList(){
        return view('home.cart-list');
    }


    public function checkout(Request $request){
        //dd(session('cart'));

        $cart = session('cart');
        $cart_id = \Str::random(15);

        foreach($cart as $order_items){
            $order = new Order();
            $order->cart_id = $cart_id;
            $order->product_id = $order_items['id'];
            $order->user_id = $request->user()->id;
            $order->quantity = $order_items['quantity'];
            $order->amount = $order_items['amount'];
            $order->status = 'new';

            $order->save();
        }

        $request->session()->forget('cart');    // delete cart form session

        $request->session()->flash('success', "Thank you for your order.<br> we have received your order. You will be shortly notified about the order status.");
        return redirect()->route('home');
    }
    public function postCart(Request $request){
        $this->product = $this->product->find($request->product_id);

        if(!$this->product){
            return response()->json(['data'=>null, 'status'=>false, 'msg'=>'Invalid Product Id']);
        }

        $current_product = array(
            'id' => $this->product->id,
            'title' => $this->product->title,
            'image' => asset('uploads/product/'.$this->product->image),
            'url' => route('product-detail',$this->product->slug),
            'org_price' => $this->product->price
        );

        $price = $this->product->price;
        if($this->product->discount > 0){
            $price = $price-(($price*$this->product->discount)/100);
        }
        $current_product['price'] = $price;



        $current_product['quantity'] = $request->quantity;
        $current_product['amount'] = $request->quantity*$price;



        $cart = session('cart') ? session('cart') : array();

        if(!empty($cart)){
            // already product exists in cart

            $index = null;

            foreach($cart as $key => $cart_items){
                if($cart_items['id'] == $this->product->id){
                    $index = $key;
                    break;
                }
            }

            if($index === null){
                // product not exists
                $cart[] = $current_product;
            } else {
                // exists
                $cart[$index]['quantity'] += $request->quantity;
                $cart[$index]['amount'] = $cart[$index]['quantity'] * $price;
            }


        } else {
            // new product in cart
            $cart[] = $current_product;
        }

        // session('cart',$cart);


        $request->session()->put('cart', $cart);

        return response()->json(['data'=>$cart, 'status'=>true, 'msg'=> $this->product->title.' Added in the cart.']);
    }
}
