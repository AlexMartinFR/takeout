<?php

namespace App\Commands;

use App\InitializesCommands;
use App\Shell\Docker;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class ListCommand extends Command
{
    use InitializesCommands;

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'list:services';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'List all services installed by Takeout.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->initializeCommand();

        $containers = $this->containersTable();

        $this->table(array_shift($containers), $containers);
        // @todo test this call
    }

    public function containersTable(): array
    {
        $output = app(Docker::class)->containers()->getOutput();

        return array_map(function ($line) {
           return array_filter(explode("        ", $line));
        }, explode("\n", $output));
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
