<?php

namespace App\Exports;

use App\Models\HK;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Carbon\Carbon;
use Auth;

class HKListExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $shopId;

    public function __construct($shopId){
        $this->shopId = $shopId;
    }

    public function query()
    {
        $today = Carbon::today(); // Get today's date
    
        $query = HK::selectRaw('
                h_k_s.id, 
                shops.shop_name AS shop_name,
                users.user_name AS user_name,
                h_k_s.cash_amount,
                h_k_s.remarks,
                DATE_FORMAT(CONVERT_TZ(h_k_s.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
                DATE_FORMAT(CONVERT_TZ(h_k_s.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
            ')
            ->join('shops', 'h_k_s.shop_id', '=', 'shops.id') // Join with shops
            ->join('users', 'h_k_s.user_id', '=', 'users.id') // Join with users based on user_id
            ->whereDate('h_k_s.created_at', $today) // Filter by today's date
            ->distinct(); // Ensure unique results
    
        switch (Auth::user()->role) {
            case "shop":
                return $query->where('h_k_s.shop_id', Auth::user()->shop_id);
            case "admin":
                return $query; // Return all h_k_s for admin
            default:
                return $query->whereNull('h_k_s.id'); // For unrecognized roles, return an empty result set
        }
    }
        


    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Cash Amount',
            'Remarks',
            'Created At',
            'Updated At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:G1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // ID
            'B' => 20, // Shop Name
            'C' => 15, // User Name
            'D' => 20, // Cash Amount
            'E' => 20, // Remarks
            'F' => 30, // created_at
            'G' => 30,  // updated_At
        ];
    }
}
