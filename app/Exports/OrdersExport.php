<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
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

    public function collection()
    {
        return $this->orders->map(function ($order) {
            return [
                'ID' => $order->id,
                'Nombre' => $order->user->name,
                'Correo' => $order->user->email,
                'Cantidad de Ítems' => $order->items->count(),
                'Total de Orden' => '$' . number_format($order->total_amount, 0, ',', '.'),
                'Fecha de Actualización' => $order->updated_at->format('Y-m-d'),
                'Estado' => $order->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Correo',
            'Cantidad de Ítems',
            'Total de Orden',
            'Fecha de Actualización',
            'Estado',
        ];
    }
}
