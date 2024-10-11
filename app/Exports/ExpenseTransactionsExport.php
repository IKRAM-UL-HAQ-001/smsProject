<?php

namespace App\Exports;

use Auth;
use Carbon\Carbon;
use App\Models\Cash;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExpenseTransactionsExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $shopId;

    public function __construct($shopId){
        $this->shopId = $shopId;
    }

    public function query(){
        $currentMonth = Carbon::now()->month;
        $query = Cash::selectRaw('
                cashes.id, 
                shops.shop_name as shop_name,
                users.user_name as user_name,
                cashes.cash_type,
                cashes.cash_amount,
                cashes.total_shop_balance,
                cashes.remarks,
                DATE_FORMAT(CONVERT_TZ(cashes.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
                DATE_FORMAT(CONVERT_TZ(cashes.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
            ')
            ->join('shops', 'cashes.shop_id', '=', 'shops.id') 
            ->join('users', 'cashes.user_id', '=', 'users.id') 
            ->whereMonth('cashes.created_at', $currentMonth) 
            ->where('cashes.cash_type', 'expense');

        if (Auth::user()->role == "shop") {
            return $query->where('cashes.shop_id', $this->shopId);
        }elseif (Auth::user()->role == "admin") {
            return $query;
        }
    }

    
    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Cash Type',
            'Cash Amount',
            'Total Shop Balance',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:I1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // ID
            'B' => 20, // Shop Name
            'C' => 15, // Cash Type
            'D' => 15, // Cash Amount
            'E' => 20, // Total Shop Balance
            'F' => 25, // Remarks
            'G' => 30, // created_at
            'H' => 30,
            'I' => 30, // updated_At
        ];
    }
}
