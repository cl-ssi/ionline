<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Program;
use App\Http\Controllers\Controller;
use App\Models\Agreements\BudgetAvailability;
use App\Models\Documents\Document;
use App\Models\Documents\Type;
use Illuminate\Http\Request;

class BudgetAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $program = Program::findOrFail($request->program_id);
        $program->budget_availabilities()->create(array_merge($request->all(), ['referrer_id' => auth()->id()]));

        session()->flash('info', 'La nueva disponibilidad presupuestaria ha sido creada con éxito');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agreements\BudgetAvailability  $budgetAvailability
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetAvailability $budgetAvailability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agreements\BudgetAvailability  $budgetAvailability
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetAvailability $budgetAvailability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agreements\BudgetAvailability  $budgetAvailability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BudgetAvailability $budgetAvailability)
    {
        $budgetAvailability->update($request->all());

        session()->flash('info', 'La disponibilidad presupuestaria #'.$budgetAvailability->id.' ha sido actualizado.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agreements\BudgetAvailability  $programResolutionId
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetAvailability $budgetAvailability)
    {
        $budgetAvailability->delete();

        session()->flash('success', 'La resolución se ha dado de baja satisfactoriamente');
        return redirect()->back();
    }

    public function createDocument(BudgetAvailability $budgetAvailability)
    {
        $budgetAvailability->load('program');
        $first_word = explode(' ',trim($budgetAvailability->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($budgetAvailability->program->name," "), 1) : $budgetAvailability->program->name;
        $fecha = $this->formatDate($budgetAvailability->res_minsal_date);
        $year = $budgetAvailability->date->format('Y');

        $document = new Document();
        $document->budget_availability_id = $budgetAvailability->id;
        $document->date = $budgetAvailability->date;
        $document->type_id = Type::where('name','Certificado Disponibilidad Presupuestaria')->first()->id;
        $document->subject = 'Certificado disponibilidad presupuestaria '.$year.' para Convenio programa '.$programa;
        $document->distribution = "blanca.galaz@redsalud.gob.cl";
        $document->content = "
        <p style='text-align: center;'><strong>CERTIFICADO DE DISPONIBILIDAD PRESUPUESTARIA</strong></p>
<p>&nbsp;</p>
<p style='text-align: justify;'>De conformidad a lo dispuesto en el Decreto Ley N&deg;2.763/79.- Org&aacute;nico de la
    administraci&oacute;n Financiera del Estado, Ley <strong>N&deg;21.516</strong> del Ministerio de Hacienda, que
    aprueba el presupuesto del Sector Publico para el a&ntilde;o ".$year.", y Resoluci&oacute;n Exenta N&deg;".$budgetAvailability->res_minsal_number." de fecha ".$fecha." del Ministerio de Salud el cual aprueba el presupuesto para el <strong>PROGRAMA
        &ldquo;".mb_strtoupper($programa)."&rdquo; a&ntilde;o ".$year."</strong>, desde el 1 de Enero al 31 de Diciembre del a&ntilde;o ".$year."
    certifica que el Servicio de salud de Tarapac&aacute;, Cuenta con el presupuesto a nivel de subtitulo 21, 22 y 24
    para el financiamiento del Programa indicado.</p>
<p style='text-align: justify;'>&nbsp;</p>
<table style='border-collapse: collapse; width: 100%; height: 105.667px;' border='1'>
    <tbody>
        <tr style='height: 30px;'>
            <td style='width: 24.8563%; text-align: center; height: 30px;'><strong>SUBT&Iacute;TULO</strong></td>
            <td style='width: 29.7046%; text-align: center; height: 30px;'><strong>MONTO</strong></td>
            <td style='width: 45.3141%; text-align: center; height: 30px;'><strong>PROGRAMA</strong></td>
        </tr>
        <tr style='height: 30px;'>
            <td style='width: 24.8563%; text-align: center; height: 30px;'>21</td>
            <td style='width: 29.7046%; height: 30px;'>&nbsp;</td>
            <td style='width: 45.3141%; height: 30px;'>&nbsp;</td>
        </tr>
        <tr style='height: 30px;'>
            <td style='width: 24.8563%; text-align: center; height: 30px;'>22</td>
            <td style='width: 29.7046%; height: 30px;'>&nbsp;</td>
            <td style='width: 45.3141%; height: 30px;'>&nbsp;</td>
        </tr>
        <tr style='height: 30px;'>
            <td style='width: 24.8563%; text-align: center; height: 30px;'>24</td>
            <td style='width: 29.7046%; height: 30px;'>&nbsp;</td>
            <td style='width: 45.3141%; height: 30px;'>&nbsp;</td>
        </tr>
    </tbody>
</table>
<p>&nbsp;</p>
<p>Detalle distribuci&oacute;n subt&iacute;tulo 24:</p>
<table style='margin-left: auto; margin-right: auto;' border='1' width='245' cellspacing='0' cellpadding='0'>
    <tbody>
        <tr style='background: grey;'>
            <td width='136'>
                <p style='text-align: center;'><strong>COMUNA</strong></p>
            </td>
            <td width='109'>
                <p style='text-align: center;'><strong>MONTO</strong></p>
            </td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>ALTO HOSPICIO</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>CAMI&Ntilde;A</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>COLCHANE</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>HUARA</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>IQUIQUE</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>PICA</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr>
            <td style='text-align: center;' width='136'>
                <p>POZO ALMONTE</p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
        <tr style='background: grey;'>
            <td style='text-align: center;' width='136'>
                <p><strong>TOTAL</strong></p>
            </td>
            <td style='text-align: center;' width='109'>&nbsp;</td>
        </tr>
    </tbody>
</table>
        ";

        $types = Type::whereNull('partes_exclusive')->pluck('name','id');
        return view('documents.create', compact('document', 'types'));
    }

    public function formatDate($date)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('j', strtotime($date)).' de '.$meses[date('n', strtotime($date))-1].' del año '.date('Y', strtotime($date));
    }
}
