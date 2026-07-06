<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Consolidated migration for all database changes
 * This file creates all tables from scratch for hosting
 */
class ConsolidatedMigrations extends Migration
{
    public function up()
    {
        // ==================== USER TABLE ====================
        if (!$this->db->tableExists('user')) {
            $this->forge->addField([
                'id_user' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => false
                ],
                'nama_lengkap' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ],
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['superadmin', 'admin'],
                    'null' => false,
                    'default' => 'admin'
                ],
                'foto' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true
                ],
            ]);
            $this->forge->addKey('id_user', true);
            $this->forge->addUniqueKey('username');
            $this->forge->createTable('user', true, ['ENGINE' => 'MyISAM']);
        }

        // ==================== SEKOLAH TABLE ====================
        if (!$this->db->tableExists('sekolah')) {
            $this->forge->addField([
                'id_sekolah' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true
                ],
                'nama_sekolah' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ],
                'npsn' => [
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'null' => true
                ],
                'jenjang' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'kategori' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ],
                'foto' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true
                ],
                'alamat' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'kurikulum' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ],
                'deskripsi_sekolah' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'website' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true
                ],
                'latitude' => [
                    'type' => 'DECIMAL',
                    'constraint' => '10,8',
                    'null' => true
                ],
                'longitude' => [
                    'type' => 'DECIMAL',
                    'constraint' => '11,8',
                    'null' => true
                ],
                'tipe_objek' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'koordinat_polygon' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'akreditasi' => [
                    'type' => 'ENUM',
                    'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                    'null' => false,
                    'default' => 'Belum Terakreditasi'
                ],
                'kepala_sekolah' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true
                ],
                'kontak' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'tahun_berdiri' => [
                    'type' => 'YEAR',
                    'null' => true
                ],
                'visi' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'misi' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
            ]);
            $this->forge->addKey('id_sekolah', true);
            $this->forge->createTable('sekolah', true);
        }

        // ==================== GEOJSON TABLE ====================
        if (!$this->db->tableExists('geojson')) {
            $this->forge->addField([
                'id_geojson' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true
                ],
                'nama_geojson' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ],
                'file_geojson' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => false
                ],
                'warna_geojson' => [
                    'type' => 'VARCHAR',
                    'constraint' => 7,
                    'null' => true,
                    'default' => '#3388ff'
                ],
                'opacity_geojson' => [
                    'type' => 'DECIMAL',
                    'constraint' => '3,2',
                    'null' => true,
                    'default' => 0.70
                ],
                'is_active' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'null' => true,
                    'default' => 1
                ],
                'style_geojson' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
            ]);
            $this->forge->addKey('id_geojson', true);
            $this->forge->createTable('geojson', true);
        }

        // ==================== ACTIVITY LOGS TABLE ====================
        if (!$this->db->tableExists('activity_logs')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true
                ],
                'id_user' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true
                ],
                'username' => [
                    'type' => 'VARCHAR',
                    'constraint' => 150,
                    'null' => true
                ],
                'nama_lengkap' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true
                ],
                'role' => [
                    'type' => 'ENUM',
                    'constraint' => ['admin', 'superadmin'],
                    'null' => true
                ],
                'action' => [
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ],
                'target_table' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ],
                'target_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => true
                ],
                'ip_address' => [
                    'type' => 'VARCHAR',
                    'constraint' => 45,
                    'null' => true
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
                'retention_days' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true,
                    'default' => 30
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('id_user');
            $this->forge->addKey(['target_table', 'target_id']);
            $this->forge->addKey('created_at');
            $this->forge->createTable('activity_logs', true);
        }

        // ==================== LOG RETENTION TABLE ====================
        if (!$this->db->tableExists('log_retention_settings')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'auto_increment' => true
                ],
                'key' => [
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => false
                ],
                'value' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('key');
            $this->forge->createTable('log_retention_settings', true);
        }

        // ==================== SESSIONS TABLE ====================
        if (!$this->db->tableExists('ci_sessions')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'VARCHAR',
                    'constraint' => 128,
                    'null' => false
                ],
                'ip_address' => [
                    'type' => 'VARCHAR',
                    'constraint' => 45,
                    'null' => false
                ],
                'timestamp' => [
                    'type' => 'INT',
                    'constraint' => 10,
                    'null' => false,
                    'default' => 0
                ],
                'data' => [
                    'type' => 'BLOB',
                    'null' => false
                ],
            ]);
            $this->forge->addKey('id');
            $this->forge->addKey('timestamp');
            $this->forge->createTable('ci_sessions', true, ['ENGINE' => 'InnoDB']);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('ci_sessions')) {
            $this->forge->dropTable('ci_sessions', true);
        }
        if ($this->db->tableExists('log_retention_settings')) {
            $this->forge->dropTable('log_retention_settings', true);
        }
        if ($this->db->tableExists('activity_logs')) {
            $this->forge->dropTable('activity_logs', true);
        }
        if ($this->db->tableExists('geojson')) {
            $this->forge->dropTable('geojson', true);
        }
        if ($this->db->tableExists('sekolah')) {
            $this->forge->dropTable('sekolah', true);
        }
        if ($this->db->tableExists('user')) {
            $this->forge->dropTable('user', true);
        }
    }
}
