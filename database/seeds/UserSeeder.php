<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $user = app()->make('App\Models\User');
        $hasher = app()->make('hash');

        $user->fill([
            'first_name' => 'Kapil',
            'last_name'=>'Gupta',
            'email' => 'user@user.com',
        	'birthdate'=>'1985-11-10',
        	'biography'=>'text',
        	'address1'=>'text',
        	'address2'=>'text',
        	'contact'=>'7498671498',
            'password' => $hasher->make('password')
        ]); 
        $user->save();
    }

}

?>