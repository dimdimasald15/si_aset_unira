<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'kd_kategori' => [
                'type' => 'varchar',
                'constraint' => 50,
            ],
            'nama_kategori' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'text',
                'null' => true,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['Barang Tetap', 'Barang Persediaan'],
                'null' => false
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
        $this->forge->createTable('kategori');
    }

    public function down()
    {
        $this->forge->dropTable('kategori');
    }
}
