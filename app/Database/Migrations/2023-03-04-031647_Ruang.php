<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ruang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'nama_ruang' => [
                'type' => 'varchar',
                'constraint' => '50',
            ],
            'nama_lantai' => [
                'type' => 'varchar',
                'constraint' => '2',
            ],
            'gedung_id' => [
                'type' => 'int',
                'constraint' => '2',
            ],
            'created_by' => [
                'type' => 'varchar',
                'constraint' => '50',
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_by' => [
                'type' => 'varchar',
                'constraint' => '50',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'deleted_by' => [
                'type' => 'varchar',
                'constraint' => '50',
                'null' => TRUE,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('gedung_id', 'gedung', 'id');
        $this->forge->createTable('ruang');
    }

    public function down()
    {
        $this->forge->dropTable('ruang');
    }
}
