<?php

namespace App\Http\Controllers\Agreements;

use App\Models\Agreements\Addendum;
use Illuminate\Http\Request;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\OpenTemplateProcessor;
use App\Models\Agreements\Signer;
use App\Models\Agreements\Stage;
use App\Models\Parameters\Municipality;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
        if(!Str::contains($directorApelativo,'(S)')) $directorApelativo .= ' Titular';
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

    public function createResWordDocx(Request $request, $id)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
        $agreement = Agreement::with('Program','Commune','referrer')->where('id', $id)->first();
        $file = Storage::disk('gcs')->url($agreement->file);
        
        // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
        $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionretirohead'.$agreement->period.'.docx'));
        $midTemplateProcessor = new OpenTemplateProcessor($file); //convenio doc
        $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionretirofooter'.$agreement->period.'.docx'));

        // Parametros a imprimir en los archivos abiertos
        $periodoConvenio = $agreement->period;
        $comuna = $agreement->Commune->name;
    	$numResolucion = $agreement->number;
        $yearResolucion = $agreement->resolution_date != NULL ? date('Y', strtotime($agreement->resolution_date)) : '';
    	$ilustre = !Str::contains($comuna, 'Alto Hospicio') ? 'Ilustre ': null;
        
        //Director ssi quien firma a la fecha de hoy
        $director = Signer::find($request->signer_id);

        $mainTemplateProcessor->setValue('directorDecreto', Str::contains($director->appellative, '(S)') ? Str::after($director->decree, 'de los Servicios de Salud;') : $director->decree);
        $mainTemplateProcessor->setValue('art8', !Str::contains($director->appellative, '(S)') ? 'Art. 8 del ' : '');
        $mainTemplateProcessor->setValue('numResolucion',$numResolucion);
        $mainTemplateProcessor->setValue('yearResolucion',$yearResolucion);
        $mainTemplateProcessor->setValue('periodoConvenio',$periodoConvenio);
        $mainTemplateProcessor->setValue('ilustre',$ilustre);
        $mainTemplateProcessor->setValue('comuna',$comuna);

        $mainTemplateProcessorEnd->setValue('ilustre',$ilustre);
        $mainTemplateProcessorEnd->setValue('comuna',$comuna);
       
        // TEMPLATE MERGE
        // extract internal xml from template that will be merged inside main template
        $innerXml = $midTemplateProcessor->tempDocumentMainPart;
        $innerXml = preg_replace('/^[\s\S]*<w:body>(.*)<\/w:body>.*/', '$1', $innerXml);
        // remove tag containing header, footer, images
        // $innerXml = preg_replace('/<w:sectPr>.*<\/w:sectPr>/', '', $innerXml);
        
        //remove signature blocks
        $innerXml = Str::beforeLast($innerXml, 'documento original digitalizado');
        $innerXml .= 'documento original digitalizado.</w:t></w:r></w:p>';

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
        $addendum->load('agreement.program','agreement.commune', 'director_signer.user');
        $municipality   = Municipality::where('commune_id', $addendum->agreement->commune->id)->first();

        if($type == 'addendum'){
    	    $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/addendumretiro'.$addendum->agreement->period.'.docx'));
        } else { // Resolucion Addedum
            // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
            $templateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucionaddendumretirohead'.$addendum->agreement->period.'.docx'));
            $midTemplateProcessor = new OpenTemplateProcessor(Storage::disk('gcs')->url($addendum->file)); //addendum doc
            $templateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucionaddendumretirofooter'.$addendum->agreement->period.'.docx'));
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
        // $first_name = explode(' ',trim($addendum->director_signer->user->name))[0];
        $director = mb_strtoupper($addendum->director_signer->user->fullName);
        $directorNationality = Str::contains($addendum->director_signer->appellative, 'a') ? 'chilena' : 'chileno';

        $alcaldeNationality = Str::endsWith($addendum->representative_appellative, 'a') ? 'chilena' : 'chileno';
        $alcaldeApelativo = $addendum->representative_appellative;
        $alcaldeApelativoCorto = Str::beforeLast($alcaldeApelativo, ' ');
        if(Str::contains($alcaldeApelativo, 'Subrogante')){
            $alcaldeApelativoFirma = Str::before($alcaldeApelativo, 'Subrogante') . '(S)';
        }else{
            $alcaldeApelativoFirma = explode(' ',trim($alcaldeApelativo))[0]; // Alcalde(sa)
        }
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
        $templateProcessor->setValue('art8', !Str::contains($directorApelativo, '(S)') ? 'Art. 8 del ' : '');
        $templateProcessor->setValue('comuna', $addendum->agreement->commune->name);
        $templateProcessor->setValue('comunaRut', $municipality->rut_municipality);
        $templateProcessor->setValue('ilustre', ucfirst(mb_strtolower($ilustre)));
        $templateProcessor->setValue('alcaldeApelativo', $alcaldeApelativo);
        $templateProcessor->setValue('alcaldeApelativoCorto', $alcaldeApelativoCorto);
        $templateProcessor->setValue('alcaldeApelativoFirma', $alcaldeApelativoFirma);
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
