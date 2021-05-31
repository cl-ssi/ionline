<?php

namespace App\Http\Controllers\Agreements;

use App\Agreements\Addendum;
use Illuminate\Http\Request;
use App\Agreements\Agreement;
use App\Agreements\Program;
use App\Agreements\ProgramComponent;
use App\Agreements\Stage;
use App\Agreements\AgreementAmount;
use App\Agreements\AgreementQuota;
use App\Agreements\OpenTemplateProcessor;
use App\Agreements\MyClass;
use App\Agreements\Signer;
use App\Models\Commune;
use App\Municipality;
use App\Establishment;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Rrhh\Authority;
use Luecano\NumeroALetras\NumeroALetras;
use PhpOffice\PhpWord\Settings;
use PhpOffice;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class WordTestController extends Controller
{
    public function createWordDocx($id)
    {
    	// SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    	$agreements     = Agreement::with('Program','Commune','agreement_amounts','authority')->where('id', $id)->first();
    	$stage          = Stage::where('agreement_id', $id)->first();
    	// $components     = ProgramComponent::where('program_id', $agreements->program_id)->get();
    	$amounts        = AgreementAmount::with('program_component')->Where('agreement_id', $id)->get();
        $quotas         = AgreementQuota::Where('agreement_id', $id)->get();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

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
                                             ,'establecimiento' => ucwords(mb_strtolower($establishment->type))." ".$establishment->name
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
        $formatter->apocope = true;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));
 
        // ARRAY PARA OBTENER LAS CUOTAS ASOCIADAS AL TOTAL DEL CONVENIO
        foreach ($quotas as $key => $quota) {
                $cuotaConvenioLetras = $this->correctAmountText($formatter->toMoney($quota->amount,0, 'pesos',''));
                $arrayQuota[] = array('index' => ($this->ordinal($key+1))
                                      ,'cuotaDescripcion' => $quota->description . ($key+1 == 1 ? ' del total de los recursos del convenio una vez aprobada la resolución exenta que aprueba el presente instrumento y recibidos los recursos del Ministerio de Salud.' : ' restante del total de recursos y se enviará en el mes de octubre, según resultados obtenidos en la primera evaluación definida en la cláusula anterior. Así también, dependerá de la recepción de dichos recursos desde Ministerio de Salud y existencia de rendición financiera según lo establece la resolución N°30 del año 2015, de la Contraloría General de la República que fija normas sobre procedimiento de rendición de cuentas de la Contraloría General de la Republica, por parte de la “MUNICIPALIDAD”.')
                                      ,'cuotaMonto' => number_format($quota->amount,0,",",".")
                                      ,'cuotaLetra' => $cuotaConvenioLetras);
             } 

        $totalQuotas = mb_strtolower($formatter->toMoney(count($quotas),0));

    	$templateProcesor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/convenio2021.docx'));

    	$periodoConvenio = $agreements->period;
    	// $fechaConvenio = $agreements->date;
        $fechaConvenio = date('j', strtotime($agreements->date)).' de '.$meses[date('n', strtotime($agreements->date))-1].' del año '.date('Y', strtotime($agreements->date));
    	$numResolucion = $agreements->number;
        $fechaResolucion = $agreements->resolution_date;
        $fechaResolucion = $fechaResolucion != NULL ? date('j', strtotime($fechaResolucion)).' de '.$meses[date('n', strtotime($fechaResolucion))-1].' del año '.date('Y', strtotime($fechaResolucion)) : '';
    	// $referente = $agreements->referente;
        $alcaldeApelativo = $agreements->representative_appelative;
        $alcalde = $agreements->representative;
        $alcaldeDecreto = $agreements->representative_decree;
    	$municipalidad = $municipality->name_municipality;
    	$ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'ILUSTRE': null;
    	$municipalidadDirec = $agreements->municipality_adress;
    	$comunaRut = $agreements->municipality_rut;
    	$alcaldeRut = $agreements->representative_rut;

    	$comuna = $agreements->Commune->name;
        $first_word = explode(' ',trim($agreements->Program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($agreements->Program->name," "), 1) : $agreements->Program->name;

        $totalEjemplares = Str::contains($municipality->name_municipality, 'IQUIQUE') ? 'cuatro': 'tres';
        $addEjemplar = Str::contains($municipality->name_municipality, 'IQUIQUE') ? 'un ejemplar para CORMUDESI': null;

        //Director
        //construir nombre director
        $first_name = explode(' ',trim($agreements->authority->user->name))[0];
        $director = mb_strtoupper($first_name . ' ' . $agreements->authority->user->fathers_family . ' ' . $agreements->authority->user->mothers_family);
        $directorApelativo = $agreements->authority->position;
        $directorRut = mb_strtoupper($agreements->authority->user->runFormat());
        $directorDecreto = $agreements->authority->decree;
        $directorNationality = Str::contains($agreements->authority->position, 'a') ? 'chilena' : 'chileno';

		$templateProcesor->setValue('programa',$agreements->Program->name);
		$templateProcesor->setValue('programaTitulo',mb_strtoupper($programa));
		$templateProcesor->setValue('periodoConvenio',$periodoConvenio);
		$templateProcesor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
		$templateProcesor->setValue('numResolucion',$numResolucion);
		$templateProcesor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
		$templateProcesor->setValue('totalConvenioLetras',$totalConvenioLetras);
		$templateProcesor->setValue('totalQuotas',$totalQuotas);
		$templateProcesor->setValue('fechaResolucion',$fechaResolucion);
		$templateProcesor->setValue('comuna',$comuna);
        $templateProcesor->setValue('comunaRut',$comunaRut);
        $templateProcesor->setValue('ilustre',ucfirst(mb_strtolower($ilustre)));
        $templateProcesor->setValue('ilustreTitulo',$ilustre);
		$templateProcesor->setValue('municipalidad',$municipalidad);
		$templateProcesor->setValue('municipalidadDirec',$municipalidadDirec);
		$templateProcesor->setValue('alcaldeApelativo',$alcaldeApelativo);
        $templateProcesor->setValue('alcalde',mb_strtoupper($alcalde));
		$templateProcesor->setValue('alcaldeRut',$alcaldeRut);
        $templateProcesor->setValue('alcaldeDecreto',$alcaldeDecreto);
        $templateProcesor->setValue('totalEjemplares',$totalEjemplares);
        $templateProcesor->setValue('addEjemplar',$addEjemplar);
        $templateProcesor->setValue('director',$director);
        $templateProcesor->setValue('directorApelativo',$directorApelativo);
        $templateProcesor->setValue('directorRut',$directorRut);
        $templateProcesor->setValue('directorDecreto',$directorDecreto);
        $templateProcesor->setValue('directorNationality',$directorNationality);

        // CLONE BLOCK PARA LISTAR COMPONENTES
        if(env('APP_ENV') == 'local') ini_set("pcre.backtrack_limit", -1);
        $templateProcesor->cloneBlock('componentesListado', 0, true, false,$arrayComponent);
        // CLONE BLOCK PARA LISTAR CUOTAS
        $templateProcesor->cloneBlock('cuotasListado', 0, true, false,$arrayQuota);

        $templateProcesor->setValue('establecimientosListado',$arrayEstablishmentConcat);

    	$templateProcesor->saveAs(storage_path('app/public/Prev-Conv.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

    	return response()->download(storage_path('app/public/Prev-Conv.docx'))->deleteFileAfterSend(true);
    }

    public function createResWordDocx(Request $request, $id)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
        $agreements     = Agreement::with('Program','Commune','agreement_amounts','authority', 'referrer')->where('id', $id)->first();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $file           = Storage::disk('')->path($agreements->file);
        $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio, 0, 'pesos',''));
        
        // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
        $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionhead.docx'));
        $midTemplateProcessor = new OpenTemplateProcessor($file); //convenio doc
        $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionfooter.docx'));

        // Parametros a imprimir en los archivos abiertos
        $periodoConvenio = $agreements->period;
        $fechaConvenio = date('j', strtotime($agreements->date)).' de '.$meses[date('n', strtotime($agreements->date))-1].' del '.date('Y', strtotime($agreements->date));
    	$numResolucion = $agreements->number;
        $yearResolucion = $agreements->resolution_date != NULL ? date('Y', strtotime($agreements->resolution_date)) : '';
        $fechaResolucion = $agreements->resolution_date != NULL ? date('j', strtotime($agreements->resolution_date)).' de '.$meses[date('n', strtotime($agreements->resolution_date))-1].' del '.date('Y', strtotime($agreements->resolution_date)) : '';
        $numResourceResolucion = $agreements->res_resource_number;
        $yearResourceResolucion = $agreements->res_resource_date != NULL ? date('Y', strtotime($agreements->res_resource_date)) : '';
        $fechaResourceResolucion = $agreements->res_resource_date != NULL ? date('j', strtotime($agreements->res_resource_date)).' de '.$meses[date('n', strtotime($agreements->res_resource_date))-1].' del '.date('Y', strtotime($agreements->res_resource_date)) : '';
    	$ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre': null;
        $emailMunicipality = $municipality->email_municipality;
        $comuna = $agreements->Commune->name; 
        $first_word = explode(' ',trim($agreements->Program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($agreements->Program->name," "), 1) : $agreements->Program->name;
        
        //Director ssi quien firma a la fecha de hoy
        // $director_signature = Authority::getAuthorityFromDate(1, Carbon::now()->toDateTimeString(), 'manager');
        $director_signature = Signer::find($request->signer_id);
        $first_name = explode(' ',trim($director_signature->user->name))[0];
        $director = mb_strtoupper($first_name . ' ' . $director_signature->user->fathers_family . ' ' . $director_signature->user->mothers_family);
        $directorDecreto = $director_signature->decree;
        $directorApelativo = mb_strtoupper($director_signature->appellative);

        //email referente
        $emailReferrer = $agreements->referrer != null ? $agreements->referrer->email : '';

        $mainTemplateProcessor->setValue('directorDecreto',$directorDecreto);
        $mainTemplateProcessor->setValue('numResolucion',$numResolucion);
        $mainTemplateProcessor->setValue('yearResolucion',$yearResolucion);
        $mainTemplateProcessor->setValue('programa',$programa);
        $mainTemplateProcessor->setValue('numResourceResolucion',$numResourceResolucion);
        $mainTemplateProcessor->setValue('yearResourceResolucion',$yearResourceResolucion);
        $mainTemplateProcessor->setValue('fechaResolucion',$fechaResolucion);
        $mainTemplateProcessor->setValue('fechaResourceResolucion',$fechaResourceResolucion);
        $mainTemplateProcessor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
        $mainTemplateProcessor->setValue('ilustreTitulo',$ilustre);
        $mainTemplateProcessor->setValue('comuna',$comuna);
        $mainTemplateProcessor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
        $mainTemplateProcessor->setValue('totalConvenioLetras',$totalConvenioLetras);

        $mainTemplateProcessorEnd->setValue('programa',$programa);
        $mainTemplateProcessorEnd->setValue('periodoConvenio',$periodoConvenio);
        $mainTemplateProcessorEnd->setValue('ilustreTitulo',$ilustre);
        $mainTemplateProcessorEnd->setValue('comuna',$comuna);
        $mainTemplateProcessorEnd->setValue('director',$director);
        $mainTemplateProcessorEnd->setValue('directorApelativo',$directorApelativo);
        $mainTemplateProcessorEnd->setValue('emailMunicipality',$emailMunicipality);
        $mainTemplateProcessorEnd->setValue('emailReferrer',$emailReferrer);
       
        // TEMPLATE MERGE
        // extract internal xml from template that will be merged inside main template
        $innerXml = $midTemplateProcessor->tempDocumentMainPart;
        $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);
        
        // remove tag containing header, footer, images
        // $innerXml = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $innerXml);
        
        //remove signature blocks
        $innerXml = Str::beforeLast($innerXml, 'Reforzamiento Municipal del Presupuesto');
        // dd($innerXml);
        $innerXml .= 'Reforzamiento Municipal del Presupuesto vigente del Servicio de Salud Iquique año 2021”.</w:t></w:r></w:p>';
        
        $mainXmlEnd = $mainTemplateProcessorEnd->tempDocumentMainPart;

        $mainXmlEnd = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $mainXmlEnd);

        // remove tag containing header, footer, images
        // $mainXmlEnd = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $mainXmlEnd);

        // inject internal xml inside main template 
        $mainXml = $mainTemplateProcessor->tempDocumentMainPart;
 
        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $innerXml . '</w:body>', $mainXml);
        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $mainXmlEnd . '</w:body>', $mainXml);

        $mainTemplateProcessor->__set('tempDocumentMainPart', $mainXml);

        // END TEMPLATE MERGE
        $mainTemplateProcessor->saveAs(storage_path('app/public/Prev-Resolucion.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

        return response()->download(storage_path('app/public/Prev-Resolucion.docx'))->deleteFileAfterSend(true);
    }

    public function createWordDocxAddendum(Request $request, Addendum $addendum, $type)
    {
        $addendum->load('agreement.program','agreement.commune', 'referrer', 'director_signer.user');
        $municipality   = Municipality::where('commune_id', $addendum->agreement->commune->id)->first();

        if($type == 'addendum'){
    	    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/addendum2021.docx'));
        } else { // Resolucion Addedum
            // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
            $templateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionaddendumhead.docx'));
            $midTemplateProcessor = new OpenTemplateProcessor(Storage::disk('')->path($addendum->file)); //addendum doc
            $templateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionaddendumfooter.docx'));
            // Se asigna director quien firma la resolución, no necesariamente tiene que ser el mismo quien firmó el addendum
            $addendum->director_signer = Signer::with('user')->find($request->signer_id);
            // No se guarda los cambios en el addendum ya que es solo para efectos de generar el documento
        }

        $first_word = explode(' ',trim($addendum->agreement->program->name))[0];
        $programa = $first_word == 'Programa' ? substr(strstr($addendum->agreement->program->name," "), 1) : $addendum->agreement->program->name;
        $ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'ILUSTRE': null;
        $municipalidad = $municipality->name_municipality;
        $fechaAddendum = $this->formatDate($addendum->date);
        $fechaConvenio = $this->formatDate($addendum->agreement->date);
        $fechaResolucionConvenio = $this->formatDate($addendum->agreement->res_exempt_date);
        $directorApelativo = $addendum->director_signer->appellative;
        //construir nombre director
        $first_name = explode(' ',trim($addendum->director_signer->user->name))[0];
        $director = mb_strtoupper($first_name . ' ' . $addendum->director_signer->user->fathers_family . ' ' . $addendum->director_signer->user->mothers_family);
        $directorNationality = Str::contains($addendum->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

        $alcaldeNationality = Str::endsWith($addendum->representative_appellative, 'a') ? 'chilena' : 'chileno';

		$templateProcessor->setValue('programaTitulo', mb_strtoupper($programa));
		$templateProcessor->setValue('programa', $programa);
		$templateProcessor->setValue('periodoConvenio', $addendum->agreement->period);
        $templateProcessor->setValue('ilustreTitulo', $ilustre);
        $templateProcessor->setValue('municipalidad', $municipalidad);
        $templateProcessor->setValue('municipalidadDirec', $addendum->agreement->municipality_adress);
        $templateProcessor->setValue('fechaAddendum', $fechaAddendum);
        $templateProcessor->setValue('fechaConvenio', $fechaConvenio); // Cambiar formato d de m y
        $templateProcessor->setValue('numResolucionConvenio', $addendum->agreement->res_exempt_number);
        $templateProcessor->setValue('fechaResolucionConvenio', $fechaResolucionConvenio);
        $templateProcessor->setValue('directorApelativo', $directorApelativo);
        $templateProcessor->setValue('director', $director);
        $templateProcessor->setValue('directorNationality', $directorNationality);
        $templateProcessor->setValue('directorRut', mb_strtoupper($addendum->director_signer->user->runFormat()));
        $templateProcessor->setValue('directorDecreto', $addendum->director_signer->decree);
        $templateProcessor->setValue('comuna', $addendum->agreement->commune->name);
        $templateProcessor->setValue('comunaRut', $municipality->rut_municipality);
        $templateProcessor->setValue('ilustre', ucfirst(mb_strtolower($ilustre)));
        $templateProcessor->setValue('alcaldeApelativo', $addendum->representative_appellative);
        $templateProcessor->setValue('alcalde', mb_strtoupper($addendum->representative));
        $templateProcessor->setValue('alcaldeNationality', $alcaldeNationality);
        $templateProcessor->setValue('alcaldeRut', $addendum->representative_rut);
        $templateProcessor->setValue('alcaldeDecreto', $addendum->representative_decree);

        $templateProcessor->setValue('numResolucion', $addendum->agreement->number);
        $templateProcessor->setValue('yearResolucion', $addendum->agreement->resolution_date != NULL ? date('Y', strtotime($addendum->agreement->resolution_date)) : '');
        $templateProcessor->setValue('fechaResolucion', $this->formatDate($addendum->agreement->resolution_date));
        $templateProcessor->setValue('numResourceResolucion', $addendum->agreement->res_resource_number);
        $templateProcessor->setValue('yearResourceResolucion', $addendum->agreement->res_resource_date != NULL ? date('Y', strtotime($addendum->agreement->res_resource_date)) : '');
        $templateProcessor->setValue('fechaResourceResolucion', $this->formatDate($addendum->agreement->res_resource_date));

        if($type != 'addendum'){ //resolucion addendum
            // TEMPLATE MERGE
            // extract internal xml from template that will be merged inside main template
            $innerXml = $midTemplateProcessor->tempDocumentMainPart; //contenido addendum
            $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);
            
            //remove signature blocks
            $innerXml = Str::beforeLast($innerXml, 'addendum');
            $innerXml .= 'addendum.</w:t></w:r></w:p>';
            // dd($innerXml);
            $templateProcessorEnd->setValue('ilustre', ucfirst(mb_strtolower($ilustre)));
            $templateProcessorEnd->setValue('comuna', $addendum->agreement->commune->name);
            $templateProcessorEnd->setValue('emailReferrer', $addendum->referrer != null ? $addendum->referrer->email : '');
            $mainXmlEnd = $templateProcessorEnd->tempDocumentMainPart;
            $mainXmlEnd = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $mainXmlEnd);

            // remove tag containing header, footer, images
            // $mainXmlEnd = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $mainXmlEnd);

            // inject internal xml inside main template 
            $mainXml = $templateProcessor->tempDocumentMainPart;
    
            $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $innerXml . '</w:body>', $mainXml);
            $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $mainXmlEnd . '</w:body>', $mainXml);

            $templateProcessor->__set('tempDocumentMainPart', $mainXml);
        }
        
        $download_path = 'app/public/Prev-'. ($type != 'addendum' ? 'Resolucion-' : '') .'Addendum.docx';
        $templateProcessor->saveAs(storage_path($download_path));
        return response()->download(storage_path($download_path))->deleteFileAfterSend(true);
    }


    public function ordinal($n){
        $ordinales = array('primera','segunda','tercera','cuarta','quinta','sexta','septima','octava','novena','decima','onceava','doceava');

        if ($n<=count ($ordinales)){
            return $ordinales[$n-1];
        }
        return $n.'-esimo';
    }

    public function correctAmountText($amount_text)
    {
        $amount_text = ucwords(mb_strtolower($amount_text));
        // verificamos si antes de cerrar en pesos la ultima palabra termina en Millón o Millones, de ser así se agregar "de" antes de cerrar con pesos
        $words_amount = explode(' ',trim($amount_text));
        return ($words_amount[count($words_amount) - 2] == 'Millon' || $words_amount[count($words_amount) - 2] == 'Millones') ? substr_replace($amount_text, 'de ', (strlen($amount_text) - 5), 0) : $amount_text;
    }

    public function formatDate($date)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        return date('j', strtotime($date)).' de '.$meses[date('n', strtotime($date))-1].' del año '.date('Y', strtotime($date));
    }

}
