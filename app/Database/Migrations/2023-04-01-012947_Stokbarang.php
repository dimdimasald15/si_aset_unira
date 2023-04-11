<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stokbarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'auto_increment' => TRUE,
            ],
            'barang_id' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'satuan_id' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'ruang_id' => [
                'type' => 'int',
                'constraint' => 11,
            ],
            'jumlah_masuk' => [
                'type' => 'bigint',
                'default' => 0,
                'unsigned' => TRUE, // Ditambahkan unsigned agar nilai selalu positif
            ],
            'jumlah_keluar' => [
                'type' => 'bigint',
                'default' => 0,
                'unsigned' => TRUE, // Ditambahkan unsigned agar nilai selalu positif
            ],
            'sisa_stok' => [
                'type' => 'bigint',
                'default' => 0,
                'unsigned' => TRUE, // Ditambahkan unsigned agar nilai selalu positif 
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
        $this->forge->addForeignKey('barang_id', 'barang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('ruang_id', 'ruang', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('satuan_id', 'satuan', 'id');
        $this->forge->createTable('stok_barang');

        // Menambahkan trigger untuk menghitung nilai sisa_stok
        $this->db->query("
            CREATE TRIGGER `trigger_stok_barang`
            BEFORE INSERT ON `stok_barang`
            FOR EACH ROW BEGIN
                SET NEW.sisa_stok = (
                    SELECT COALESCE(SUM(jumlah_masuk), 0) - COALESCE(SUM(jumlah_keluar), 0) 
                    FROM stok_barang
                    WHERE barang_id = NEW.barang_id
                );
            END
        ");
    }

    public function down()
    {
        // Menghapus trigger sebelum menghapus tabel
        $this->db->query("
            DROP TRIGGER IF EXISTS `trigger_stok_barang`
        ");
        $this->forge->dropForeignKey('stok_barang', 'stok_barang_barang_id_foreign');
        $this->forge->dropForeignKey('stok_barang', 'stok_barang_ruang_id_foreign');
        $this->forge->dropForeignKey('stok_barang', 'stok_barang_satuan_id_foreign');
        $this->forge->dropTable('stok_barang');
    }
}