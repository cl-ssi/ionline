<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BalanceExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithStyles
{
    protected $resultado;

    public function __construct($resultado)
    {
        $this->resultado = $resultado;
    }

    public function collection()
    {
        return collect([$this->resultado]);
    }

    public function title(): string
    {
        return 'BALANCE PRESUPUESTARIO';
    }

    public function startCell(): string
    {
        return 'B8';
    }

    public function headings(): array
    {
        return [
            'TIT.', 'ITEM.', 'ASIG.', 'GLOSA', 'PRESUPUESTO'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica borde a todas las celdas de la tabla
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,                'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('B8:F8')->applyFromArray($styleArray); // aplica borde a la fila de encabezados
        $sheet->getStyle('B9:F' . (8 + $this->resultado->count()))->applyFromArray($styleArray); // aplica borde al contenido de la tabla

        // Oculta las líneas de cuadrícula (gridlines)
        $sheet->setShowGridlines(false);

        // Agrega los textos a las celdas B1, B2 y B3 y aplica el estilo de fuente negrita
        $sheet->setCellValue('B1', 'MINISTERIO DE SALUD')->getStyle('B1')->getFont()->setBold(true);
        $sheet->setCellValue('B2', 'SERVICIO SALUD IQUIQUE')->getStyle('B2')->getFont()->setBold(true);
        $sheet->setCellValue('B3', 'SERVICIO BIENESTAR')->getStyle('B3')->getFont()->setBold(true);

        // Agrega la celda combinada con el texto "ESTADO PRESUPUESTARIO" y aplica el estilo de fuente
        $sheet->mergeCells('B5:O5');
        $sheet->setCellValue('B5', 'ESTADO PRESUPUESTARIO');
        $sheet->getStyle('B5')->getFont()->setName('Arial')->setSize(14)->setBold(true)->setUnderline(true);

        // Centra y alinea en medio la celda combinada de "ESTADO PRESUPUESTARIO"
        $sheet->getStyle('B5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B5')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
