<?php
namespace App\Interfaces;

interface BaseInterface
{

    public function all();
    
    // public function paginate($count);
    public function find($id);
    
    public function rules($id);
    public function messages();
    public function create($data);
    public function update($id, $data);
    public function delete($id);
    
    // public function findBy($field, $value);
}