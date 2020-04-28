<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        \App\Role::create(['name' => 'admin', 'label'=>'Admin']);
        \App\Role::create(['name' => 'hr', 'label'=>'HR Manager']);

        \App\LeaveType::create(['name' => 'Paid']);
        \App\LeaveType::create(['name' => 'Sick']);

        $user = \App\User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        $user->roles()->attach(1);

        foreach ($user->roles as $role) {
            info($role->name);
        }
    }
}
