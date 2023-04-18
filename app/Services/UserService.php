<?php
namespace App\Services;
use App\Models\UserModel;
use App\Common\ResultUtils;
use Exception;

class UserService extends BaseService {

    private $users;
 

    /**
     * Construct
     */
   public function __construct(){
        parent:: __construct();

        $this->users = new UserModel();
        $this->users->protect(false);
       
    }

    /**
     *  lấy tất cả users
     */

     public function getAllUsers(){
        return $this->users->findAll();
     }

     /**
      * Thếm mới users
      */

    public function insertUsers($requestData){
      $validate = $this->validateAddUser($requestData);

      if($validate->getErrors()){
          return [
            'status'      => ResultUtils::STATUS_CODE_ERR,
            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
            'messages'    => $validate->getErrors()
          ];
      }

     $dataSave = $requestData->getPost();
     $dataSave['password'] = password_hash($dataSave['password'], PASSWORD_BCRYPT);
     unset($dataSave['password_confirm']);
   
     try{
      $this->users->save($dataSave);
      
      return [
        'status'      => ResultUtils::STATUS_CODE_OK,
        'messageCode' => ResultUtils::MESSAGE_CODE_OK,
        'messages'    => ['success' => 'Thêm dữ liệu thành công']
      ];
     } catch(Exception $error){
        return [
          'status'      => ResultUtils::STATUS_CODE_ERR,
          'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
          'messages'    => ['errors' => $error->getMessage()]
        ];
     }
    }

    /**
     * Lấy user theo user_id
     */

    public function getUserByID($userID){

      return $this->users->where('user_id', $userID)->first();
    }

    /**
     * Sửa thông tin của user
     */

    public function updateUserInfo($requestData){
      $validate = $this->validateEditUser($requestData);

      if($validate->getErrors()){
          return [
            'status'      => ResultUtils::STATUS_CODE_ERR,
            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
            'messages'    => $validate->getErrors()
          ];
      }

      $dataSave = $requestData->getPost();

      if(!empty($dataSave['change_password'])){
          unset($dataSave['change_password']);
          unset($dataSave['password_confirm']);

          $dataSave['password'] = password_hash($dataSave['password'], PASSWORD_BCRYPT);
      } else {
        unset($dataSave['password']);
        unset($dataSave['password_confirm']);
      }


      try{

        $this->users->save($dataSave);
        
        return [
          'status'      => ResultUtils::STATUS_CODE_OK,
          'messageCode' => ResultUtils::MESSAGE_CODE_OK,
          'messages'    => ['success' => 'Cập nhật dữ liệu thành công']
        ];
       } catch(Exception $error){
          return [
            'status'      => ResultUtils::STATUS_CODE_ERR,
            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
            'messages'    => ['errors' => $error->getMessage()]
          ];
       }
    }


    /**
     * Xoa user
     */

    public function deleteUser($userID){
      try{

        $this->users->delete($userID);
        
        return [
          'status'      => ResultUtils::STATUS_CODE_OK,
          'messageCode' => ResultUtils::MESSAGE_CODE_OK,
          'messages'    => ['success' => 'Xoá dữ liệu thành công']
        ];
       } catch(Exception $error){
          return [
            'status'      => ResultUtils::STATUS_CODE_ERR,
            'messageCode' => ResultUtils::MESSAGE_CODE_ERR,
            'messages'    => ['errors' => $error->getMessage()]
          ];
       }
    }


    public function validateAddUser($requestData){
      $rule = [
        'email' => 'valid_email|is_unique[users.email]',
        'name'  => 'max_length[100]',
        'password' => 'max_length[30]|min_length[6]',
        'password_confirm' => 'matches[password]'

      ];
      
      $messages = [
        'email' => [
          'valid_email' => 'Tài khoản {field} {value} không đúng định dạng!',
          'is_unique' => 'Email đã được đăng ký, vui lòng kiểm tra lại!'
        ],

        'name' => [
          'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự',
        ],

        'password' => [
          'max_length' => 'Mật khẩu quá dài, vui lòng nhập {param} ký tự',
          'min_length' => 'Mật khẩu ít nhất {param} ký tự',
        ],

        'password_confirm' => [
          'matches' => 'Mật khẩu không khớp, vui lòng kiểm tra lại',
        ]
      ];

      $this->validation->setRules($rule, $messages);
      $this->validation->withRequest($requestData)->run();

      return $this->validation;
    }
    

    public function validateEditUser($requestData){
      $rule = [
        'email' => 'valid_email|is_unique[users.email,user_id,'.$requestData->getPost()['user_id'].']',
        'name'  => 'max_length[100]',

      ];
      
      $messages = [
        'email' => [
          'valid_email' => 'Tài khoản {field} {value} không đúng định dạng!',
          'is_unique' => 'Email đã được đăng ký, vui lòng kiểm tra lại!',
        ],

        'name' => [
          'max_length' => 'Tên quá dài, vui lòng nhập {param} ký tự',
        ]
      ];

      if(!empty($requestData->getPost()['change_password'])){
       
        $rule['password'] = 'max_length[30]|min_length[6]';
        $rule['password_confirm'] = 'matches[password]';

        $messages['passsword'] = [
            'max_length' => 'Mật khẩu quá dài, vui lòng nhập {param} ký tự',
             'min_length' => 'Mật khẩu ít nhất {param} ký tự',
        ];
  
        $messages['passsword_confirm'] = [
             'matches' => 'Mật khẩu không khớp, vui lòng kiểm tra lại',
        
        ];
      }

      $this->validation->setRules($rule, $messages);
      $this->validation->withRequest($requestData)->run();

      return $this->validation;
    }
}