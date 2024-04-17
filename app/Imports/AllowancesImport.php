<?php

namespace App\Imports;

use App\Models\Allowances\Allowance;
// use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\User;

class AllowancesImport implements ToCollection, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new AllowancesAllowance([
    //         //
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $ou = User::find($row[3]);
            if($ou){
                $allowance = Allowance::create([
                    'id'                                => $row[0],
                    'folio_sirh'                        => $row[1],
                    'status'                            => $row[2],
                    'user_allowance_id'                 => $row[3],
                    'allowance_value_id'                => $row[4],
                    'establishment_id'                  => $ou->organizationalUnit->establishment->id,
                    'organizational_unit_allowance_id'  => $ou->organizationalUnit->id,
                    'reason'                            => $row[7],
                    'origin_commune_id'                 => $row[8],
                    'from'                              => Carbon::instance(Date::excelToDateTimeObject($row[9])),
                    'to'                                => Carbon::instance(Date::excelToDateTimeObject($row[10])),
                    'total_days'                        => $row[11],
                    'total_half_days'                   => $row[12],
                    'creator_user_id'                   => $row[13],
                    'creator_ou_id'                     => $row[14],
                    'document_date'                     => Carbon::instance(Date::excelToDateTimeObject($row[15]))
                ]);
            }
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
