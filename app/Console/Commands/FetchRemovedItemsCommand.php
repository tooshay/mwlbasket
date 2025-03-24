<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Repositories\ItemsRepository;
use Illuminate\Console\Command;

class FetchRemovedItemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-removed-items {days=7}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reports on removed basket items.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $itemsRepo = app(ItemsRepository::class);

        $since = now()->subDays((int) $this->argument('days'));

        $items = $itemsRepo->findRemoved($since);

        $this->table(
            ['Product ID', 'Name', 'User email', 'Removed at'],
            $items->map(fn ($item) => [
                $item->product->id,
                $item->product->name,
                $item->basket->user->email,
                $item->updated_at->toDateTimeString(),
            ])
        );
    }
}
