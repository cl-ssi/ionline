<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use Illuminate\Http\Request;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\Program;
use App\Models\Agreements\ProgramComponent;
use App\Models\Agreements\Stage;
use App\Models\Agreements\AgreementAmount;
use App\Models\Agreements\AgreementQuota;
use App\Models\Agreements\OpenTemplateProcessor;
use App\Models\Agreements\MyClass;
use App\Models\Agreements\ProgramResolution;
use App\Models\Agreements\Signer;
use App\Models\Commune;
use App\Models\Parameters\Municipality;
use App\Models\Establishment;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Luecano\NumeroALetras\NumeroALetras;
use PhpOffice\PhpWord\Settings;
use PhpOffice;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\SimpleType\TblWidth;

class WordMandatePFCAgreeController extends Controller
{
    public function createWordDocx($id)
    {
    	// SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
    	$agreements     = Agreement::with('Program','Commune','agreement_amounts','director_signer.user')->where('id', $id)->first();
    	$stage          = Stage::where('agreement_id', $id)->first();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // AL MOMENTO DE PREVISUALIZAR EL DOCUMENTO INICIA AUTOMATICAMENTE LA PRIMERA ETAPA
        if(is_null($stage)){
            $agreements->stages()->create(['agreement_id' => $id,'group' => 'CON','type' => 'RTP', 'date' => Carbon::now()->toDateTimeString()]);
        }

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio,0, 'pesos',''));

    	$templateProcesor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/conveniomandatopfc'.$agreements->period.'.docx'));

    	$periodoConvenio = $agreements->period;
        $fechaConvenio = date('j', strtotime($agreements->date)).' de '.$meses[date('n', strtotime($agreements->date))-1].' del año '.date('Y', strtotime($agreements->date));
    	$numResolucion = $agreements->number;
        $fechaResolucion = $agreements->resolution_date;
        $fechaResolucion = $fechaResolucion != NULL ? date('j', strtotime($fechaResolucion)).' de '.$meses[date('n', strtotime($fechaResolucion))-1].' del año '.date('Y', strtotime($fechaResolucion)) : '';
        $alcaldeApelativo = $agreements->representative_appelative;
        if(Str::contains($alcaldeApelativo, 'Subrogante')){
            $alcaldeApelativoFirma = Str::before($alcaldeApelativo, 'Subrogante') . '(S)';
        }else{
            $alcaldeApelativoFirma = explode(' ',trim($alcaldeApelativo))[0]; // Alcalde(sa)
        }
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

        //Director
        //construir nombre director
        $director = mb_strtoupper($agreements->director_signer->user->fullName);
        $directorApelativo = $agreements->director_signer->appellative;
        $directorRut = mb_strtoupper($agreements->director_signer->user->runFormat());
        $directorDecreto = $agreements->director_signer->decree;
        $directorNationality = Str::contains($agreements->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

		$templateProcesor->setValue('programa',$agreements->Program->name);
		$templateProcesor->setValue('programaTitulo',mb_strtoupper($programa));
		$templateProcesor->setValue('periodoConvenio',$periodoConvenio);
		$templateProcesor->setValue('fechaConvenio',$fechaConvenio); // Cambiar formato d de m y
		$templateProcesor->setValue('numResolucion',$numResolucion);
		$templateProcesor->setValue('totalConvenio',number_format($totalConvenio,0,",","."));
		$templateProcesor->setValue('totalConvenioLetras',$totalConvenioLetras);
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
        $templateProcesor->setValue('art8', !Str::contains($directorApelativo, '(S)') ? 'Art. 8 del ' : '');

    	$templateProcesor->saveAs(storage_path('app/public/Prev-Conv-MandatoPFC.docx'));

    	return response()->download(storage_path('app/public/Prev-Conv-MandatoPFC.docx'))->deleteFileAfterSend(true);
    }

    public function createResWordDocx(Request $request, $id)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
        $agreements     = Agreement::with('Program','Commune','agreement_amounts', 'referrer')->where('id', $id)->first();
        $municipality   = Municipality::where('commune_id', $agreements->Commune->id)->first();
        $file           = Storage::disk('gcs')->url($agreements->file);
        $meses          = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        // SE CONVIERTE EL VALOR TOTAL DEL CONVENIO EN PALABRAS
        $formatter = new NumeroALetras;
        $formatter->apocope = true;
        $totalConvenio = $agreements->agreement_amounts->sum('amount');
        $totalConvenioLetras = $this->correctAmountText($formatter->toMoney($totalConvenio, 0, 'pesos',''));
        
        // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
        $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionhead'.$agreements->period.'.docx'));
        $midTemplateProcessor = new OpenTemplateProcessor($file); //convenio doc
        $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionfooter'.$agreements->period.'.docx'));

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
        if($agreements->period >= 2022) $programa = mb_strtoupper($programa);
        
        //Director ssi quien firma a la fecha de hoy
        $director = Signer::find($request->signer_id);

        //email referente
        $emailReferrer = $agreements->referrer != null ? $agreements->referrer->email : '';

        $mainTemplateProcessor->setValue('directorDecreto', Str::contains($director->appellative, '(S)') ? Str::after($director->decree, 'de los Servicios de Salud;') : $director->decree);
        $mainTemplateProcessor->setValue('art8', !Str::contains($director->appellative, '(S)') ? 'Art. 8 del ' : '');
        $mainTemplateProcessor->setValue('numResolucion',$numResolucion);
        $mainTemplateProcessor->setValue('yearResolucion',$yearResolucion);
        $mainTemplateProcessor->setValue('programa',$programa);
        $mainTemplateProcessor->setValue('numResourceResolucion',$numResourceResolucion);
        $mainTemplateProcessor->setValue('yearResourceResolucion',$yearResourceResolucion);
        $mainTemplateProcessor->setValue('fechaResolucion',$fechaResolucion);
        $mainTemplateProcessor->setValue('periodoConvenio',$periodoConvenio);
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
        $mainTemplateProcessorEnd->setValue('emailMunicipality',$emailMunicipality);
        $mainTemplateProcessorEnd->setValue('emailReferrer',$emailReferrer);
       
        // TEMPLATE MERGE
        // extract internal xml from template that will be merged inside main template
        $innerXml = $midTemplateProcessor->tempDocumentMainPart;
        $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);
        // dd($innerXml);
        // remove tag containing header, footer, images
        // $innerXml = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $innerXml);
        
        //remove signature blocks
        // if($agreements->period >= 2022){
            // $innerXml = Str::beforeLast($innerXml, 'Presupuesto vigente del Servicio de Salud Tarapacá año');
            $innerXmlTemp = Str::beforeLast($innerXml, 'Presupuesto vigente del Servicio de Salud Iquique');
            if($innerXmlTemp === $innerXml){ // No encontró las palabras prueba con Tarapacá
                $innerXmlTemp = Str::beforeLast($innerXml, 'Tarapacá');
                $innerXmlTemp .= 'Tarapacá año '.$agreements->period.'”.</w:t></w:r></w:p>';
            }else{
                $innerXmlTemp .= 'Presupuesto vigente del Servicio de Salud Iquique año '.$agreements->period.'”.</w:t></w:r></w:p>';
            }
        // }else{
        //     $innerXml = Str::beforeLast($innerXml, 'Reforzamiento Municipal del Presupuesto');
        //     $innerXml .= 'Reforzamiento Municipal del Presupuesto vigente del Servicio de Salud Tarapacá año '.$agreements->period.'”.</w:t></w:r></w:p>';
        // }

        $mainXmlEnd = $mainTemplateProcessorEnd->tempDocumentMainPart;

        $mainXmlEnd = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $mainXmlEnd);

        // remove tag containing header, footer, images
        // $mainXmlEnd = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $mainXmlEnd);

        // inject internal xml inside main template 
        $mainXml = $mainTemplateProcessor->tempDocumentMainPart;
 
        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $innerXmlTemp . '</w:body>', $mainXml);
        $mainXml = preg_replace('/<\/w:body>/', '<w:p><w:r><w:br/></w:r></w:p>' . $mainXmlEnd . '</w:body>', $mainXml);

        $mainTemplateProcessor->__set('tempDocumentMainPart', $mainXml);

        // END TEMPLATE MERGE
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
