<?php
namespace App\Repositories;
use App\Interfaces\UserInterface;
class UserRepository extends BaseRepository implements UserInterface 
{

    protected $modelName = 'App\\Models\\User';
    public function rules($id=null){
    	if($id){
    		$email_rule  = ['required', 'min:5','unique:users,email,'.$id];
    	}else{
    		$email_rule  = ['required', 'min:5','unique:users,email'];
    	}
        return [
                    'first_name' => ['required', 'min:5'],
                    'last_name' => ['required', 'min:5'],
                    'email' => $email_rule,
                    'password' => ['required', 'min:8'],
                    'birthdate' => ['required','date','date_format:Y-m-d'],
                    'contact' => ['required'],
                    //'biography' => ['required', 'min:5'],
                    'address1' => ['required', 'min:5'],
                    'address2' => ['required', 'min:5']

               ];
    }
    public function messages(){
        return [
            'address1.required' => 'Please enter Address line 1',
            'address1.min' =>'Address 1 should be greater then 5 characters',
            'address2.required' => 'Please enter Address line 2',
            'address2.min' =>'Address 2should be greater then 5 characters',
        ];
    }
}