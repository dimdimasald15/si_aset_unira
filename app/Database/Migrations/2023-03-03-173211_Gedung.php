<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gedung extends Migration
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
            'nama_gedung' => [
                'type' => 'varchar',
                'constraint' => 50,
            ],
            'prefix' => [
                'type' => 'varchar',
                'constraint' => 20,
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
        $this->forge->createTable('gedung');
    }

    public function down()
    {
        $this->forge->dropForeignKey('gedung', 'gedung_kat_id_foreign');
        $this->forge->dropTable('gedung');
    }
}
