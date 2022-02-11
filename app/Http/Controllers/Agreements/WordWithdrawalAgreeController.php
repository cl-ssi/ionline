<?php

namespace App\Http\Controllers\Agreements;

use Illuminate\Http\Request;
use App\Agreements\Agreement;
use App\Agreements\Stage;
use App\Municipality;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Str;

class WordWithdrawalAgreeController extends Controller
{
    public function createWordDocx($id)
    {
    	// SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    	$agreement     = Agreement::with('Commune','director_signer.user')->findOrFail($id);
    	$stage          = Stage::where('agreement_id', $id)->first();
        $municipality   = Municipality::where('commune_id', $agreement->Commune->id)->first();
        $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // AL MOMENTO DE PREVISUALIZAR EL DOCUMENTO INICIA AUTOMATICAMENTE LA PRIMERA ETAPA
        if(is_null($stage)){
            $agreement->stages()->create(['agreement_id' => $id,'group' => 'CON','type' => 'RTP', 'date' => Carbon::now()->toDateTimeString()]);
        }

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $agreement->total_amount;
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));
        $totalQuotas = $agreement->quotas;

        $amountPerQuota = round($totalConvenio/$totalQuotas);
        $amountPerQuota = round($totalConvenio/$totalQuotas);
        $diff = $totalConvenio - $amountPerQuota * $totalQuotas; //residuo
        $totalQuotasText = $diff ? ($totalQuotas - 1). ' cuotas de $'.number_format($amountPerQuota,0,",",".").' ('.$this->correctAmountText($formatter->toMoney($amountPerQuota,0, 'pesos','')).') y una cuota de $'.number_format($amountPerQuota + $diff,0,",",".").' ('.$this->correctAmountText($formatter->toMoney($amountPerQuota + $diff,0, 'pesos','')).')'
                                 : $totalQuotas. ' cuotas de $'.number_format($amountPerQuota,0,",",".").' ('.$this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos','')).')';

    	$templateProcesor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/convenioretiro'.$agreement->period.'.docx'));

    	$periodoConvenio = $agreement->period;
        $fechaConvenio = date('j', strtotime($agreement->date)).' de '.$meses[date('n', strtotime($agreement->date))-1].' del año '.date('Y', strtotime($agreement->date));
    	$numResolucion = $agreement->number;
        $fechaResolucion = $agreement->resolution_date;
        $fechaResolucion = $fechaResolucion != NULL ? date('j', strtotime($fechaResolucion)).' de '.$meses[date('n', strtotime($fechaResolucion))-1].' del año '.date('Y', strtotime($fechaResolucion)) : '';
        
        // Alcalde y su municipalidad
        $alcaldeApelativo = $agreement->representative_appelative;
        if(Str::contains($alcaldeApelativo, 'Subrogante')){
            $alcaldeApelativoFirma = Str::before($alcaldeApelativo, 'Subrogante') . '(S)';
        }else{
            $alcaldeApelativoFirma = explode(' ',trim($alcaldeApelativo))[0]; // Alcalde(sa)
        }
        $alcalde = $agreement->representative;
        $alcaldeDecreto = $agreement->representative_decree;
    	$municipalidad = $municipality->name_municipality;
    	$ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'ILUSTRE': null;
    	$municipalidadDirec = $agreement->municipality_adress;
    	$comunaRut = $agreement->municipality_rut;
    	$alcaldeRut = $agreement->representative_rut;
    	$comuna = $agreement->Commune->name;

        //Director
        $director = mb_strtoupper($agreement->director_signer->user->fullName);
        $directorApelativo = $agreement->director_signer->appellative;
        $directorRut = mb_strtoupper($agreement->director_signer->user->runFormat());
        $directorDecreto = $agreement->director_signer->decree;
        $directorNationality = Str::contains($agreement->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

		$templateProcesor->setValue('periodoConvenio',$periodoConvenio);
		$templateProcesor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
		$templateProcesor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
		$templateProcesor->setValue('totalConvenioLetras',$totalConvenioLetras);
		$templateProcesor->setValue('totalQuotas',$totalQuotas);
        $templateProcesor->setValue('totalQuotasText', $totalQuotasText);
		$templateProcesor->setValue('numResolucion',$numResolucion);
		$templateProcesor->setValue('fechaResolucion',$fechaResolucion);
		$templateProcesor->setValue('comuna',$comuna);
        $templateProcesor->setValue('comunaRut',$comunaRut);
        $templateProcesor->setValue('ilustre',ucfirst(mb_strtolower($ilustre)));
        $templateProcesor->setValue('ilustreTitulo',$ilustre);
		$templateProcesor->setValue('municipalidad',$municipalidad);
		$templateProcesor->setValue('municipalidadDirec',$municipalidadDirec);
		$templateProcesor->setValue('alcaldeApelativo',$alcaldeApelativo);
		$templateProcesor->setValue('alcaldeApelativoFirma',mb_strtoupper($alcaldeApelativoFirma));
        $templateProcesor->setValue('alcalde',mb_strtoupper($alcalde));
		$templateProcesor->setValue('alcaldeRut',$alcaldeRut);
        $templateProcesor->setValue('alcaldeDecreto',$alcaldeDecreto);
        $templateProcesor->setValue('director',$director);
        $templateProcesor->setValue('directorApelativo',$directorApelativo);
        $templateProcesor->setValue('directorRut',$directorRut);
        $templateProcesor->setValue('directorDecreto',$directorDecreto);
        $templateProcesor->setValue('directorNationality',$directorNationality);

    	$templateProcesor->saveAs(storage_path('app/public/Prev-Conv-Retiro.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

    	return response()->download(storage_path('app/public/Prev-Conv-Retiro.docx'))->deleteFileAfterSend(true);
    }

    // public function createResWordDocx(Request $request, $id)
    // {
    //     // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    //     $agreement     = Agreement::with('Program','Commune','agreement_amounts', 'referrer')->where('id', $id)->first();
    //     $municipality   = Municipality::where('commune_id', $agreement->Commune->id)->first();
    //     $file           = Storage::disk('')->path($agreement->file);
    //     $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

    //     // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
    //     $formatter = new NumeroALetras;
    //     $formatter->apocope = true;
    //     $totalConvenio = $agreement->agreement_amounts->sum('amount');
    //     $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio, 0, 'pesos',''));
        
    //     // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
    //     $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionhead'.$agreement->period.'.docx'));
    //     $midTemplateProcessor = new OpenTemplateProcessor($file); //convenio doc
    //     $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionfooter'.$agreement->period.'.docx'));

    //     // Parametros a imprimir en los archivos abiertos
    //     $periodoConvenio = $agreement->period;
    //     $fechaConvenio = date('j', strtotime($agreement->date)).' de '.$meses[date('n', strtotime($agreement->date))-1].' del '.date('Y', strtotime($agreement->date));
    // 	$numResolucion = $agreement->number;
    //     $yearResolucion = $agreement->resolution_date != NULL ? date('Y', strtotime($agreement->resolution_date)) : '';
    //     $fechaResolucion = $agreement->resolution_date != NULL ? date('j', strtotime($agreement->resolution_date)).' de '.$meses[date('n', strtotime($agreement->resolution_date))-1].' del '.date('Y', strtotime($agreement->resolution_date)) : '';
    //     $numResourceResolucion = $agreement->res_resource_number;
    //     $yearResourceResolucion = $agreement->res_resource_date != NULL ? date('Y', strtotime($agreement->res_resource_date)) : '';
    //     $fechaResourceResolucion = $agreement->res_resource_date != NULL ? date('j', strtotime($agreement->res_resource_date)).' de '.$meses[date('n', strtotime($agreement->res_resource_date))-1].' del '.date('Y', strtotime($agreement->res_resource_date)) : '';
    // 	$ilustre = !Str::contains($municipality->name_municipality, 'ALTO HOSPICIO') ? 'Ilustre': null;
    //     $emailMunicipality = $municipality->email_municipality;
    //     $comuna = $agreement->Commune->name; 
    //     $first_word = explode(' ',trim($agreement->Program->name))[0];
    //     $programa = $first_word == 'Programa' ? substr(strstr($agreement->Program->name," "), 1) : $agreement->Program->name;
    //     if($agreement->period >= 2022) $programa = mb_strtoupper($programa);
        
    //     //Director ssi quien firma a la fecha de hoy
    //     $director = Signer::find($request->signer_id);

    //     //email referente
    //     $emailReferrer = $agreement->referrer != null ? $agreement->referrer->email : '';

    //     $mainTemplateProcessor->setValue('directorDecreto',$director->decree);
    //     $mainTemplateProcessor->setValue('art8', !Str::contains($director->appellative, '(S)') ? 'Art. 8 del ' : '');
    //     $mainTemplateProcessor->setValue('numResolucion',$numResolucion);
    //     $mainTemplateProcessor->setValue('yearResolucion',$yearResolucion);
    //     $mainTemplateProcessor->setValue('programa',$programa);
    //     $mainTemplateProcessor->setValue('numResourceResolucion',$numResourceResolucion);
    //     $mainTemplateProcessor->setValue('yearResourceResolucion',$yearResourceResolucion);
    //     $mainTemplateProcessor->setValue('fechaResolucion',$fechaResolucion);
    //     $mainTemplateProcessor->setValue('periodoConvenio',$periodoConvenio);
    //     $mainTemplateProcessor->setValue('fechaResourceResolucion',$fechaResourceResolucion);
    //     $mainTemplateProcessor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
    //     $mainTemplateProcessor->setValue('ilustreTitulo',$ilustre);
    //     $mainTemplateProcessor->setValue('comuna',$comuna);
    //     $mainTemplateProcessor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
    //     $mainTemplateProcessor->setValue('totalConvenioLetras',$totalConvenioLetras);

    //     $mainTemplateProcessorEnd->setValue('programa',$programa);
    //     $mainTemplateProcessorEnd->setValue('periodoConvenio',$periodoConvenio);
    //     $mainTemplateProcessorEnd->setValue('ilustreTitulo',$ilustre);
    //     $mainTemplateProcessorEnd->setValue('comuna',$comuna);
    //     $mainTemplateProcessorEnd->setValue('emailMunicipality',$emailMunicipality);
    //     $mainTemplateProcessorEnd->setValue('emailReferrer',$emailReferrer);
       
    //     // TEMPLATE MERGE
    //     // extract internal xml from template that will be merged inside main template
    //     $innerXml = $midTemplateProcessor->tempDocumentMainPart;
    //     $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);
    //     // dd($innerXml);
    //     // remove tag containing header, footer, images
    //     // $innerXml = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $innerXml);
        
    //     //remove signature blocks
    //     if($agreement->period >= 2022){
    //         $innerXml = Str::beforeLast($innerXml, 'Presupuesto vigente del Servicio de Salud Iquique año');
    //         $innerXml .= 'Presupuesto vigente del Servicio de Salud Iquique año '.$agreement->period.'”.</w:t></w:r></w:p>';
    //     }else{
    //         $innerXml = Str::beforeLast($innerXml, 'Reforzamiento Municipal del Presupuesto');
    //         $innerXml .= 'Reforzamiento Municipal del Presupuesto vigente del Servicio de Salud Iquique año '.$agreement->period.'”.</w:t></w:r></w:p>';
    //     }

    //     $mainXmlEnd = $mainTemplateProcessorEnd->tempDocumentMainPart;

    //     $mainXmlEnd = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $mainXmlEnd);

    //     // remove tag containing header, footer, images
    //     // $mainXmlEnd = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $mainXmlEnd);

    //     // inject internal xml inside main template 
    //     $mainXml = $mainTemplateProcessor->tempDocumentMainPart;
 
    //     $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $innerXml . '</w:body>', $mainXml);
    //     $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $mainXmlEnd . '</w:body>', $mainXml);

    //     $mainTemplateProcessor->__set('tempDocumentMainPart', $mainXml);

    //     // END TEMPLATE MERGE
    //     $mainTemplateProcessor->saveAs(storage_path('app/public/Prev-Resolucion.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

    //     return response()->download(storage_path('app/public/Prev-Resolucion.docx'))->deleteFileAfterSend(true);
    // }

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
