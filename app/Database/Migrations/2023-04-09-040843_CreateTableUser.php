<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'   => true,
            ],

            'name' => [
                'type' => 'VARCHAR',
                'constraint'    => 100,
            ],

            'password' => [
                'type'      => 'VARCHAR',
                'constraint' => 255,
            ]
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}