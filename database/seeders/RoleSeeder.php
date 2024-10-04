<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name'=>'Admin',
                'slug'=>'admin',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'name'=>'User',
                'slug'=>'user',
                'created_at'=>now(),
                'updated_at'=>now()
            ]
        ]);
    }
}
