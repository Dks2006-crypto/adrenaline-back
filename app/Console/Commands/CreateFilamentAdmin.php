<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentAdmin extends Command
{
    protected $signature = 'make:filament-admin
        {--name=Админ : Имя администратора}
        {--email=admin@mail.ru : Email}
        {--password= : Пароль (если пусто — будет запрошен)}';

    protected $description = 'Создать администратора Filament с ролью admin';

    public function handle(): int
    {
        // 1. Получаем данные
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        // 2. Запрашиваем, если не передали
        $email = $email ?: $this->ask('Введите email администратора', 'admin@fitness.ru');
        $name = $name ?: $this->ask('Введите имя', 'Админ');

        if (!$password) {
            $password = $this->secret('Введите пароль');
            $confirm = $this->secret('Повторите пароль');
            if ($password !== $confirm) {
                $this->error('Пароли не совпадают!');
                return 1;
            }
        }

        // 3. Проверяем, нет ли уже такого email
        if (User::where('email', $email)->exists()) {
            $this->error("Пользователь с email $email уже существует!");
            return 1;
        }

        // 4. Находим или создаём роль admin
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['name' => 'admin']
        );

        // 5. Создаём пользователя
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role_id' => $adminRole->id,
            'confirmed_at' => now(),
            'email_verified_at' => now(), // если есть это поле
        ]);

        $this->components->info("Администратор успешно создан!");
        $this->newLine();
        $this->table(
            ['Поле', 'Значение'],
            [
                ['Email', $email],
                ['Пароль', $password],
                ['Роль', 'admin'],
                ['URL', url('/admin')],
            ]
        );

        return 0;
    }
}
