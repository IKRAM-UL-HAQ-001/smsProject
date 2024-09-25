<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;

class WithdrawalTransactionsExport implements FromCollection
{
    public function collection(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId =  $user->shop_id;            
            if ($user && $user->role === 'admin') {
                return Cash::where('cash_type', 'withdrawal')->get();
            }else{
                return Cash::where('cash_type', 'withdrawal')
                ->where('shop_id', $shopId)
                ->get();
            }
        }
    }

    public function headings(): array
    {
        return [
            'id',
            'reference_number',
            'customer_name',
            'cash_amount',
            'cash_type',
            'total_balance',
            'total_shop_balance',
            'remarks',
            'created_at',
            'updated_at',
        ];
    }
}
