<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Consolidated migration for all database changes
 * This file combines multiple migrations into one for easier management
 */
class ConsolidatedMigrations extends Migration
{
    public function up()
    {
        // ==================== USER TABLE ====================
        if ($this->db->tableExists('user')) {
            // Add foto column if not exists
            if (!$this->db->fieldExists('foto', 'user')) {
                $this->forge->addColumn('user', [
                    'foto' => [
                        'type'       => 'VARCHAR',
                        'constraint' => '255',
                        'null'       => true,
                        'default'    => null,
                        'after'      => 'nama_lengkap',
                    ],
                ]);
            }
        }

        // ==================== SEKOLAH TABLE ====================
        if ($this->db->tableExists('sekolah')) {
            // Add akreditasi column
            if (!$this->db->fieldExists('akreditasi', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'akreditasi' => [
                        'type'       => 'ENUM',
                        'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                        'null'       => false,
                        'default'    => 'Belum Terakreditasi',
                    ],
                ]);
            }

            // Add kepala_sekolah column
            if (!$this->db->fieldExists('kepala_sekolah', 'sekolah')) {
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

            // Add kontak column
            if (!$this->db->fieldExists('kontak', 'sekolah')) {
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

            // Add tahun_berdiri column
            if (!$this->db->fieldExists('tahun_berdiri', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'tahun_berdiri' => [
                        'type'       => 'YEAR',
                        'null'       => true,
                        'default'    => null,
                        'after'      => 'kontak',
                    ],
                ]);
            }

            // Add visi column
            if (!$this->db->fieldExists('visi', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'visi' => [
                        'type'    => 'TEXT',
                        'null'    => true,
                        'default' => null,
                    ],
                ]);
            }

            // Add misi column
            if (!$this->db->fieldExists('misi', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'misi' => [
                        'type'    => 'TEXT',
                        'null'    => true,
                        'default' => null,
                    ],
                ]);
            }

            // Add kurikulum column
            if (!$this->db->fieldExists('kurikulum', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'kurikulum' => [
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => true,
                        'default'    => null,
                        'after'      => 'akreditasi',
                    ],
                ]);
            }

            // Add npsn column
            if (!$this->db->fieldExists('npsn', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'npsn' => [
                        'type'       => 'VARCHAR',
                        'constraint' => '20',
                        'null'       => true,
                        'default'    => null,
                        'after'      => 'nama_sekolah',
                    ],
                ]);
            }

            // Drop jumlah_siswa column if exists
            if ($this->db->fieldExists('jumlah_siswa', 'sekolah')) {
                $this->forge->dropColumn('sekolah', ['jumlah_siswa']);
            }
        }

        // ==================== ACTIVITY LOGS TABLE ====================
        if ($this->db->tableExists('activity_logs')) {
            // Add retention_days column if not exists
            if (!$this->db->fieldExists('retention_days', 'activity_logs')) {
                $this->forge->addColumn('activity_logs', [
                    'retention_days' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'null'       => true,
                        'default'    => 30,
                        'after'      => 'created_at',
                    ],
                ]);
            }
        } else {
            // Create activity_logs table if not exists
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
                'id_user' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'username' => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true],
                'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
                'role' => ['type' => 'ENUM', 'constraint' => ['admin', 'superadmin'], 'null' => true],
                'action' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
                'target_table' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
                'target_id' => ['type' => 'INT', 'constraint' => 11, 'null' => true],
                'description' => ['type' => 'TEXT', 'null' => true],
                'ip_address' => ['type' => 'VARCHAR', 'constraint' => '45', 'null' => true],
                'created_at' => ['type' => 'DATETIME', 'null' => true],
                'retention_days' => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 30],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('activity_logs', true);
        }

        // ==================== GEOJSON TABLE ====================
        if ($this->db->tableExists('geojson')) {
            // Add style columns if not exists
            if (!$this->db->fieldExists('style_geojson', 'geojson')) {
                $this->forge->addColumn('geojson', [
                    'style_geojson' => [
                        'type'    => 'TEXT',
                        'null'    => true,
                        'default' => null,
                    ],
                ]);
            }
        }
    }

    public function down()
    {
        // ==================== GEOJSON TABLE ====================
        if ($this->db->tableExists('geojson')) {
            if ($this->db->fieldExists('style_geojson', 'geojson')) {
                $this->forge->dropColumn('geojson', ['style_geojson']);
            }
        }

        // ==================== ACTIVITY LOGS TABLE ====================
        if ($this->db->tableExists('activity_logs')) {
            $this->forge->dropTable('activity_logs', true);
        }

        // ==================== SEKOLAH TABLE ====================
        if ($this->db->tableExists('sekolah')) {
            $columnsToRemove = ['akreditasi', 'kepala_sekolah', 'kontak', 'tahun_berdiri', 'visi', 'misi', 'kurikulum', 'npsn'];
            foreach ($columnsToRemove as $col) {
                if ($this->db->fieldExists($col, 'sekolah')) {
                    $this->forge->dropColumn('sekolah', [$col]);
                }
            }

            // Re-add jumlah_siswa column
            if (!$this->db->fieldExists('jumlah_siswa', 'sekolah')) {
                $this->forge->addColumn('sekolah', [
                    'jumlah_siswa' => [
                        'type'       => 'INT',
                        'constraint' => 11,
                        'null'       => true,
                        'default'    => null,
                    ],
                ]);
            }
        }

        // ==================== USER TABLE ====================
        if ($this->db->tableExists('user')) {
            if ($this->db->fieldExists('foto', 'user')) {
                $this->forge->dropColumn('user', ['foto']);
            }
        }
    }
}