<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::create([
            'name' => 'Md.Tejal Gandhi',
            'email' => 'tejal@gmail.com',
            'password' => Hash::make('12345678')
        ]);
    }
}
