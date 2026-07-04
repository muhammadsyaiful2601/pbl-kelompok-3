<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReplaceJumlahSiswaWithKurikulum extends Migration
{
    public function up()
    {
        // Add kurikulum column
        $this->forge->addColumn('sekolah', [
            'kurikulum' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'default'    => null,
                'after'      => 'akreditasi',
            ],
        ]);
        
        // Drop jumlah_siswa column
        $this->forge->dropColumn('sekolah', ['jumlah_siswa']);
    }

    public function down()
    {
        // Add back jumlah_siswa
        $this->forge->addColumn('sekolah', [
            'jumlah_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
                'after'      => 'kategori',
            ],
        ]);
        
        // Drop kurikulum
        $this->forge->dropColumn('sekolah', ['kurikulum']);
    }
}