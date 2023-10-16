<?php

namespace App\Http\Livewire\Resources;

use App\Http\Requests\Resources\ComputerFusionRequest;
use App\Models\Inv\Inventory;
use App\Models\Resources\Computer;
use Livewire\Component;

class ComputerFusion extends Component
{
    public $computer;
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

    public function mount(Computer $computer, Inventory $inventory)
    {
        $this->number_inventory = $inventory->number;
        $this->status = $inventory->status;
        $this->observations = $inventory->observations;
        $this->inventory_brand = $inventory->brand;
        $this->inventory_model = $inventory->model;
        $this->inventory_serial_number = $inventory->serial_number;
        $this->computer_brand = $computer->brand;
        $this->computer_model = $computer->model;
        $this->computer_serial_number = $computer->serial;
        $this->hostname = $computer->hostname;
        $this->domain = $computer->domain;
        $this->ip = $computer->ip;
        $this->mac_address = $computer->mac_address;
        $this->ip_group = $computer->ip_group;
        $this->rack = $computer->rack;
        $this->vlan = $computer->vlan;
        $this->network_segment = $computer->network_segment;
        $this->operating_system = $computer->operating_system;
        $this->processor = $computer->processor;
        $this->ram = $computer->ram;
        $this->hard_disk = $computer->hard_disk;
        $this->intesis_id = $computer->intesis_id;
        $this->comment = $computer->comment;
        $this->active_type = $computer->active_type;
        $this->office_serial = $computer->office_serial;
        $this->windows_serial = $computer->windows_serial;
        $this->labels = $computer->labels;
    }

    public function rules()
    {
        return (new ComputerFusionRequest($this->inventory, $this->computer))->rules();
    }

    public function render()
    {
        return view('livewire.resources.computer-fusion')->extends('layouts.bt4.app');
    }

    public function update()
    {
        $dataValidated = $this->validate();
        $dataInventory = $dataValidated;
        $dataComputer = $dataValidated;

        $dataInventory['number'] = $this->number_inventory;
        $dataInventory['serial_number'] = $this->inventory_serial_number;
        $dataInventory['brand'] = $this->inventory_brand;
        $dataInventory['model'] = $this->inventory_model;

        $dataComputer['serial'] = $this->inventory_serial_number;
        $dataComputer['brand'] = $this->inventory_brand;
        $dataComputer['model'] = $this->inventory_model;

        if($this->computer->fusion_at == null)
        {
            $dataComputer['fusion_at'] = now();
            $dataComputer['inventory_id'] = $this->inventory->id;
            $message = "La fusion del recurso TIC fue realizada exitosamente.";
            $route = "resources.tic";
        }
        else
        {
            $message = "La actualización del recurso TIC fue realizada exitosamente.";
            $route = "resources.computer.index";
        }

        $this->inventory->update($dataInventory);
        $this->computer->update($dataComputer);
        $this->computer->labels()->sync($this->labels);

        session()->flash('success', $message);
        return redirect()->route($route);
    }

    public function myLabelId($values)
    {
        $this->labels = $values;
    }
}
