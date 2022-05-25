<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\File;
use App\Models\Permission;
use App\Models\PermissionArea;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->truncate();
        DB::table('files')->truncate();
        DB::table('permissions')->truncate();
        DB::table('areas')->truncate();
        DB::table('permission_areas')->truncate();
        User::factory(30)->create();
        File::factory(50)->create();
        Permission::factory(20)->create();
        Area::factory(20)->create();
        PermissionArea::factory(30)->create();
    }
}