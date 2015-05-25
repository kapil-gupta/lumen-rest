<?php
namespace App\Repositories;

class BaseRepository
{

    protected $modelName;
	protected $limit = 25;
	protected $page = 1;
    public function all($params = array())
    {
    	$instance = $this->getNewInstance();
    	$query = $instance;
    	
    	if(isset($params['search'])){
    		$query = $instance->where('first_name', 'like', '%'.$params['search'].'%')->orWhere('first_name', 'like', '%'.$params['search'].'%');
    	}
    	if(isset($params['page'])){
    		$this->page=$params['page'];
    	}
    	if(isset($params['limit'])){
    		$this->limit=$params['limit'];
    	}
    	if(isset($params['sort'])){
    		 $temp = explode(',',$params['sort']);
    		 foreach($temp as $field){
    		 	$order='ASC';
    		 	$orderSign = substr($field,0,1);
    		 	$field = substr($field,1);
    		 	if('-'==$orderSign){
    		 		$order = 'DESC';
    		 	}
    		 	$query=$query->orderBy($field,$order);
    		 }
    	}
    	
    	$result             			 = [];
    	$result['page']      			 = $this->page;
    	$result['limit']     			 = $this->limit;
    	$result['total']	 			 = $query->count();
    	$result['total_pages']   	     = ceil($result['total']/$result['limit']);
    	
    	$query = $query->skip($this->limit * ($this->page - 1))->take($this->limit);
    	
    	
    	$result['items']      = $query->get();
    	
    	return $result;
    	 
    }

    public function find($id, $relations = [])
    {
        $instance = $this->getNewInstance();
        return $instance->find($id);
    }

    protected function getNewInstance()
    {
        $model = $this->modelName;
        return new $model();
    }
    public function create($data){
    	$instance = $this->getNewInstance();
    	$result = $instance->create($data);
    	return $result;
    }
    public function update($id,$data = array()){
    	$model	=	$this->find($id);
    	$model->fill($data);
    	$model->save();
    	return $model;
    }
    public function delete($id){
    	$model	=	$this->find($id);
    	$model->delete();
    }
}