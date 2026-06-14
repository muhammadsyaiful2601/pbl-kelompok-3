<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUserTable extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'admin',
                'after'      => 'nama_lengkap',
            ],
        ];
        $this->forge->addColumn('user', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('user', 'role');
    }
}
