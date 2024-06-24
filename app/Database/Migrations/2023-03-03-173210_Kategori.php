<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration
{
    public function up()
    {
        // Membuat tipe data ENUM untuk PostgreSQL
        $this->db->query("CREATE TYPE jenis_enum AS ENUM ('Barang Tetap', 'Barang Persediaan')");

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
                'type' => "jenis_enum",
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

         // Menghapus tipe data ENUM setelah tabel dihapus
         $this->db->query("DROP TYPE jenis_enum");
    }
}
