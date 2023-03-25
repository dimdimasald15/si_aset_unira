<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Unit extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'nama_unit' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'singkatan' => [
                'type' => 'varchar',
                'constraint' => 20,
            ],
            'deskripsi' => [
                'type' => 'text',
            ],
            'kategori_unit' => [
                'type' => 'varchar',
                'constraint' => 50,
            ],
            'created_by' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_by' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_by' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('unit');
    }

    public function down()
    {
        $this->forge->dropTable('unit');
    }
}
