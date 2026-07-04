<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLogRetentionToActivityLogs extends Migration
{
    public function up()
    {
        // Create log_retention_settings table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        
        if (!$this->db->tableExists('log_retention_settings')) {
            $this->forge->createTable('log_retention_settings');
        }

        // Insert default setting: auto-delete logs older than 30 days
        $this->db->table('log_retention_settings')->insert([
            'key'         => 'auto_delete_days',
            'value'       => '30',
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        if ($this->db->tableExists('log_retention_settings')) {
            $this->forge->dropTable('log_retention_settings');
        }
    }
}