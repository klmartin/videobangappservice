<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Throwable;

class AMSAdminSeeder extends Seeder
{
    public function run()
    {

        $user = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('BingBang2023!!!'),
            'role' => 'ADMIN',
        ];
        try {
            User::create($user);
        } catch (Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}