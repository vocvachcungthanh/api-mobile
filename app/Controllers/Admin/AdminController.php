<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class AdminController extends BaseController {
    public function index() {

        $data = [];
       
        $data =  $this->loadMasterLayout($data,'Trang chủ',"admin/pages/dashboards/index");
       
        return view('admin/index', $data);
    }
}