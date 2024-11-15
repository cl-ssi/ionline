<?php

namespace App\Exports\Pharmacies;

use App\Models\Pharmacies\Purchase;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PurchasesExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = array_merge([
            'dateFrom' => now()->startOfMonth()->format('Y-m-d'),
            'dateTo' => now()->endOfMonth()->format('Y-m-d'),
            'supplier_id' => null,
            'invoice' => '',
            'acceptance_certificate' => '',
            'program' => ''
        ], $filters);
    }

    public function view(): View
    {
        $purchases = Purchase::where('pharmacy_id', session('pharmacy_id'))
            ->whereBetween('date', [$this->filters['dateFrom'], $this->filters['dateTo']])
            ->when($this->filters['supplier_id'], function ($query, $supplier_id) {
                return $query->where('supplier_id', $supplier_id);
            })
            ->where('invoice', 'LIKE', "%" . $this->filters['invoice'] . "%")
            ->where('id', 'LIKE', "%" . $this->filters['acceptance_certificate'] . "%")
            ->whereHas('purchaseItems', function ($query) {
                return $query->whereHas('product', function ($query) {
                    return $query->whereHas('program', function ($query) {
                        return $query->where('name', 'LIKE', "%" . $this->filters['program'] . "%");
                    });
                });
            })
            ->orderBy('id', 'DESC')
            ->get();

        return view('pharmacies.exports.purchases', ['purchases' => $purchases]);
    }
}
