<?php

namespace App\Exports;

use App\Models\Customer;
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

class CustomerListExport implements FromQuery,  WithHeadings, WithStyles, WithColumnWidths
{
    use Exportable;

    protected $shopId;

    public function __construct($shopId){
        $this->shopId = $shopId;
    }

    public function query()
    {
        $today = Carbon::today(); // Get today's date
    
        $query = Customer::selectRaw('
                customers.id, 
                shops.shop_name AS shop_name,
                users.user_name AS user_name,
                customers.reference_number,
                customers.name AS customer_name,
                customers.cash_amount,
                DATE_FORMAT(CONVERT_TZ(customers.created_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as created_at,
                DATE_FORMAT(CONVERT_TZ(customers.updated_at, "+00:00", "+05:30"), "%Y-%m-%d %H:%i:%s") as updated_at
            ')
            ->join('shops', 'customers.shop_id', '=', 'shops.id') // Join with shops
            ->join('users', 'customers.user_id', '=', 'users.id') // Join with users based on user_id
            ->whereDate('customers.created_at', $today) // Filter by today's date
            ->distinct(); // Ensure unique results
    
        switch (Auth::user()->role) {
            case "shop":
                return $query->where('customers.shop_id', Auth::user()->shop_id);
            case "admin":
                return $query; // Return all customers for admin
            default:
                return $query->whereNull('customers.id'); // For unrecognized roles, return an empty result set
        }
    }
        


    public function headings(): array
    {
        return [
            'ID',
            'Exchange Name',
            'User Name',
            'Reference Number',
            'Customer Name',
            'Cash Amount',
            'Created At',
            'Updated At',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true); // Bold the header row
        $sheet->getStyle('A1:H1')->getFont()->setSize(12); // Optional: set font size
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10, // ID
            'B' => 20, // Shop Name
            'C' => 15, // Cash Type
            'D' => 20, // Cash Amount
            'E' => 20, // Total Shop Balance
            'F' => 25, // Remarks
            'G' => 30, // created_at
            'H' => 30, // updated_At
        ];
    }
}
