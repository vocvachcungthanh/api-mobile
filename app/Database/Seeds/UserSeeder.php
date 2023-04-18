<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email'      => 'admin@gmail.com',
                'password'  => password_hash('123', PASSWORD_BCRYPT),
                'name'      => "Tài khoản quản trị"
            ],

            [
                'email'      => 'user@gmail.com',
                'password'  => password_hash('123', PASSWORD_BCRYPT),
                'name'      => "Tài khoản người dùng"
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}