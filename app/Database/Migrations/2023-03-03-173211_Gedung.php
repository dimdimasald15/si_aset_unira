<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gedung extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE,
                'unsigned' => TRUE,
            ],
            'kat_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'nama_gedung' => [
                'type' => 'varchar',
                'constraint' => 20,
            ],
            'prefix' => [
                'type' => 'varchar',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => TRUE,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('gedung');
    }

    public function down()
    {
        $this->forge->dropTable('gedung');
    }
}
