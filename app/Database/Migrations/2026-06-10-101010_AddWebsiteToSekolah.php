<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWebsiteToSekolah extends Migration
{
    public function up()
    {
        $fields = [
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'deskripsi_sekolah',
            ],
        ];

        $this->forge->addColumn('sekolah', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('sekolah', 'website');
    }
}
