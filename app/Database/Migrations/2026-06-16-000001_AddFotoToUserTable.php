<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToUserTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('foto', 'user')) {
            $fields = [
                'foto' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '255',
                    'null'       => true,
                    'default'    => null,
                ],
            ];
            $this->forge->addColumn('user', $fields);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('foto', 'user')) {
            $this->forge->dropColumn('user', 'foto');
        }
    }
}
