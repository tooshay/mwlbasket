<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\ItemsRepository;
use Illuminate\Console\Command;

class FetchRemovedItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-removed-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemsRepo = app(ItemsRepository::class);

        $since = now()->subDays($this->option('days'));

        $items = $itemsRepo->getRemovedItems($since);

        $this->table(
            ['Product', 'User Email', 'Removed At'],
            $items->map(fn ($item) => [
                $item->product->name,
                $item->basket->user->email,
                $item->updated_at->toDateTimeString(),
            ])
        );
    }
}
