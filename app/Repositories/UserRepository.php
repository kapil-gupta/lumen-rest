<?php
namespace App\Repositories;
use App\Interfaces\UserInterface;
class UserRepository extends BaseRepository implements UserInterface 
{

    protected $modelName = 'App\\Models\\User';
    public function rules(){
        return [
                    'first_name' => ['required', 'min:5'],
                    'last_name' => ['required', 'min:5'],
                    'email' => ['required', 'min:5','unique'],
                    'password' => ['required', 'min:5'],
                    'birthdate' => ['required', 'min:5'],
                    'contact' => ['required', 'min:5'],
                    'biography' => ['required', 'min:5'],
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