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

class DepositTransactionsExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $shopId;

    public function __construct($shopId)
    {
        $this->shopId = $shopId;
    }

    public function query()
    {
        $userId = Auth::User()->id;
        $today = Carbon::today();
        return Cash::select(
            'cashes.id', 
            'shops.shop_name as shop_name',
            'users.user_name as user_name',
            'cashes.reference_number',
            'cashes.customer_name',
            'cashes.cash_type',
            'cashes.cash_amount',
            'cashes.bonus_amount',
            'cashes.payment_type',
            'cashes.total_shop_balance',
            'cashes.remarks',
            'cashes.created_at',
            'cashes.updated_at'
        )
        ->join('shops', 'cashes.shop_id', '=', 'shops.id') 
        ->join('users', 'cashes.user_id', '=', 'users.id') 
        ->whereDate('cashes.created_at', $today) 
        ->where('cashes.cash_type', 'deposit')
        ->where('cashes.shop_id', $this->shopId);

    }

    public function headings(): array{
        return [
            'ID',
            'Shop Name',
            'User Name',
            'Reference Number',
            'Customer Name',
            'Cash Type',
            'Cash Amount',
            'Bonus Amount',
            'Payment Type',
            'Total Shop Balance',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:L1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, 
            'B' => 20, 
            'C' => 15, 
            'D' => 20, 
            'E' => 20, 
            'F' => 20, 
            'G' => 20, 
            'H' => 20,
            'I' => 15,
            'J' => 20,
            'K' => 30,
            'L' => 30,
            'M' => 30,
        ];
    }
}
