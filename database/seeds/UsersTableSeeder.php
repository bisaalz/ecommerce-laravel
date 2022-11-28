<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            array(
                'name' => 'Admin Ecommerce',
                'email' => 'admin@ecommerce.loc',
                'password' => Hash::make('admin234'),
                'role' => 'admin',
                'status' => 'active'
            ),
            array(
                'name' => 'Ecommerce Admin',
                'email' => 'ecommerceadmin@ecommerce.loc',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'status' => 'active'
            ),
            array(
                'name' => 'Vendor Ecommerce',
                'email' => 'vendor@ecommerce.loc',
                'password' => Hash::make('vendor123'),
                'role' => 'vendor',
                'status' => 'active'
            ),
            array(
                'name' => 'User Ecommerce',
                'email' => 'customer@ecommerce.loc',
                'password' => Hash::make('customer123'),
                'role' => 'customer',
                'status' => 'active'
            )
        );
        foreach($array as $user_info){

            $user = new User();

            $user = $user->where('email',$user_info['email'])->first(); // null or object
            if(!$user){
                $user = new User();
            }
            $user->fill($user_info);

            $user->save();
        }
        // DB::table('users')->insert($array);
    }
}
