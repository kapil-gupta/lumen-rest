<?php

namespace App\Http\Controllers;

use App\Interfaces\UserInterface as UserModel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\ResponseTrait;

class UserController extends BaseController {
	use RestControllerTrait;
	protected $model;
	public function __construct(UserModel $user) {
		parent::__construct ();
		$this->model = $user;
	}
}
