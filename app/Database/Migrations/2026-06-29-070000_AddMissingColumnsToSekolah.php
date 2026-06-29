<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingColumnsToSekolah extends Migration
{
    public function up()
    {
        // Add kepala_sekolah column if not exists
        if (! $this->db->fieldExists('kepala_sekolah', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'kepala_sekolah' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'nama_sekolah',
                ],
            ]);
        }

        // Add kontak column if not exists
        if (! $this->db->fieldExists('kontak', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'kontak' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'website',
                ],
            ]);
        }

        // Add tahun_berdiri column if not exists
        if (! $this->db->fieldExists('tahun_berdiri', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'tahun_berdiri' => [
                    'type'       => 'YEAR',
                    'null'       => true,
                    'default'    => null,
                    'after'      => 'kontak',
                ],
            ]);
        }

        // Add visi column if not exists
        if (! $this->db->fieldExists('visi', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'visi' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                    'default'    => null,
                ],
            ]);
        }

        // Add misi column if not exists
        if (! $this->db->fieldExists('misi', 'sekolah')) {
            $this->forge->addColumn('sekolah', [
                'misi' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                    'default'    => null,
                ],
            ]);
        }
    }

    public function down()
    {
        $dropFields = ['kepala_sekolah', 'kontak', 'tahun_berdiri', 'visi', 'misi'];
        foreach ($dropFields as $field) {
            if ($this->db->fieldExists($field, 'sekolah')) {
                $this->forge->dropColumn('sekolah', $field);
            }
        }
    }
}
