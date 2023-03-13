<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Petugas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'nip' => [
                'type' => 'varchar',
                'constraint' => '20',
                'unique' => TRUE,
            ],
            'email' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'password' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'role' => [
                'type' => 'varchar',
                'constraint' => '50',
            ],
            'created_by' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_by' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_by' => [
                'type' => 'varchar',
                'constraint' => '100',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('petugas');
    }

    public function down()
    {
        $this->forge->dropTable('petugas');
    }
}
