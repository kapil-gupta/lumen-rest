<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

trait RestControllerTrait {
	public function index(Request $request) {
		try {
			$model = $this->model;
			$params = $request->all ();
			return $this->listResponse ( $model->all ( $params ) );
		} catch ( \Exception $e ) {
			
			$data = [ 
					'errorMessage' => $e->getMessage () 
			]
			// 'errorLine' => $e->getLine(),
			// 'errorFile' => $e->getFile(),
			// 'errorTrace' => $e->getTraceAsString()
			;
			return $this->serverErrorResponse ( $data );
		}
	}
	public function show($id) {
		$model = $this->model;
		if ($data = $model::find ( $id )) {
			return $this->showResponse ( $data );
		}
		return $this->notFoundResponse ();
	}
	public function store(Request $request) {
		$model = $this->model;
		try {
			$v = \Validator::make ( $request->all (), $model->rules (), $model->messages () );
			
			if ($v->fails ()) {
				throw new \Exception ( "ValidationException" );
			}
			$data = $model->store ( $request->all () );
			return $this->createdResponse ( $data );
		} catch ( \Exception $ex ) {
			$data = [ 
					'form_validations' => $v->errors (),
					'exception' => $ex->getMessage () 
			];
			return $this->clientErrorResponse ( $data );
		}
	}
	public function update(Request $request, $id) {
		$model = $this->model;
		
		if (! $data = $model->find ( $id )) {
			return $this->notFoundResponse ();
		}
		
		try {
			$v = \Validator::make ( $request->all (), $model->rules (), $model->messages () );
			if ($v->fails ()) {
				throw new \Exception ( "ValidationException" );
			}
			$data->fill ( $request->all () );
			$data->save ();
			return $this->showResponse ( $data );
		} catch ( \Exception $ex ) {
			$data = [ 
					'form_validations' => $v->errors (),
					'exception' => $ex->getMessage () 
			];
			return $this->clientErrorResponse ( $data );
		}
	}
	public function destroy($id) {
		$model = $this->model;
		if (! $data = $model->find ( $id )) {
			return $this->notFoundResponse ();
		}
		$data->delete();
		return $this->deletedResponse ();
	}
	protected function createdResponse($data) {
		$response = [ 
				'code' => 201,
				'status' => true,
				'data' => $data 
		];
		
		return $this->sendResponse ( $response );
	}
	protected function showResponse($data) {
		$response = [ 
				'code' => 200,
				'status' => true,
				'data' => $data 
		];
		return $this->sendResponse ( $response );
	}
	protected function listResponse($data) {
		$response = [ 
				'code' => 200,
				'status' => true,
				'data' => $data 
		];
		return $this->sendResponse ( $response, [ 
				'X-Total-Count' => $data ['total'] 
		] );
	}
	protected function notFoundResponse() {
		$response = [ 
				'code' => 404,
				'status' => false,
				'data' => 'Resource Not Found',
				'message' => 'Not Found' 
		];
		return $this->sendResponse ( $response );
	}
	protected function deletedResponse() {
		$response = [ 
				'code' => 204,
				'status' => 'success',
				'data' => [ ],
				'message' => 'Resource deleted' 
		];
		return $this->sendResponse ( $response );
	}
	protected function clientErrorResponse($data) {
		$response = [ 
				'code' => 422,
				'status' => false,
				'data' => $data,
				'message' => 'Unprocessable entity' 
		];
		return $this->sendResponse ( $response );
	}
	protected function serverErrorResponse($data) {
		$response = [ 
				'code' => 500,
				'status' => false,
				'data' => $data,
				'message' => 'Some unkonwn error occured' 
		];
		return $this->sendResponse ( $response );
	}
	protected function sendResponse($response, $addtional_headers = []) {
		$res = new JsonResponse ( $response, $response ['code'], array_merge ( [ 
				'Content-Type' => 'application/json' 
		], $addtional_headers ), 1 );
		$res->setJsonOptions ( JSON_PRETTY_PRINT );
		return $res;
	}
}