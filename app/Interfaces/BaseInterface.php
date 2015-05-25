<?php
namespace App\Interfaces;

interface BaseInterface
{

    public function all();
    
    // public function paginate($count);
    public function find($id);
    
    public function rules();
    public function messages();
    public function store($data);
    
    // public function update($id, $data);
    
    // public function delete($id);
    
    // public function findBy($field, $value);
}