<?php

namespace App\Http\Controllers;

use App\Mail\ActivateUser;
use App\User;
use Illuminate\Http\Request;
use Mail;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $user = null;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->user = $this->user->where('id', '!=', request()->user()->id)->get();
        return view('admin.user.index')
            ->with('user_data', $this->user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.form');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function registerUser(Request $request){
        $rules = $this->user->getRegisterRules();
        $request->validate($rules);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['status'] = 'inactive';
        $activation_code = \Str::random(100);
        $data['activation_code'] = $activation_code;

        $this->user->fill($data);
        $success = $this->user->save();

        Mail::to($data['email'])->send(new ActivateUser($activation_code));

        return redirect()->route('login');

    }

    public function activateUser($token){
        $this->user = $this->user->where('activation_code', $token)->first();

        // time, reclick

        if(!$this->user){
            request()->session()->flash('error','Invalid token.');
            return redirect()->route('register');
        } else {
            $data = array(
                'activation_code' => null,
                'status' => 'active'
            );
            $this->user->fill($data);
            $this->user->save();
            return redirect()->route('login');
        }
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
        $this->user = $this->user->find($id);
        if(!$this->user){
            request()->session()->flash('error','User not found');
            return redirect()->route('user.index');
        }

        return view('admin.user.form')->with('user', $this->user);
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
        $rules = $this->user->getRules();
        $request->validate($rules);

        $data = $request->all();

        if($request->change_password) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $this->user = $this->user->find($id);
        $this->user->fill($data);
        $success = $this->user->save();
        if($success){
            $request->session()->flash('success', 'User information updated successfully.');
        } else {
            $request->session()->flash('error', 'Problem while updating user.');
        }
        return redirect()->route('user.index');

    }

    public function updateAdmin(Request $request, $id){
        $request->request->add(['role' => 'admin']);
        $request->request->add(['status' => 'active']);
        $rules = $this->user->getRules();
        $request->validate($rules);

        $data = $request->all();
        if($request->change_password) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $this->user = $this->user->find($id);
        $this->user->fill($data);
        $success = $this->user->save();
        if($success){
            $request->session()->flash('success', 'User information updated successfully.');
        } else {
            $request->session()->flash('error', 'Problem while updating user.');
        }
        return redirect()->route('user.index');

    }

    public function adminProfile(){
        $this->user = $this->user->find(request()->user()->id);
        if(!$this->user){
            request()->session()->flash('error','User not found');
            return redirect()->route('user.index');
        }

        return view('admin.user.admin-form')->with('user', $this->user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->user = $this->user->find($id);
        if(!$this->user){
            request()->session()->flash('error','User not found');
            return redirect()->route('user.index');
        }

        $del = $this->user->delete();
        if($del){
            request()->session()->flash('success','User deleted successfully.');
         } else {
            request()->session()->flash('error','Problem while deleting user.');
        }
        return redirect()->route('user.index');
    }
}
