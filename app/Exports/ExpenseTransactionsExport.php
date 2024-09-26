<?php

namespace App\Exports;

use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromCollection;
use Auth;
use Carbon\Carbon;
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
                $today = Carbon::today();
                $data = Cash::whereDate('created_at', $today)
                ->where('cash_type', 'expense')
                ->where('shop_id', $shopId)->get();
            }
            Log::info('Fetched data', ['data' => $data->toArray()]);
            return $data;
        }
    }
    public function headings(): array{
        return [
            'ID',
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
