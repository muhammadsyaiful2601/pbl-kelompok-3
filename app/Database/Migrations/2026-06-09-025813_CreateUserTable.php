<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSekolahTable extends Migration
{
    public function up()
    {
        $fields = [
            'id_sekolah' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'nama_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => false,
            ],
            'kepala_sekolah' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
                'default'    => null,
            ],
            'jenjang' => [
                'type'       => 'ENUM',
                'constraint' => ['SD', 'SMP', 'TK'],
                'null'       => false,
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['negri', 'swasta'],
                'null'       => true,
                'default'    => null,
            ],
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => null,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'jumlah_siswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'default'    => null,
            ],
            'deskripsi_sekolah' => [
                'type' => 'TEXT',
                'null' => true,
                'default'    => null,
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => null,
            ],
            'kontak' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => null,
            ],
            'tahun_berdiri' => [
                'type'       => 'YEAR',
                'null'       => true,
                'default'    => null,
            ],
            'visi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => null,
            ],
            'misi' => [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => null,
            ],
            'latitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'longitude' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tipe_objek' => [
                'type'       => 'ENUM',
                'constraint' => ['marker', 'polygon'],
                'null'       => true,
                'default'    => 'marker',
            ],
            'koordinat_polygon' => [
                'type' => 'TEXT',
                'null' => true,
                'default'    => null,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id_sekolah', true);

        if (! $this->db->tableExists('sekolah')) {
            $this->forge->createTable('sekolah');
        }
    }

    public function down()
    {
        $this->forge->dropTable('sekolah');
    }
}
