<?php

namespace App\Imports;

use App\Models\Welfare\Abscence;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;

class AbscencesImport implements ToModel, WithHeadingRow, WithGroupedHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Abscence([
            //
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
