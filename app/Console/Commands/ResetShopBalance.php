<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetShopBalance extends Command
{
    protected $signature = 'balance:reset';
    protected $description = 'Reset total shop balance at midnight';

    public function handle()
    {
        DB::table('cashes')->update(['total_shop_balance' => 0]);

        $this->info('Total shop balance has been reset to 0.');
    }
}
