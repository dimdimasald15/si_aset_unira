<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Anggota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'no_anggota' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'nama_anggota' => [
                'type' => 'varchar',
                'constraint' => '100',
            ],
            'no_hp' => [
                'type' => 'varchar',
                'constraint' => '20',
            ],
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['Karyawan', 'Mahasiswa'],
                'null' => false
            ],
            'unit_id' => [
                'type' => 'int',
                'constraint' => '11',
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
        $this->forge->addForeignKey('unit_id', 'unit', 'id');
        $this->forge->createTable('anggota');
    }

    public function down()
    {
        $this->forge->dropTable('anggota');
    }
}
