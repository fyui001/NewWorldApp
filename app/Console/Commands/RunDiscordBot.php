<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Interfaces\DiscordBotServiceInterface;

class RunDiscordBot extends Command
{

    protected DiscordBotServiceInterface $handyManService;

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
    public function __construct(DiscordBotServiceInterface $handyManService)
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
