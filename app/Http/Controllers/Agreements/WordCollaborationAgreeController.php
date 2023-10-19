<?php

namespace App\Http\Controllers\Agreements;

use Illuminate\Http\Request;
use App\Models\Agreements\Agreement;
use App\Models\Agreements\OpenTemplateProcessor;
use App\Models\Agreements\Signer;
use App\Models\Agreements\Stage;
use App\Models\Establishment;
use App\Models\Parameters\Municipality;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Support\Str;

class WordCollaborationAgreeController extends Controller
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

        // SE OBTIENE LAS INSTITUCIONES DE SALUD PERO SÓLO LAS QUE SE HAN SELECCIONADO
        $establishment_list = unserialize($agreement->establishment_list) == null ? [] : unserialize($agreement->establishment_list);
        $establishments = Establishment::where('commune_id', $agreement->Commune->id)
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

    	$templateProcesor = new \PhpOffice\PhpWord\TemplateProcessor(public_path('word-template/conveniocolaboracion'.$agreement->period.'.docx'));

    	$periodoConvenio = $agreement->period;
        $fechaConvenio = date('j', strtotime($agreement->date)).' de '.$meses[date('n', strtotime($agreement->date))-1].' del año '.date('Y', strtotime($agreement->date));
        
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
		$templateProcesor->setValue('fechaConvenio',$fechaConvenio);
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

        $templateProcesor->setValue('establecimientosListado',$arrayEstablishmentConcat);

    	$templateProcesor->saveAs(storage_path('app/public/Prev-Conv-Colaboracion.docx')); //'Prev-RESOL'.$numResolucion.'.docx'

    	return response()->download(storage_path('app/public/Prev-Conv-Colaboracion.docx'))->deleteFileAfterSend(true);
    }

    public function createResWordDocx(Request $request, $id)
    {
        // SE OBTIENEN DATOS RELACIONADOS AL CONVENIO
        $agreement = Agreement::with('Program','Commune')->where('id', $id)->first();
        $file = Storage::disk('gcs')->url($agreement->file);
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        // Se abren los archivos doc para unirlos en uno solo en el orden en que se lista a continuacion
        $mainTemplateProcessor = new OpenTemplateProcessor(public_path('word-template/resolucioncolaboracionhead'.$agreement->period.'.docx'));
        $midTemplateProcessor = new OpenTemplateProcessor($file); //convenio doc
        $mainTemplateProcessorEnd = new OpenTemplateProcessor(public_path('word-template/resolucioncolaboracionfooter'.$agreement->period.'.docx'));

        // Parametros a imprimir en los archivos abiertos
        $periodoConvenio = $agreement->period;
        $fechaConvenio = date('j', strtotime($agreement->date)).' de '.$meses[date('n', strtotime($agreement->date))-1].' del año '.date('Y', strtotime($agreement->date));
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
        $mainTemplateProcessor->setValue('fechaConvenio',$fechaConvenio);
        $mainTemplateProcessor->setValue('periodoConvenio',$periodoConvenio);
        $mainTemplateProcessor->setValue('ilustre',$ilustre);
        $mainTemplateProcessor->setValue('comuna',$comuna);

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

    public function correctAmountText($amount_text)
    {
        $amount_text = ucwords(mb_strtolower($amount_text));
        // verificamos si antes de cerrar en pesos la ultima palabra termina en Millón o Millones, de ser así se agregar "de" antes de cerrar con pesos
        $words_amount = explode(' ',trim($amount_text));
        return ($words_amount[count($words_amount) - 2] == 'Millon' || $words_amount[count($words_amount) - 2] == 'Millones') ? substr_replace($amount_text, 'de ', (strlen($amount_text) - 5), 0) : $amount_text;
    }
}
