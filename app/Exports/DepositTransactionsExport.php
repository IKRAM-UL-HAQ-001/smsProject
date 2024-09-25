<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;

class DepositTransactionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId =  $user->shop_id;            
            if ($user && $user->role === 'admin') {
                return Cash::where('cash_type', 'deposit')->get();
            }else{
                return Cash::where('cash_type', 'deposit')
                ->where('shop_id', $shopId)
                ->get();
            }
        }
    }

    public function headings(): array{
        return [
            'id',
            'reference_number',
            'customer_name',
            'cash_amount',
            'cash_type',
            'bonus_amount',
            'total_balance',
            'total_shop_balance',
            'payment_type',
            'remarks',
            'created_at',
            'updated_at',
        ];
    }
}
