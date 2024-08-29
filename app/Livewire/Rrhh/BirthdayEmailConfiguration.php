<?php

namespace App\Livewire\Rrhh;

use Livewire\Component;
use App\Models\User;
use App\Models\Rrhh\SirhActiveUser;
use Carbon\Carbon;
use DB;

use App\Models\Rrhh\BirthdayEmailConfiguration as BirthdayEmailConfigurationModel;

class BirthdayEmailConfiguration extends Component
{
    public $configuration = null;
    public $edit = false;
    public $review_users = false;
    public $subject = "";
    public $tittle = "";
    public $message = "";
    public $system_message = null;
    
    public $users_array;
    public $sirh_users_array;


    public function mount()
    {
        $this->configuration = BirthdayEmailConfigurationModel::all()->last();

        $this->subject = $this->configuration->subject;
        $this->tittle = $this->configuration->tittle;
        $this->message = $this->configuration->message;
    }

    public function edit()
    {
        $this->edit = true;
        $this->system_message = null;
    }

    public function save()
    {
        $BirthdayEmailConfiguration = BirthdayEmailConfigurationModel::all()->last();
        $BirthdayEmailConfiguration->subject = $this->subject;
        $BirthdayEmailConfiguration->tittle = $this->tittle;
        $BirthdayEmailConfiguration->message = $this->message;
        $BirthdayEmailConfiguration->save();

        $this->configuration = BirthdayEmailConfigurationModel::all()->last();
        $this->edit = false;

        $this->system_message = "Se ha registrado la información";

    }

    public function review_users(){
        if($this->review_users){
            $this->review_users = false;
        }else{
            $this->review_users = true;
        }
        
        $this->users_array = User::where('active',1)
        ->select(DB::raw('DATE_FORMAT(birthday, "2000-%m-%d") as date'),
                DB::raw('DATE_FORMAT(NOW(), "2000-%m-%d") as now'), 
                'id','name','fathers_family','dv','birthday','email_personal')
        ->whereRaw('DATE_FORMAT(birthday, "2000-%m-%d") >= DATE_FORMAT(NOW(), "2000-%m-%d")')
        ->take(10)
        ->orderBy('date','asc')
        ->get();

        // dd($this->users_array);
        
        $this->sirh_users_array = SirhActiveUser::select(DB::raw('DATE_FORMAT(birthdate, "2000-%m-%d") as date'),
                DB::raw('DATE_FORMAT(NOW(), "2000-%m-%d") as now'), 
                'id','name','email','birthdate')
        ->whereRaw('DATE_FORMAT(birthdate, "2000-%m-%d") >= DATE_FORMAT(NOW(), "2000-%m-%d")')
        ->take(10)
        ->orderBy('date', 'ASC')
        ->get();

        // dd($this->sirh_users_array);
    }

    public function cancel(){
        $this->edit = false;
    }

    public function render()
    {               
        // encuentra usuarios que están de cumpleaños el día de hoy
        // $users = User::where('active',1)
        //             ->whereMonth('birthday', Carbon::now()->format('m'))
        //             ->whereDay('birthday', Carbon::now()->format('d'))
        //             ->whereNotNull('email_personal')
        //             ->get();
        
        // $users2 = SirhActiveUser::whereMonth('birthdate', Carbon::now()->format('m'))
        //             ->whereDay('birthdate', Carbon::now()->format('d'))
        //             ->whereNotNull('email')
        //             ->get();

        // $users = User::where('id',17430005)->get();
        // dd($users->first()->checkEmailFormat());
        // dd($users,$users2);

        return view('livewire.rrhh.birthday-email-configuration');
    }
}
