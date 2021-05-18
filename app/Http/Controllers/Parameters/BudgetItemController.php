<?php

namespace App\Http\Controllers\Parameters;

use Illuminate\Http\Request;
use App\Models\Parameters\BudgetItem;
use App\Http\Controllers\Controller;

class BudgetItemController extends Controller
{
    public function index(){
        $budgetItems = BudgetItem::All();
        return view('parameters.budgetitems.index', compact('budgetItems'));
    }

    public function create(){
        return view('parameters.budgetitems.create');
    }

    public function store(Request $request){
        $budgetItem = new BudgetItem($request->All());
        $budgetItem->save();

        session()->flash('info', 'Item Presupuestario  '.$budgetItem->name.' ha sido creado.');

        return redirect()->route('parameters.budgetitems.index');
    }

    public function show(BudgetItem $budgetItem){

    }

    public function edit(BudgetItem $budgetItem){
        return view('parameters.budgetitems.edit', compact('budgetItem'));
    }

    public function update(Request $request, BudgetItem $budgetItem){
        $budgetItem->fill($request->all());
        $budgetItem->save();

        session()->flash('info', 'El Item Presupuestario  '.$budgetItem->name.' ha sido actualizado.');

        return redirect()->route('parameters.budgetitems.index');
    }

    public function destroy(BudgetItem $budgetItem){
        //
    }

}
