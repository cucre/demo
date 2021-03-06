<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        $this->call(AddPermissionsToDocumentsSeeder::class);
        $this->call(AddPermissionsToSubjectsSeeder::class);
        $this->call(AddPermissionsToCoursesSeeder::class);
        $this->call(AddPermissionsToInstructorsCoursesSeeder::class);
        $this->call(AddPermissionsToStudentsSeeder::class);
        $this->call(AddPermissionsToChangePasswordSeeder::class);
        $this->call(AddPermissionsToStudentsCoursesSeeder::class);
        $this->call(AddPermissionsToStudentsStatusSeeder::class);
        $this->call(AddPermissionsToStudentsControlSeeder::class);
    }
}