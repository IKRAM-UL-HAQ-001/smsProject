<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExpenseTransactionsExport implements FromCollection
{
    public function collection(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId =  $user->shop_id;            
            if ($user->role === 'admin') {
                $data = Cash::where('cash_type', 'expense')->get();
            } else {
                $data = Cash::where('cash_type', 'expense')->where('shop_id', $shopId)->get();
            }
            Log::info('Fetched data', ['data' => $data->toArray()]);
            return $data;
        }
    }
    public function headings(): array{
        return [
            'id',
            'cash-amount',
            'cash_type',
            'total_balance',
            'total_shop_balance',
            'remarks',
            'created_t',
            'updated_at',
        ];
    }
}
