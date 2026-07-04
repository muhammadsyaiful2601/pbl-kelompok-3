<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * MASTER MIGRATION — WebGIS PBL Kelompok 3
 *
 * Satu file migration yang mencakup semua tabel aplikasi.
 * Jalankan: php spark migrate:refresh (setelah hapus semua migration lain)
 *
 * Tabel yang dibuat:
 * - user
 * - sekolah
 * - geojson
 * - activity_logs
 */
class MasterMigration extends Migration
{
    public function up()
    {
        // ================================================================
        // TABEL: user
        // ================================================================
        if (!$this->db->tableExists('user')) {
            $this->forge->addField([
                'id_user' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'auto_increment' => true,
                ],
                'username' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => false,
                ],
                'nama_lengkap' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '150',
                    'null'       => true,
                    'default'    => null,
                ],
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                    'default'    => null,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                    'default'    => null,
                ],
                'password' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['admin', 'superadmin'],
                    'null'       => false,
                    'default'    => 'admin',
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
            $this->forge->addUniqueKey('username');
            $this->forge->createTable('user', true, [
                'ENGINE'  => 'MyISAM',
                'CHARSET' => 'utf8mb4',
                'COLLATE' => 'utf8mb4_general_ci',
            ]);
        } else {
            // Pastikan kolom foto ada jika tabel sudah ada
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
            // Pastikan kolom email ada
            if (!$this->db->fieldExists('email', 'user')) {
                $this->forge->addColumn('user', [
                    'email' => [
                        'type'       => 'VARCHAR',
                        'constraint' => '100',
                        'null'       => true,
                        'default'    => null,
                    ],
                ]);
            }
        }

        // ================================================================
        // TABEL: sekolah
        // ================================================================
        if (!$this->db->tableExists('sekolah')) {
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
                    'constraint' => ['Negeri', 'Swasta'],
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
                'deskripsi_sekolah' => [
                    'type'    => 'TEXT',
                    'null'    => true,
                    'default' => null,
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
                    'type'    => 'YEAR',
                    'null'    => true,
                    'default' => null,
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
                    'type'    => 'TEXT',
                    'null'    => true,
                    'default' => null,
                ],
                'akreditasi' => [
                    'type'       => 'ENUM',
                    'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'],
                    'null'       => false,
                    'default'    => 'Belum Terakreditasi',
                ],
                'kurikulum' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                    'default'    => null,
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

            $this->forge->addKey('id_sekolah', true);
            $this->forge->createTable('sekolah', true, [
                'ENGINE'  => 'MyISAM',
                'CHARSET' => 'utf8mb4',
                'COLLATE' => 'utf8mb4_general_ci',
            ]);
        } else {
            // Tabel sudah ada — pastikan semua kolom lengkap & benar

            // Fix ENUM kategori ke nilai yang benar
            $this->db->query("ALTER TABLE sekolah MODIFY COLUMN kategori ENUM('Negeri','Swasta') NULL DEFAULT NULL");

            // Hapus kolom jumlah_siswa yang sudah tidak digunakan
            if ($this->db->fieldExists('jumlah_siswa', 'sekolah')) {
                $this->forge->dropColumn('sekolah', 'jumlah_siswa');
            }

            $columnsToAdd = [
                'kepala_sekolah'    => ['type' => 'VARCHAR', 'constraint' => '150', 'null' => true, 'default' => null, 'after' => 'nama_sekolah'],
                'akreditasi'        => ['type' => 'ENUM', 'constraint' => ['A', 'B', 'C', 'Belum Terakreditasi', 'Tidak Diketahui'], 'null' => false, 'default' => 'Belum Terakreditasi'],
                'kurikulum'         => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true, 'default' => null],
                'kontak'            => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true, 'default' => null],
                'tahun_berdiri'     => ['type' => 'YEAR', 'null' => true, 'default' => null],
                'visi'              => ['type' => 'TEXT', 'null' => true, 'default' => null],
                'misi'              => ['type' => 'TEXT', 'null' => true, 'default' => null],
                'deskripsi_sekolah' => ['type' => 'TEXT', 'null' => true, 'default' => null],
            ];

            foreach ($columnsToAdd as $column => $definition) {
                if (!$this->db->fieldExists($column, 'sekolah')) {
                    $this->forge->addColumn('sekolah', [$column => $definition]);
                }
            }
        }

        // ================================================================
        // TABEL: geojson
        // ================================================================
        if (!$this->db->tableExists('geojson')) {
            $this->forge->addField([
                'id_geojson' => [
                    'type'           => 'INT',
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'nama_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'file_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => false,
                ],
                'warna_geojson' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '20',
                    'null'       => true,
                    'default'    => '#3b82f6',
                ],
                'opacity_geojson' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '3,2',
                    'null'       => true,
                    'default'    => '0.50',
                ],
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'null'       => false,
                    'default'    => 0,
                ],
                'style_geojson' => [
                    'type'    => 'TEXT',
                    'null'    => true,
                    'default' => null,
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
            $this->forge->createTable('geojson', true, [
                'ENGINE'  => 'MyISAM',
                'CHARSET' => 'utf8mb4',
                'COLLATE' => 'utf8mb4_general_ci',
            ]);
        } else {
            // Pastikan kolom style_geojson ada
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

        // ================================================================
        // TABEL: activity_logs
        // ================================================================
        if (!$this->db->tableExists('activity_logs')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_user' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                    'null'     => true,
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
                    'null'       => false,
                ],
                'target_table' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => false,
                ],
                'target_id' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                    'null'     => true,
                ],
                'description' => [
                    'type' => 'TEXT',
                    'null' => false,
                ],
                'ip_address' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '45',
                    'null'       => false,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
            ]);

            $this->forge->addKey('id', true);
            $this->forge->addKey('id_user');
            $this->forge->createTable('activity_logs', true, [
                'ENGINE'  => 'MyISAM',
                'CHARSET' => 'utf8mb4',
                'COLLATE' => 'utf8mb4_general_ci',
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('activity_logs', true);
        $this->forge->dropTable('geojson', true);
        $this->forge->dropTable('sekolah', true);
        $this->forge->dropTable('user', true);
    }
}