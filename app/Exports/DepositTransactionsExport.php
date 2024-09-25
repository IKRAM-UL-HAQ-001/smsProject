<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
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
            if ($user->role === 'admin') {
                return Cash::where('cash_type', 'deposit')->get();
            } else {
                return Cash::where('cash_type', 'deposit')->where('shop_id', $shopId)->get();
            }
        }
    }

    public function headings(): array{
        return [
            'ID',
            'Reference Number',
            'Customer Name',
            'Cash Amount',
            'Cash Type',
            'Bonus Amount',
            'Total Balance',
            'Total Shop Balance',
            'Payment Type',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }
}
