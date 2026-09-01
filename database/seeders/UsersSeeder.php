<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Seed hanya akun admin.
     * Akun siswa dibuat lewat halaman registrasi.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['nis' => '00001'],
            [
                'name'     => 'Admin OSIS',
                'email'    => 'admin@eventty.sch.id',
                'password' => Hash::make('password'),
                'class'    => null,
                'role'     => 'admin',
                'phone'    => null,
                'address'  => null,
                'status'   => 'active',
            ]
        );
    }
}
