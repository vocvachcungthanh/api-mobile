<?php
namespace App\Controllers\Api\Users;
use CodeIgniter\RESTful\ResourceController;
use App\Services\UserService;

class UserController extends ResourceController {

    /**
     * @var Service
     */

    private $service;
    

    protected $format = 'json';

    public function __construct(){
        $this->service = new UserService();
    }


    public function index(){

        $dataUser= $this->service->getAllUsers();

        $data = [
            'message' => 'success',
            'data' => $dataUser
        ];
        
       return  $this->respond($data,200);
    }
}