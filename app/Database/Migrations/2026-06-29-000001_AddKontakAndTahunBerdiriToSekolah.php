<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKontakAndTahunBerdiriToSekolah extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('kontak', 'sekolah')) {
            $fields = [
                'kontak' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
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
            ];
            $this->forge->addColumn('sekolah', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('kontak', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'kontak');
        }
        if ($this->db->fieldExists('tahun_berdiri', 'sekolah')) {
            $this->forge->dropColumn('sekolah', 'tahun_berdiri');
        }
    }
}
