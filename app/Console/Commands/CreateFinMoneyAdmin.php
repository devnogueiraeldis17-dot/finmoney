<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFinMoneyAdmin extends Command
{
    protected $signature = 'finmoney:create-admin';
    protected $description = 'Cria o primeiro administrador do FinMoney de forma interativa';

    public function handle(): int
    {
        if (User::where('role', 'admin')->exists()) {
            $this->error('Já existe um administrador. Use a área administrativa para criar outros usuários.');
            return self::FAILURE;
        }

        $name = $this->ask('Nome completo');
        $birthDate = $this->ask('Data de nascimento (AAAA-MM-DD)');
        $email = $this->ask('E-mail');
        $password = $this->secret('Senha (mínimo de 10 caracteres)');

        if (!$name || !$email || !$birthDate || strlen((string) $password) < 10 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Dados inválidos. Confira o e-mail, a data e use uma senha com pelo menos 10 caracteres.');
            return self::FAILURE;
        }

        if (User::where('email', $email)->exists()) {
            $this->error('Esse e-mail já está cadastrado.');
            return self::FAILURE;
        }

        User::create([
            'name' => $name,
            'birth_date' => $birthDate,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Administrador criado com sucesso.');
        return self::SUCCESS;
    }
}
