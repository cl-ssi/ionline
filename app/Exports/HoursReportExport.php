<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HoursReportExport implements FromArray, WithHeadings
{
    protected $reportData;
    protected $months;
    protected $totalHoursOverall;

    public function __construct($reportData, $months, $totalHoursOverall)
    {
        $this->reportData = $reportData;
        $this->months = $months;
        $this->totalHoursOverall = $totalHoursOverall;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->reportData as $row) {
            $monthlyHours = [];
            foreach ($this->months as $month) {
                $monthlyHours[] = number_format($row['monthly_hours'][$month] ?? 0, 2);
            }
            $data[] = array_merge(
                [$row['employee'], $row['service_request_id']],
                $monthlyHours,
                [number_format($row['total_hours'], 2)]
            );
        }
        $data[] = array_merge(['Total', ''], array_fill(0, count($this->months), ''), [number_format($this->totalHoursOverall, 2)]);
        return $data;
    }

    public function headings(): array
    {
        return array_merge(['Profesional', 'Contrato (ServiceRequest ID)'], $this->months, ['Total Horas']);
    }
}
