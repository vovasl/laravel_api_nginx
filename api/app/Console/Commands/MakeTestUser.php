<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:test-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with an API token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
            ]
        );

        $token = $user->createToken('local-test-token')->plainTextToken;

        $this->info('✅ Test user created successfully.');
        $this->line("Email: test@example.com");
        $this->line("Password: password");
        $this->line("Token: $token");
    }
}
