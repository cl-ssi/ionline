<?php

namespace App\Http\Controllers\Agreements;

use Illuminate\Http\Request;
use App\Agreements\Agreement;
use App\Agreements\Program;
use App\Agreements\ProgramComponent;
use App\Agreements\Stage;
use App\Agreements\AgreementAmount;
use App\Agreements\AgreementQuota;
use App\Agreements\OpenTemplateProcessor;
use App\Agreements\MyClass;
use App\Models\Commune;
use App\Municipality;
use App\Establishment;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Luecano\NumeroALetras\NumeroALetras;
use PhpOffice\PhpWord\Settings;
use PhpOffice;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;


class WordTestController extends Controller
{
    public function createWordDocx($id)
    {
    	// SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    	$agreements     = Agreement::with('Program','Commune','agreement_amounts')->where('id', $id)->first();
    	$stage          = Stage::where('agreement_id', $id)->first();
    	$components     = ProgramComponent::where('program_id', $agreements->program_id)->get();
    	$amounts        = AgreementAmount::with('program_component')->Where('agreement_id', $id)->get();
        $quotas         = AgreementQuota::Where('agreement_id', $id)->get();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        //dd($municipality);
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");



        // AL MOMENTO DE PREVISUALIZAR EL DOCUMENTO INICIA AUTOMATICAMENTE LA PRIMERA ETAPA
        if(is_null($stage)){
        $agreements->stages()->create(['agreement_id' => $id,'group' => 'CON','type' => 'RTP', 'date' => Carbon::now()->toDateTimeString()]);
         }

        // SE OBTIENE LAS INSTITUCIONES DE SALUD PERO SÓLO LAS QUE SE HAN SELECCIONADO
        $establishment_list = unserialize($agreements->establishment_list) == null ? [] : unserialize($agreements->establishment_list);
        $establishments = Establishment::where('commune_id', $agreements->Commune->id)
                                       ->whereIn('id', $establishment_list)->get();

        // ARRAY PARA OBTNER LAS INSTITUCIONES ASOCIADAS AL CONVENIO
        // SI EL ARRAY DE INSTITUCIONES VIENE VACIO
        if($establishments->isEmpty()){
            $arrayEstablishmentConcat = '';
        }
        else { 
            foreach ($establishments as $key => $establishment) {
                $arrayEstablishment[] = array('index' => $key+1
                                             ,'establecimientoTipo' => $establishment->type
                                             ,'establecimientoNombre' => $establishment->name
                                             ,'establecimiento' => ucwords(strtolower($establishment->type))." ".$establishment->name
                                         );
            }
                $arrayEstablishmentConcat = implode(", ",array_column($arrayEstablishment, 'establecimiento',));
        }


    	// ARRAY PARA OBTENER LOS COMPONENTES ASOCIADOS AL CONVENIO
    	foreach ($amounts as $key => $amount) {
			$arrayComponent[] = array('index' => $key+1, 'componenteNombre' => $amount->program_component->name);
    	}

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $formatter->toMoney($totalConvenio,0, 'pesos','');
 
        // ARRAY PARA OBTENER LAS CUOTAS ASOCIADAS AL TOTAL DEL CONVENIO
        foreach ($quotas as $key => $quota) {
                $cuotaConvenioLetras = $formatter->toMoney($quota->amount,0, 'pesos','');
                $arrayQuota[] = array('index' => ($this->ordinal($key+1))
                                      ,'cuotaDescripcion' => $quota->description
                                      ,'cuotaMonto' => number_format($quota->amount,0,",",".")
                                      ,'cuotaLetra' => $cuotaConvenioLetras);
             } 

             //dd($arrayQuota);
    	

    	$templateProcesor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/convenio.docx'));

    	$periodoConvenio = $agreements->period;
    	$fechaConvenio = $agreements->date;
        $fechaConvenio = date('j', strtotime($fechaConvenio)).' de '.$meses[date('n', strtotime($fechaConvenio))-1].' '.date('Y', strtotime($fechaConvenio));
    	$numResolucion = $agreements->number;
    	$fechaResolucion = $agreements->resolution_date;
    	$referente = $agreements->referente;
        $alcaldeApelativo = $municipality->appellative_representative;
        $alcalde = $municipality->name_representative;
        $alcaldeDecreto = $municipality->decree_representative;
    	$municipalidad = $municipality->name_municipality;
        //dd($municipalidad);
    	$municipalidadDirec = $municipality->adress_municipality;
    	$comunaRut = $municipality->rut_municipality;
    	$alcaldeRut = $municipality->rut_representative;

    	$comuna = $agreements->Commune->name; 
        $programa = $agreements->Program->name;

		$templateProcesor->setValue('programa',$programa);
		$templateProcesor->setValue('periodoConvenio',$periodoConvenio);
		$templateProcesor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
		$templateProcesor->setValue('numResolucion',$numResolucion);
		$templateProcesor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
		$templateProcesor->setValue('totalConvenioLetras',$totalConvenioLetras);
		$templateProcesor->setValue('fechaResolucion',$fechaResolucion);
		$templateProcesor->setValue('comuna',$comuna);
		$templateProcesor->setValue('comunaRut',$comunaRut);
		$templateProcesor->setValue('municipalidad',$municipalidad);
		$templateProcesor->setValue('municipalidadDirec',$municipalidadDirec);
		$templateProcesor->setValue('alcaldeApelativo',$alcaldeApelativo);
        $templateProcesor->setValue('alcalde',$alcalde);
		$templateProcesor->setValue('alcaldeRut',$alcaldeRut);
        $templateProcesor->setValue('alcaldeDecreto',$alcaldeDecreto);

        // CLONE BLOCK PARA LISTAR COMPONENTES
        $templateProcesor->cloneBlock('componentesListado', 0, true, false,$arrayComponent);
        // CLONE BLOCK PARA LISTAR CUOTAS
        $templateProcesor->cloneBlock('cuotasListado', 0, true, false,$arrayQuota);

        $templateProcesor->setValue('establecimientosListado',$arrayEstablishmentConcat);

    	$filename = "archivo";
    	$templateProcesor->saveAs(storage_path('app/public/Prev-Conv.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

    	return response()->download(storage_path('app/public/Prev-Conv.docx'))->deleteFileAfterSend(true);
    }

    public function createResWordDocx($id)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
        $agreements     = Agreement::with('Program','Commune','agreement_amounts')->where('id', $id)->first();
        $stage          = Stage::where('agreement_id', $id)->first();
        $components     = ProgramComponent::where('program_id', $agreements->program_id)->get();
        $amounts        = AgreementAmount::with('program_component')->Where('agreement_id', $id)->get();
        $quotas         = AgreementQuota::Where('agreement_id', $id)->get();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $file = $agreements->file;
        $file = Storage::disk('')->path($agreements->file);

        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        // SE OBTIENE LAS INSTITUCIONES DE SALUD PERO SÓLO LAS QUE SE HAN SELECCIONADO
        $establishment_list = unserialize($agreements->establishment_list) == null ? [] : unserialize($agreements->establishment_list);
        $establishments = Establishment::where('commune_id', $agreements->Commune->id)
                                       ->whereIn('id', $establishment_list)->get();

        // ARRAY PARA OBTNER LAS INSTITUCIONES ASOCIADAS AL CONVENIO
        // SI EL ARRAY DE INSTITUCIONES VIENE VACIO
        if($establishments->isEmpty()){
            $arrayEstablishmentConcat = '';
        }
        else { 
            foreach ($establishments as $key => $establishment) {
                $arrayEstablishment[] = array('index' => $key+1
                                             ,'establecimientoTipo' => $establishment->type
                                             ,'establecimientoNombre' => $establishment->name
                                             ,'establecimiento' => ucwords(strtolower($establishment->type))." ".$establishment->name
                                         );
            }
                $arrayEstablishmentConcat = implode(", ",array_column($arrayEstablishment, 'establecimiento',));
        }


        // ARRAY PARA OBTENER LOS COMPONENTES ASOCIADOS AL CONVENIO
        foreach ($amounts as $key => $amount) {
            $arrayComponent[] = array('index' => $key+1, 'componenteNombre' => $amount->program_component->name);
        }

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $formatter->toMoney($totalConvenio,0, 'pesos','');
 
        // ARRAY PARA OBTENER LAS CUOTAS ASOCIADAS AL TOTAL DEL CONVENIO
        foreach ($quotas as $key => $quota) {
                $cuotaConvenioLetras = $formatter->toMoney($quota->amount,0, 'pesos','');
                $arrayQuota[] = array('index' => ($this->ordinal($key+1))
                                      ,'cuotaDescripcion' => $quota->description
                                      ,'cuotaMonto' => number_format($quota->amount,0,",",".")
                                      ,'cuotaLetra' => $cuotaConvenioLetras);
             } 

             //dd($arrayQuota);
        
        // TEMPLATE EXAMPLE INNER MERGE

            $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionhead.docx'));

            $midTemplateProcessor = new OpenTemplateProcessor($file);


            $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionfooter.docx'));

        
            //dd($midTemplateProcessor);
            //$mainTemplateProcessor ->setValue('var_name', $value);
        $periodoConvenio = $agreements->period;
        $fechaConvenio = $agreements->date;
        $fechaConvenio = date('j', strtotime($fechaConvenio)).' de '.$meses[date('n', strtotime($fechaConvenio))-1].' '.date('Y', strtotime($fechaConvenio));
        $numResolucion = $agreements->number;
        $fechaResolucion = $agreements->resolution_date;
        $referente = $agreements->referente;
        $alcaldeApelativo = $municipality->appellative_representative;
        $alcalde = $municipality->name_representative;
        $alcaldeDecreto = $municipality->decree_representative;
        $municipalidad = $municipality->name_municipality;
        //dd($municipalidad);
        $municipalidadDirec = $municipality->adress_municipality;
        $comunaRut = $municipality->rut_municipality;
        $alcaldeRut = $municipality->rut_representative;

        $comuna = $agreements->Commune->name; 
        $programa = $agreements->Program->name;

        $mainTemplateProcessor->setValue('programa',$programa);
        $mainTemplateProcessor->setValue('periodoConvenio',$periodoConvenio);
        $mainTemplateProcessor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
        $mainTemplateProcessor->setValue('numResolucion',$numResolucion);
        $mainTemplateProcessor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
        $mainTemplateProcessor->setValue('totalConvenioLetras',$totalConvenioLetras);
        $mainTemplateProcessor->setValue('fechaResolucion',$fechaResolucion);
        $mainTemplateProcessor->setValue('comuna',$comuna);
        $mainTemplateProcessor->setValue('comunaRut',$comunaRut);
        $mainTemplateProcessor->setValue('municipalidad',$municipalidad);
        $mainTemplateProcessor->setValue('municipalidadDirec',$municipalidadDirec);
        $mainTemplateProcessor->setValue('alcaldeApelativo',$alcaldeApelativo);
        $mainTemplateProcessor->setValue('alcalde',$alcalde);
        $mainTemplateProcessor->setValue('alcaldeRut',$alcaldeRut);
        $mainTemplateProcessor->setValue('alcaldeDecreto',$alcaldeDecreto);


        $mainTemplateProcessorEnd->setValue('comuna',$comuna);
       
        // TEMPLATE MERGE
        //$innerTemplateProcessor = new OpenTemplateProcessor('path/to/other_file');
        //$innerTemplateProcessor->setValue('var2_name', $value2);

        // extract internal xml from template that will be merged inside main template
        $innerXml = $midTemplateProcessor->tempDocumentMainPart;
        $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);

        // remove tag containing header, footer, images
        $innerXml = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $innerXml);
        //dd($midTemplateProcessor->tempDocumentMainPart);

        $mainXmlEnd = $mainTemplateProcessorEnd->tempDocumentMainPart;

        $mainXmlEnd = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $mainXmlEnd);

        // remove tag containing header, footer, images
        $mainXmlEnd = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $mainXmlEnd);

        // inject internal xml inside main template 
        $mainXml = $mainTemplateProcessor->tempDocumentMainPart;
        

           // dd($mainXml);

        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br w:type="page" /><w:lastRenderedPageBreak/></w:r></w:p>' . $innerXml . '</w:body>', $mainXml);
        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br w:type="page" /><w:lastRenderedPageBreak/></w:r></w:p>' . $mainXmlEnd . '</w:body>', $mainXml);


        $mainTemplateProcessor->__set('tempDocumentMainPart', $mainXml);

        // END TEMPLATE MERGE

        $filename = "archivo";
        $mainTemplateProcessor->saveAs(storage_path('app/public/Prev-Resolucion.docx')); //'Prev-RESOL'.$numResolucion.'.docx'
       

        return response()->download(storage_path('app/public/Prev-Resolucion.docx'))->deleteFileAfterSend(true);
    }


    public function ordinal($n){
        $ordinales = array('primera','segunda','tercera','cuarta','quinta','sexta','septima','octava','novena','decima','onceava','doceava');

        if ($n<=count ($ordinales)){
            return $ordinales[$n-1];
        }
        return $n.'-esimo';
    }

}
