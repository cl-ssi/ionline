<?php

namespace App\Http\Controllers\Allowances;

use App\Http\Controllers\Controller;
use App\Models\Allowances\Allowance;
use App\Models\Allowances\AllowanceFile;
use App\Models\Parameters\AllowanceValue;
use App\Models\Allowances\AllowanceSign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Rrhh\Authority;
use App\Notifications\Allowances\NewAllowance;
use App\Models\Parameters\Parameter;

class AllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('allowances.index');
    }

    public function all_index()
    {   
        return view('allowances.all_index');
    }

    public function sign_index()
    {   
        return view('allowances.sign_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allowanceValues = AllowanceValue::where('year', Carbon::now()->year)->get();

        return view('allowances.create', compact('allowanceValues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //SE ALMACENA VIATICO
        $allowance = new Allowance($request->All());
        $allowance->status = 'pending';
        $allowance->organizationalUnitAllowance()->associate($allowance->userAllowance->organizationalUnit);
        $allowance->allowanceEstablishment()->associate($allowance->userAllowance->organizationalUnit->establishment);
        $allowance->userCreator()->associate(Auth::user());
        $allowance->organizationalUnitCreator()->associate(Auth::user()->organizationalUnit);
        
        //CALCULO DE DIAS

        $allowance->total_days = $this->allowanceTotalDays($request);
        
        //VALOR DE VIATICO COMPLETO / MEDIO
        $value_by_degree = AllowanceValue::find($request->allowance_value_id);
        if($allowance->total_days >= 1){
            $allowance->day_value = $value_by_degree->value;
            $allowance->half_day_value = $value_by_degree->value * 0.4;
        }
        else{
            $allowance->half_day_value = $value_by_degree->value * 0.4;
        }

        //TOTAL VIÁTICO
        $allowance->total_value = $this->allowanceTotalValue($allowance);

        $allowance->save();

        // SE ALMACENAN ARCHIVOS ADJUNTOS
        if($request->has('file')){
            foreach ($request->file as $key_file => $file) {
                $allowanceFile = new AllowanceFile();
                $allowanceFile->name = $request->input('name.'.$key_file.'');
                $id_file = $key_file + 1;
                $file_name = 'id_'.$allowance->id.'_'.Carbon::now()->format('Y_m_d_H_i_s').'_'.$id_file;
                $allowanceFile->file = $file->storeAs('/ionline/allowances/allowance_docs', $file_name.'.'.$file->extension(), 'gcs');

                $allowanceFile->allowance()->associate($allowance);
                $allowanceFile->user()->associate(Auth::user());
                
                $allowanceFile->save();
            }
        }

        //CONSULTO SI EL VIATICO ES PARA UNA AUTORIDAD
        $iam_authorities = Authority::getAmIAuthorityFromOu(Carbon::now(), 'manager', $allowance->userAllowance->id);
        //AUTORIDAD
        if(!empty($iam_authorities)){
            foreach($iam_authorities as $iam_authority){

                if($allowance->userAllowance->organizationalUnit->id == $iam_authority->organizational_unit_id){

                    $level_allowance_ou = $iam_authority->organizationalUnit->level - 1;
                    $nextLevel = $iam_authority->organizationalUnit->father;
                    $position = 1;


                    for ($i = $level_allowance_ou; $i >= 2; $i--){

                        $allowance_sing = new AllowanceSign();
                        $allowance_sing->position = $position;
                        if($i >= 3){
                            $allowance_sing->event_type = 'boss';
                            if($i == $level_allowance_ou){
                                $allowance_sing->status = 'pending';
                            }
                        }
                        if($i == 2){
                            $allowance_sing->event_type = 'sub-dir or boss';
                            if($i == $level_allowance_ou){
                                $allowance_sing->status = 'pending';
                            }
                        }
                        $allowance_sing->organizational_unit_id = $nextLevel->id;
                        $allowance_sing->allowance_id = $allowance->id;

                        $allowance_sing->save();

                        $nextLevel = $allowance_sing->organizationalUnit->father;
                        $position = $position + 1;

                    }

                }
            }
        }
        //NO AUTORIDAD
        else{
            $level_allowance_ou = $allowance->organizationalUnitAllowance->level;
            $position = 1;

            for ($i = $level_allowance_ou; $i >= 2; $i--){

                $allowance_sing = new AllowanceSign();
                $allowance_sing->position = $position;

                if($i >= 3){
                    $allowance_sing->event_type = 'boss';
                    if($i == $level_allowance_ou){
                        $allowance_sing->organizational_unit_id = $allowance->organizationalUnitAllowance->id;
                        $allowance_sing->status = 'pending';
                    }
                    else{
                        $allowance_sing->organizational_unit_id = $nextLevel->id;
                    }
                    
                }
                if($i == 2){
                    $allowance_sing->event_type = 'sub-dir or boss';
                    if($i == $level_allowance_ou){
                        $allowance_sing->status = 'pending';
                    }
                    $allowance_sing->organizational_unit_id = $nextLevel->id;
                }
                
                $allowance_sing->allowance_id = $allowance->id;

                $allowance_sing->save();

                $nextLevel = $allowance_sing->organizationalUnit->father;
                $position = $position + 1;
            }
        }
        
        //SE AGREGA AL FINAL JEFE FINANZAS
        $allowance_sing_finance = new AllowanceSign();
        $allowance_sing_finance->position = $position;
        $allowance_sing_finance->event_type = 'chief financial officer';
        $allowance_sing_finance->organizational_unit_id = Parameter::where('module', 'ou')->where('parameter', 'FinanzasSSI')->first()->value;
        $allowance_sing_finance->allowance_id = $allowance->id;
        $allowance_sing_finance->save();

        //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
        $notification = Authority::getAuthorityFromDate($allowance->allowanceSigns->first()->organizational_unit_id, Carbon::now(), 'manager');
        $notification->user->notify(new NewAllowance($allowance));

        session()->flash('success', 'Estimados Usuario, se ha creado exitosamente la solicitud de viatico N°'.$allowance->id);
        return redirect()->route('allowances.index');
    }

    public function allowanceTotalDays($request){
        if($request->from == $request->to){
            return 0.5;
        }
        else{
            return Carbon::parse($request->from)->diffInDays(Carbon::parse($request->to)) + 0.5;
        }
    }

    public function allowanceTotalValue($allowance){
        $total_int_days = intval($allowance->total_days);
        if($total_int_days >= 1){
            return ($allowance->day_value * $total_int_days) + $allowance->half_day_value;
        }
        else{
            return $allowance->half_day_value;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function show(Allowance $allowance)
    {
        return view('allowances.show', compact('allowance'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function edit(Allowance $allowance)
    {
        $allowanceValues = AllowanceValue::where('year', Carbon::now()->year)->get();
        return view('allowances.edit', compact('allowance', 'allowanceValues'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Allowance $allowance)
    {
        $allowance->fill($request->All());
        
        $allowance->from_half_day = $request->has('from_half_day') ?? 0;
        $allowance->to_half_day = $request->has('to_half_day') ?? 0;
        $allowance->organizationalUnitAllowance()->associate($allowance->userAllowance->organizationalUnit);
        $allowance->establishment_id = $allowance->userAllowance->organizationalUnit->establishment->id;
        $allowance->userCreator()->associate(Auth::user());
        $allowance->organizationalUnitCreator()->associate(Auth::user()->organizationalUnit);

        $allowance->save();

        if($request->has('file')){
            foreach ($request->file as $key_file => $file) {
                $allowanceFile = new AllowanceFile();
                $allowanceFile->name = $request->input('name.'.$key_file.'');
                $id_file = $key_file + 1;
                $file_name = 'id_'.$allowance->id.'_'.Carbon::now()->format('Y_m_d_H_i_s').'_'.$id_file;
                $allowanceFile->file = $file->storeAs('/ionline/allowances/allowance_docs', $file_name.'.'.$file->extension(), 'gcs');

                $allowanceFile->allowance()->associate($allowance);
                $allowanceFile->user()->associate(Auth::user());
                
                $allowanceFile->save();
            }
        }

        //SE NOTIFICA PARA INICIAR EL PROCESO DE FIRMAS
        //$notification_ou_manager = Authority::getAuthorityFromDate($request_sing->organizational_unit_id, $date, $type);
        //$notification_ou_manager->user->notify(new NotificationSign($request_replacement));

        //NOTIFICACIONES
        // $notification_ou_manager->user->notify(new NotificationSign($request_replacement));

        session()->flash('success', 'Estimado Usuario, se ha editado exitosamente la solicitud de viatico N°'.$allowance->id);
        return redirect()->route('allowances.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Allowance  $allowance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allowance $allowance)
    {
        //
    }

    public function show_file(Allowance $allowance)
    {
        return Storage::disk('gcs')->response($allowance->signedAllowance->signed_file);
    }
}
