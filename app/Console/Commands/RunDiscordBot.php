<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Interfaces\HandyManServiceInterface;

class RunDiscordBot extends Command
{

    protected HandyManServiceInterface $handyManService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord-bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starting run a discord bot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(HandyManServiceInterface $handyManService)
    {
        $this->handyManService = $handyManService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->handyManService->run(env('BOT_TOKEN'));
    }
}
