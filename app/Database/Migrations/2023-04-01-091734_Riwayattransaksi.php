<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Riwayattransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'stokbrg_id' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'jenis_transaksi' => [
                'type' => 'varchar',
                'constraint' => 50,
            ],
            'field' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'old_value' => [
                'type' => 'text',
                'null' => true,
            ],
            'new_value' => [
                'type' => 'text',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'varchar',
                'constraint' => 50,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        // $this->forge->createTable('riwayat_transaksi');
        $this->forge->addPrimaryKey('id');
        // $this->forge->addForeignKey('stokbrg_id', 'stok_barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_transaksi');
    }

    public function down()
    {
        // $this->forge->dropForeignKey('riwayat_transaksi', 'riwayat_transaksi_stokbrg_id_foreign');
        $this->forge->dropTable('riwayat_transaksi');
    }
}
