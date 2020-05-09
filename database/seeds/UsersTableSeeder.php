<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();

        $adminRole = Role::select('id')->where('name','admin')->get();
        $authorRole = Role::select('id')->where('name','author')->get();
        $userRole = Role::select('id')->where('name','user')->get();

        $admin=User::create([
            'name'=>'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('adminadmin')
        ]);

        $author=User::create([
            'name'=>'Author User',
            'email' => 'author@author.com',
            'password' => Hash::make('password')
        ]);

        $user=User::create([
            'name'=>'Generic User',
            'email' => 'user@user.com',
            'password' => Hash::make('password')
        ]);

        $admin->roles()->attach($adminRole);
        $author->roles()->attach($authorRole);
        $user->roles()->attach($userRole);
    }
}
