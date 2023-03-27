<?php

namespace App\Http\Controllers\Welfare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Welfare\Loan;
use Maatwebsite\Excel\Facades\Excel;

class LoanController extends Controller
{
    //

    public function index()
    {
        $loans = Loan::paginate(100);
        return view('welfare.loans.index', compact('loans'));
    }

    public function import(Request $request)
    {
        $request->validate([
            //'file' => 'required|mimes:xlsx,xls,csv,CSV'
        ]);
        
        $data = Excel::toArray([], $request->file('file'));

        if (!empty($data) && count($data[0])) {
            foreach ($data[0] as $row) {
                $loan = new Loan;
                $loan->folio = $row[0];
                $loan->rut = $row[1];
                $loan->names = $row[2];
                //TODO Ver el archivo original como trae el formato de fecha si con / o -
                $loan->date = date('Y-m-d', strtotime(str_replace('/','-',$row[3])));
                $loan->number = $row[4];
                $loan->late_number = $row[5];
                $loan->late_interest = $row[6];
                $loan->late_amortization = $row[7];
                $loan->late_value = $row[8];
                $loan->save();
            }
        }
        
        return redirect()->back()->with('success', 'Importado exitosamente');
    }
}
