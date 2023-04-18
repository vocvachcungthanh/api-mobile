<?php
namespace App\Controllers\Admin\Users;
use App\Controllers\BaseController;
use App\Services\UserService;

class UserController extends BaseController {

    /**
     * @var Service
     */

    private $service;

    public function __construct(){
        $this->service = new UserService();
    }


    public function index(){
        $data = [];
        
        $data['filesCss'] = ['https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'];
        $data['filesJs'] = ['http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js', 'assets_admin/js/datatable.js', 'assets_admin/js/event.js'];

        $dataPage['users'] = $this->service->getAllUsers();

        $data = $this->loadMasterLayout($data, 'Danh sách tài khoản', 'admin/pages/users/index', $dataPage);
        
        return view('admin/index', $data);
    }


    public function addUser(){
        $data = [];

        $data = $this->loadMasterLayout($data, 'Thêm mới tài khoản', 'admin/pages/users/add');
        return view('admin/index', $data);
    }

    public function createUser(){
        $result = $this->service->insertUsers($this->request);

        return redirect()->back()->withInput()->with($result['messageCode'], $result['messages']);
    }

    public function editUser($userID){

        $user = $this->service->getUserByID($userID);

        if(!$user){
            return redirect('error/404');
        }

        $data = [];
        $data['filesJs'] = ['assets_admin/js/event.js'];
        $dataPage['user'] = $user;
        $data = $this->loadMasterLayout($data, 'Sửa tài khoản', 'admin/pages/users/edit', $dataPage);

        return view('admin/index', $data);
    }

    public function updateUser(){
        $result = $this->service->updateUserInfo($this->request);

        return redirect()->back()->withInput()->with($result['messageCode'], $result['messages']);
    }

    public function deleteUser($userID){
        $user = $this->service->getUserByID($userID);

        if(!$user){
            return redirect('error/404');
        }

        $result = $this->service->deleteUser($userID);

        return redirect('admin/user')->with($result['messageCode'], $result['messages']);
    }
}