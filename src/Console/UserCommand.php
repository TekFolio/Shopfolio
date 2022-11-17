<?php

namespace Shopfolio\Console;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shopfolio:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user with admin role and all permissions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Create Admin User for Shopfolio administration panel');
        $this->createUser();
        $this->info('User created successfully.');
    }

    /**
     * Create admin user.
     */
    protected function createUser(): void
    {
        $email = $this->ask('Email Address', 'admin@admin.com');
        $first_name = $this->ask('First Name', 'Shopfolio');
        $last_name = $this->ask('Last Name', 'Admin');
        $password = $this->secret('Password');
        $confirmPassword = $this->secret('Confirm Password');

        // Passwords don't match
        if ($password !== $confirmPassword) {
            $this->info('Passwords don\'t match');
        }

        $this->info('Creating admin account...');

        $userData = [
            'email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'password' => Hash::make($password),
            'last_login_at' => now()->toDateTimeString(),
            'email_verified_at' => now()->toDateTimeString(),
            'last_login_ip' => request()->getClientIp(),
        ];
        $model = config('auth.providers.users.model');

        try {
            $user = tap((new $model())->forceFill($userData))->save();

            $user->assignRole(config('shopfolio.system.users.admin_role'));
        } catch (Exception | QueryException $e) {
            $this->error($e->getMessage());
        }
    }
}
