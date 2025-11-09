<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateAdminToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate admin token in sanctum API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $token =  User::role('admin')
            ->first()
            ->createToken('admin-token');

        $this->info($token->plainTextToken);
    }
}
