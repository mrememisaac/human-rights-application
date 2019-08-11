<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
            'name' => 'Admin',
            'display_name' => 'Administrator',
            'description' => 'System Administrator'
            ],
            [
            'name' => 'Reviewer',
            'display_name' => 'Reviewer',
            'description' => 'Can process applications'
            ]
        ];
        foreach ($roles as $key => $value) {
            # code...
            Role::create($value);
        }
    }
}
