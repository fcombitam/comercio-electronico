<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }

    public function collection()
    {
        return $this->customers->map(function ($customer) {
            return [
                'ID' => $customer->id,
                'Nombre' => $customer->name,
                'Correo' => $customer->email,
                'Fecha de Registro' => $customer->created_at->format('d M Y'),
                'Órdenes Completadas' => $customer->orders()->whereStatus(Order::STATUS_COMPLETED)->count(),
                'Total Comprado' => '$'.number_format($customer->orders()->whereStatus(Order::STATUS_COMPLETED)->sum('total_amount'), 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Correo',
            'Fecha de Registro',
            'Órdenes Completadas',
            'Total Comprado',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F497D']
                ],
            ],
        ];
    }
}
