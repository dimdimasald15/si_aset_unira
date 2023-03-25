<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Permintaan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => '11',
                'auto_increment' => TRUE,
            ],
            'barang_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'unit_id' => [
                'type' => 'int',
                'constraint' => '11',
            ],
            'nama_peminta' => [
                'type' => 'varchar',
                'constraint' => '50',
            ],
            'jml_barang' => [
                'type' => 'int',
                'constraint' => '3',
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
        $this->forge->addForeignKey('barang_id', 'barang', 'id');
        $this->forge->addForeignKey('unit_id', 'unit', 'id');
        $this->forge->createTable('permintaan');
    }

    public function down()
    {
        $this->forge->dropTable('permintaan');
    }
}
