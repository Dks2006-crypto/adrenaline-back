<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
        ]);

        // Админ
        $admin = User::create([
            'email' => 'admin@fitness.ru',
            'password' => bcrypt('password'),
            'name' => 'Админ',
            'role_id' => Role::where('name', 'admin')->first()->id,
            'confirmed_at' => now(),
        ]);


        // Тренера
        $trainerUser = User::create([
            'email' => 'trainer@fitness.ru',
            'password' => bcrypt('password'),
            'name' => 'Алексей',
            'last_name' => 'Тренеров',
            'role_id' => Role::where('name', 'trainer')->first()->id,
        ]);

        // Тарифы
        Service::create([
            'title' => 'Месячный безлимит',
            'description' => 'Полный доступ ко всем залам',
            'duration_days' => 30,
            'visits_limit' => null,
            'price_cents' => 490000, // 4900.00 RUB
            'currency' => 'RUB',
            'type' => 'monthly',
        ]);

        Service::create([
            'title' => '10 посещений',
            'description' => 'Разовые посещения',
            'duration_days' => 90,
            'visits_limit' => 10,
            'price_cents' => 350000,
            'currency' => 'RUB',
            'type' => 'single',
        ]);
    }
}
