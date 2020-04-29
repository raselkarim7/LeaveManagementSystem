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
        \App\Role::create(['name' => 'ceo', 'label'=>'CEO']);
        \App\Role::create(['name' => 'cto', 'label'=>'CTO']);
        \App\Role::create(['name' => 'sreng', 'label'=>'Seniour Engr']);
        \App\Role::create(['name' => 'jreng', 'label'=>'Junior Engr']);
        \App\Role::create(['name' => 'receptionist', 'label'=>'Receptionist']);


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
