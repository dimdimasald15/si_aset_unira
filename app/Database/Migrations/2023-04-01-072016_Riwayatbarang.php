<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Riwayatbarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => true,
            ],
            'barang_id' => [
                'type' => 'int',
                'constraint' => 11,
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
                'null' => TRUE,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        // $this->forge->addForeignKey('barang_id', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_barang');
    }

    public function down()
    {
        // $this->forge->dropForeignKey('riwayat_barang', 'riwayat_barang_barang_id_foreign');
        $this->forge->dropTable('riwayat_barang');
    }
}
