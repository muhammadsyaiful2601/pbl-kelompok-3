<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingColumnsToSekolahTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sekolah', [
            'kepala_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
                'default'    => null,
                'after'      => 'nama_sekolah',
            ],
            'kontak' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
                'after'      => 'website',
            ],
            'tahun_berdiri' => [
                'type'       => 'YEAR',
                'null'       => true,
                'default'    => null,
                'after'      => 'kontak',
            ],
            'visi' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
            ],
            'misi' => [
                'type'    => 'TEXT',
                'null'    => true,
                'default' => null,
            ],

        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sekolah', ['kepala_sekolah', 'kontak', 'tahun_berdiri', 'visi', 'misi']);
    }
}
