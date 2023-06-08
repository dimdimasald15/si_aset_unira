<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelaporan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'stokbrg_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'anggota_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'no_laporan' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'jml_barang' => [
                'type' => 'int',
                'constraint' => '5',
            ],
            'title' => [
                'type' => 'varchar',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'text',
                'null' => TRUE,
            ],
            'foto' => [
                'type' => 'varchar',
                'constraint' => '255',
                'null' => TRUE,
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
        $this->forge->addForeignKey('stokbrg_id', 'stok_barang', 'id');
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id');
        $this->forge->createTable('pelaporan_kerusakan');
    }

    public function down()
    {
        $this->forge->dropTable('pelaporan_kerusakan');
    }
}
