<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   // database/seeders/DatabaseSeeder.php

public function run(): void
{
    User::updateOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]
    );

    $this->call([
        CategorySeeder::class,
        ProductSeeder::class,
    ]);
}

}
