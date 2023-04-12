<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'kat_id' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'kode_brg' => [
                'type' => 'varchar',
                'constraint' => 20,
            ],
            'nama_brg' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],
            'merk' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'warna' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'asal' => [
                'type' => 'varchar',
                'constraint' => 20,
                'null' => TRUE,
            ],
            'harga_beli' => [
                'type' => 'decimal',
                'constraint' => 14.2,
                'null' => TRUE,
            ],
            'harga_jual' => [
                'type' => 'decimal',
                'constraint' => 14.2,
                'null' => TRUE,
            ],
            'toko' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => TRUE,
            ],
            'instansi' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'no_seri' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'no_dokumen' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'foto_barang' => [
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE,
            ],
            'tgl_pembelian' => [
                'type' => 'date',
                'null' => TRUE,
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
        $this->forge->addForeignKey('kat_id', 'kategori', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropForeignKey('barang', 'barang_kat_id_foreign');
        $this->forge->dropTable('barang');
    }
}
