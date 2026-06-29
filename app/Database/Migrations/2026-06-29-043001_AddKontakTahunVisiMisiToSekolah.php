<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKontakTahunVisiMisiToSekolah extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('kontak', 'sekolah')) {
            $fields['kontak'] = [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'default'    => null,
            ];
        }

        if (! $this->db->fieldExists('tahun_berdiri', 'sekolah')) {
            $fields['tahun_berdiri'] = [
                'type'       => 'YEAR',
                'null'       => true,
                'default'    => null,
            ];
        }

        if (! $this->db->fieldExists('visi', 'sekolah')) {
            $fields['visi'] = [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => null,
            ];
        }

        if (! $this->db->fieldExists('misi', 'sekolah')) {
            $fields['misi'] = [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => null,
            ];
        }

        if (! empty($fields)) {
            $this->forge->addColumn('sekolah', $fields);
        }
    }

    public function down()
    {
        $dropFields = ['kontak', 'tahun_berdiri', 'visi', 'misi'];
        foreach ($dropFields as $field) {
            if ($this->db->fieldExists($field, 'sekolah')) {
                $this->forge->dropColumn('sekolah', $field);
            }
        }
    }
}
