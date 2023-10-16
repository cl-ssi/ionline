<?php

namespace App\Http\Livewire\Resources;

use App\Http\Requests\Resources\ComputerCreateRequest;
use App\Models\Inv\Inventory;
use App\Models\Resources\Computer;
use Livewire\Component;

class ComputerCreate extends Component
{
    public $inventory;
    public $status;
    public $observations;
    public $inventory_brand;
    public $inventory_model;
    public $inventory_serial_number;
    public $computer_brand;
    public $computer_model;
    public $computer_serial_number;
    public $hostname;
    public $domain;
    public $ip;
    public $mac_address;
    public $ip_group;
    public $rack;
    public $vlan;
    public $network_segment;
    public $operating_system;
    public $processor;
    public $ram;
    public $hard_disk;
    public $intesis_id;
    public $comment;
    public $active_type;
    public $office_serial;
    public $windows_serial;
    public $labels;

    protected $listeners = [
        'myLabelId'
    ];

    public function mount(Inventory $inventory)
    {
        $this->number_inventory = $inventory->number;
        $this->status = $inventory->status;
        $this->observations = $inventory->observations;
        $this->inventory_brand = $inventory->brand;
        $this->inventory_model = $inventory->model;
        $this->inventory_serial_number = $inventory->serial_number;
        $this->labels = collect([]);
    }

    public function rules()
    {
        return (new ComputerCreateRequest($this->inventory))->rules();
    }

    public function render()
    {
        return view('livewire.resources.computer-create')->extends('layouts.bt4.app');
    }

    public function create()
    {
        $dataValidated = $this->validate();

        $dataInventory = $dataValidated;
        $dataComputer = $dataValidated;

        $dataInventory['number'] = $this->number_inventory;
        $dataInventory['serial_number'] = $this->inventory_serial_number;
        $dataInventory['brand'] = $this->inventory_brand;
        $dataInventory['model'] = $this->inventory_model;

        $dataComputer['inventory_number'] = $this->number_inventory;
        $dataComputer['serial'] = $this->inventory_serial_number;
        $dataComputer['brand'] = $this->inventory_brand;
        $dataComputer['model'] = $this->inventory_model;
        $dataComputer['fusion_at'] = now();
        $dataComputer['inventory_id'] = $this->inventory->id;

        $this->inventory->update($dataInventory);

        $computer = Computer::create($dataComputer);
        $computer->labels()->sync($this->labels);

        session()->flash('success', 'El recurso TIC fue creado exitosamente.');
        return redirect()->route('resources.tic');
    }

    public function myLabelId($values)
    {
        $this->labels = $values;
    }
}
