<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PosSeeder extends Seeder
{
    public function run()
    {
        if ($this->db->table('users')->where('username', 'admin')->countAllResults() > 0) {
            return;
        }
        $now = date('Y-m-d H:i:s');
        $this->db->table('users')->insert([
            'username' => 'admin',
            'full_name' => 'POS Administrator',
            'password' => password_hash('admin12345', PASSWORD_DEFAULT),
            'avatar' => null,
            'created_at' => $now,
        ]);
    }
}
