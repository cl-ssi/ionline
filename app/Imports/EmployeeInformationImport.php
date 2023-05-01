<?php

namespace App\Imports;

use App\Models\Welfare\EmployeeInformation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;

class EmployeeInformationImport implements ToModel, WithHeadingRow, WithGroupedHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EmployeeInformation([
            //
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
