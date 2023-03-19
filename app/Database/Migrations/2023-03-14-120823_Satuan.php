<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'kd_satuan' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'nama_satuan' => [
                'type' => 'varchar',
                'constraint' => 20,
            ],
            'deskripsi' => [
                'type' => 'varchar',
                'constraint' => 100,
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
        $this->forge->addKey('id', true);
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}
