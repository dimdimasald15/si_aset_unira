<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'laporan_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'petugas_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'viewed_by_admin' => [
                'type' => 'int',
                'constraint' => '1',
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
        $this->forge->addForeignKey('laporan_id', 'pelaporan_kerusakan', 'id');
        $this->forge->addForeignKey('petugas_id', 'petugas', 'id');
        $this->forge->createTable('notifikasi');
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi');
    }
}
