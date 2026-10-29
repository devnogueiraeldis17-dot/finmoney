<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Os campos role e birth_date já são criados
        // na migration create_users_table.
    }

    public function down(): void
    {
        // Não remover campos da tabela users.
    }
};
