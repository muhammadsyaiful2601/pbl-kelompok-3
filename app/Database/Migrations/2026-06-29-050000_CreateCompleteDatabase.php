<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompleteDatabase extends Migration
{
    public function up()
    {
        // Create user table
        if (! $this->db->tableExists('user')) {
            $this->forge->addField([
                'id_user' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'unique'     => true,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'nama_lengkap' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'default'    => 'admin',
                ],
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                    'default'    => null,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id_user', true);
            $this->forge->createTable('user');
        }

        // Create sekolah table
        if (! $this->db->tableExists('sekolah')) {
            $this->forge->addField([
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
                'akreditasi' => [
                    'type'       => 'ENUM',
                    'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                    'null'       => false,
                    'default'    => 'Belum Terakreditasi',
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
                'kontak' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'default'    => null,
                ],
                'tahun_berdiri' => [
                    'type'       => 'YEAR',
                    'null'       => true,
                    'default'    => null,
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
                'visi' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'default'    => null,
                ],
                'misi' => [
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
            ]);
            $this->forge->addKey('id_sekolah', true);
            $this->forge->createTable('sekolah', true);
        }

        // Create geojson table
        if (! $this->db->tableExists('geojson')) {
            $this->forge->addField([
                'id_geojson' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nama_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'file_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                ],
                'warna_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'default'    => '#3b82f6',
                ],
                'opacity_geojson' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '3,2',
                    'default'    => 0.5,
                ],
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id_geojson', true);
            $this->forge->createTable('geojson');
        }

        // Create activity_logs table
        if (! $this->db->tableExists('activity_logs')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_user' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'nama_lengkap' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                ],
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'null'       => true,
                ],
                'action' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                ],
                'target_table' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                ],
                'target_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                ],
                'description' => [
                    'type' => 'TEXT',
                ],
                'ip_address' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '45',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('id_user');
            $this->forge->createTable('activity_logs');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('activity_logs')) {
            $this->forge->dropTable('activity_logs');
        }
        if ($this->db->tableExists('geojson')) {
            $this->forge->dropTable('geojson');
        }
        if ($this->db->tableExists('sekolah')) {
            $this->forge->dropTable('sekolah');
        }
        if ($this->db->tableExists('user')) {
            $this->forge->dropTable('user');
        }
    }
}
