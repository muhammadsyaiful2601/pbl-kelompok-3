<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUserTable extends Migration
{
    public function up()
    {
        // Role sudah ditambahkan di migrasi CreateUserTable
        // Tidak perlu ditambahkan lagi
    }

    public function down()
    {
        // Role sudah di-drop bersama tabel user
    }
}