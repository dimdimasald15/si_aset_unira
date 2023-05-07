<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Peminjaman extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'anggota_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'barang_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'jml_barang' => [
                'type' => 'int',
                'constraint' => '3',
            ],
            'jml_hari' => [
                'type' => 'int',
                'constraint' => '3',
            ],
            'kondisi_pinjam' => [
                'type' => 'varchar',
                'constraint' => '20',
                'null' => TRUE,
            ],
            'kondisi_kembali' => [
                'type' => 'varchar',
                'constraint' => '20',
                'null' => TRUE,
            ],
            'tgl_pinjam' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'tgl_kembali' => [
                'type' => 'datetime',
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
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id');
        $this->forge->addForeignKey('barang_id', 'barang', 'id');
        $this->forge->createTable('peminjaman');
    }

    public function down()
    {
        $this->forge->dropTable('peminjaman');
    }
}
