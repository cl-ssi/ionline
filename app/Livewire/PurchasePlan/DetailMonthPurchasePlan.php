<?php

namespace App\Livewire\PurchasePlan;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\PurchasePlan\PurchasePlanItem;

class DetailMonthPurchasePlan extends Component
{
    public $item;

    public $quantity;

    public $quantityDetail, $quantityAcum = 0;
    
    public $january=0, $february=0, $march=0, $april=0, $may=0, $june=0, 
        $july=0, $august=0, $september=0, $october=0, $november=0, $december=0;
    
    public $januaryValue=0, $februaryValue=0, $marchValue=0, $aprilValue=0, $mayValue=0, $juneValue=0,
    $julyValue=0, $augustValue=0, $septemberValue=0, $octoberValue=0, $novemberValue=0, $decemberValue=0;

    /*, $march=0, $april=0, $may=0, $june=0, 
        $july=0, $august=0, $september=0, $october=0, $november=0, $december=0;*/

    public $disabledSave = '';

    
    public function mount(){
        if($this->item){
            $this->quantity = $this->item->quantity;

            $this->january = $this->item->january ? $this->item->january : 0;
            $this->february = $this->item->february ? $this->item->february : 0;
            $this->march = $this->item->march ? $this->item->march : 0;
            $this->april = $this->item->april ? $this->item->april : 0;
            $this->may = $this->item->may ? $this->item->may : 0;
            $this->june = $this->item->june ? $this->item->june : 0;
            $this->july = $this->item->july ? $this->item->july : 0;
            $this->august = $this->item->august ? $this->item->august : 0;
            $this->september = $this->item->september ? $this->item->september : 0;
            $this->october = $this->item->october ? $this->item->october : 0;
            $this->november = $this->item->november ? $this->item->november : 0;
            $this->december = $this->item->december ? $this->item->december : 0;

            $this->quantityDetail = $this->january + $this->february + $this->march + $this->april + $this->may +  $this->june +
                $this->july + $this->august + $this->september + $this->october + $this->november + $this->december;

            if($this->quantityDetail == 0 || $this->quantityDetail == NULL){
                $this->quantityAvailable = $this->quantity;
            }

            if($this->item->purchasePlan->hasFirstApprovalSigned()) $this->disabledSave = 'disabled';
        }
    }
    

    public function updatedJanuary($januaryValue)
    {
        if($januaryValue != ""){
            $this->januaryValue = $januaryValue;
        }
        else{
            $this->januaryValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedFebruary($februaryValue)
    {
        if($februaryValue != ""){
            $this->februaryValue = $februaryValue;
        }
        else{
            $this->februaryValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedMarch($marchValue)
    {
        if($marchValue != ""){
            $this->marchValue = $marchValue;
        }
        else{
            $this->marchValue = 0;
        }
        
        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedApril($aprilValue)
    {
        if($aprilValue != ""){
            $this->aprilValue = $aprilValue;
        }
        else{
            $this->aprilValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedMay($mayValue)
    {
        if($mayValue != ""){
            $this->mayValue = $mayValue;
        }
        else{
            $this->mayValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedJune($juneValue)
    {
        if($juneValue != ""){
            $this->juneValue = $juneValue;
        }
        else{
            $this->juneValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedJuly($julyValue)
    {
        if($julyValue != ""){
            $this->julyValue = $julyValue;
        }
        else{
            $this->julyValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedAugust($augustValue)
    {
        if($augustValue != ""){
            $this->augustValue = $augustValue;
        }
        else{
            $this->augustValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedSeptember($septemberValue)
    {
        if($septemberValue != ""){
            $this->septemberValue = $septemberValue;
        }
        else{
            $this->septemberValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedOctober($octoberValue)
    {
        if($octoberValue != ""){
            $this->octoberValue = $octoberValue;
        }
        else{
            $this->octoberValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedNovember($novemberValue)
    {
        if($novemberValue != ""){
            $this->novemberValue = $novemberValue;
        }
        else{
            $this->novemberValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function updatedDecember($decemberValue)
    {
        if($decemberValue != ""){
            $this->decemberValue = $decemberValue;
        }
        else{
            $this->decemberValue = 0;
        }

        $this->quantityDetail = $this->januaryValue + $this->februaryValue + $this->marchValue + $this->aprilValue + $this->mayValue +  $this->juneValue +
                $this->julyValue + $this->augustValue + $this->septemberValue + $this->octoberValue + $this->novemberValue + $this->decemberValue;
    }

    public function saveDetailMonth(){
        if($this->quantityDetail == $this->item->quantity){
            $purchasePlanItem = PurchasePlanItem::updateOrCreate(
                [
                    'id'        =>  $this->item->id,
                ],
                [
                    'january'   => $this->januaryValue,
                    'february'  => $this->februaryValue,
                    'march'     => $this->marchValue,
                    'april'     => $this->aprilValue,
                    'may'       => $this->mayValue,
                    'june'      => $this->juneValue,
                    'july'      => $this->julyValue,
                    'august'    => $this->augustValue,
                    'september' => $this->septemberValue,
                    'october'   => $this->octoberValue,
                    'november'  => $this->novemberValue,
                    'december'  => $this->decemberValue
                ]
            );

            return redirect()->route('purchase_plan.show', $this->item->purchasePlan->id);
        }
        else{
            Session::flash('message', 'Estimado Usuario: Favor completar la totalidad del detalle de envío o compra'); 
        }
    }

    public function render()
    {
        return view('livewire.purchase-plan.detail-month-purchase-plan');
    }
}
