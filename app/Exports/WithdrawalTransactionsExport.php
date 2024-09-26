<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Carbon\Carbon;

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
                $today = Carbon::today();
                return Cash::whereDate('created_at', $today)
                ->where('cash_type', 'withdrawal')
                ->where('shop_id', $shopId)
                ->get();
            }
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'Reference Number',
            'Customer Name',
            'Cash Amount',
            'Cash Type',
            'Total Balance',
            'Total Shop Balance',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }
}
