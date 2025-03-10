<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Agreements\ProcessType;
use App\Models\Documents\Template;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class UpdateProcessContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-process-content {type?} {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transforma content de old Agreement.Process a dinamico con etiquetas html a con atributo data-lw con referencia.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // dd($this->arguments());
        // dd($this->options());
        if($this->argument('type') == 'process'){
            $this->argument('id')?$this->updateProcesessContent($this->argument('id')):$this->updateProcesessContent();
        }
        elseif($this->argument('type') == 'template'){
            $this->updateProcessTemplates();
        }
        elseif($this->argument('type') == 'both'){
            $this->updateProcesessContent();
            $this->updateProcessTemplates();
        }
    }

    private function updateProcessTemplates():void
    {
        $this->newLine(4);
        $this->line('***************************');
        $this->line('*Update Process Templates *');
        $this->line('***************************');
        $this->newLine(2);
        $process_types = ProcessType::all();
        $bar = $this->output->createProgressBar(count($process_types));        
        $bar->start();
        $this->newLine();
        
        foreach($process_types as $process_type){
            $this->line('Process Type:' . $process_type->name);
            $template = $process_type->template;
            $this->updateTemplateContent($template);
        }
    }

    private function updateTemplateContent(Template $template): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($template->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD);
        $replacements = [
            'document_date_format',
            'signer.user.full_name',
            'signer.user.runFormat',
            'signer.decree_paragraph',
            'signer.appellative',
            'mayor.decree',
            'mayor.appellative',
            'mayor.name',
            'mayor.run',
            'municipality.name',
            'municipality.rut',
            'municipality.emailList',
            'municipality.decree',
            'municipality.address',
            'commune.name',
            'program.ministerial_resolution_number',
            'program.ministerialResolutionDateFormat',
            'program.resource_distribution_number',
            'program.resourceDistributionDateFormat',
            'program.referersEmailList',
            'program.components',
            'program.name',
            'previousProcess.date',
            'previousProcess.period',
            'previousProcess.document_content',
            'previousProcess.dateFormat',
            'period',
            'total_amount_format',
            'total_amount_in_words',
            'nextPeriod',
            'quotas_qty',
            'monthsArray',
            'quotas',
            'description',
            'amount_format',
            'amount_in_words',
            'percentage',
            'establishmentsList',
            'establishments', // TODO: WTF ????
        ];
        foreach($replacements as $name){
            $val = '{{'. $name . '}}';
            if(str_contains($template->content, $val)){
                $this->replaceTextInNode($dom, $name, $val);            
            }
        }
        $template->content = htmlspecialchars_decode($dom->saveHTML());
        $template->saveQuietly();
    }

    private function updateProcesessContent(string $id = null):void
    {
        $proceses = !$id?Process::all():Process::where('id', $id)->get();
        $this->newLine(2);
        $this->line('**********************************************');
        $this->line('*Update Procesess Content Command Has Started*');
        $this->line('**********************************************');
        $this->newLine(2);
        $bar = $this->output->createProgressBar(count($proceses));        
        $bar->start();
        $this->newLine();
        foreach($proceses as $process){
            $this->info('Process ID:' . $process->id . ' - ' . $process->processType->name);
            if($process->document_content){

                /*
                $this->replaceDateInDocumentContent($process);
                $replacement = array();
                $replacements['period'] = array(
                    'name' => 'period',
                    'value' => $process->period,
                    'prefix' => 'A&Ntilde;O ',
                    'affix' => '&rdquo;',
                );
                $replacements['total_amount_format'] = array(
                    'name' => 'total_amount_format',
                    'value' => $process->total_amount_format,
                    'prefix' => 'la suma anual y &uacute;nica de $',
                    'affix' => ' (' . $process->total_amount_in_words . ' pesos) para alcanzar el prop&oacute',
                );
                $replacements['total_amount_in_words'] = array(
                    'name' => 'total_amount_in_words',
                    'value' => $process->total_amount_in_words,
                    'prefix' => 'la suma anual y &uacute;nica de $' . $process->total_amount_format . ' (',
                    'affix' => ' pesos) para alcanzar el prop&oacute',
                );
                $replacements['nextPeriod'] = array(
                    'name' => 'nextPeriod',
                    'value' => $process->nextPeriod,
                    'prefix' => 'El periodo a rendir del mes de enero ',
                    'affix' => ', corresponde',
                );
                $replacements = [
                    'establishmentsList' => $process->establishmentsList,
                ];
                $this->replaceInDocumentContent($process, $replacements);

                if(!is_null($process->signer)){
                    $replacement = array();
                    $replacements = [
                        'signer.user.full_name' => $process->signer->user->full_name,
                        'signer.user.runFormat' => $process->signer->user->runFormat,
                        'signer.decree_paragraph' => $process->signer->decree_paragraph,
                        'signer.appellative' => $process->signer->appellative,
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->mayor)){
                    $replacement = array();
                    $replacements = [
                        'mayor.name' => $process->mayor->name,
                        'mayor.run' => $process->mayor->run,
                        'mayor.appellative' => $process->mayor->appellative,
                        'mayor.decree' => $process->mayor->decree,
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->municipality)){
                    $replacement = array();
                    $replacements = [
                        'municipality.name' => $process->municipality->name,
                        'municipality.rut' => $process->municipality->rut,
                        'municipality.emailList' => $process->municipality->emailList,
                        'municipality.decree' => $process->municipality->decree,
                        'municipality.address' => $process->municipality->address,
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->program)){
                    $replacement = array();
                    $replacements = [
                        // 'program.ministerial_resolution_number' => $process->program->ministerial_resolution_number,
                        // 'program.ministerialResolutionDateFormat' => $process->program->ministerialResolutionDateFormat,
                        // 'program.resource_distribution_number' => $process->program->resource_distribution_number,
                        // 'program.resourceDistributionDateFormat' => $process->program->resourceDistributionDateFormat,
                        'program.referersEmailList' => $process->program->referersEmailList,
                        'program.components' => $process->program->components,
                        'program.name' => $process->program->name, 
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->previousProcess)){
                    $replacement = array();
                    $replacements = [
                        // 'previousProcess.date' => $process->previousProcess->date,
                        //'previousProcess.period' => $process->previousProcess->period, //manual
                        // 'previousProcess.document_content' => $process->previousProcess->document_content,
                        // 'previousProcess.dateFormat' => $process->previousProcess->dateFormat,
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->commune)){
                    $replacement = array();
                    $replacements = [
                        // 'commune.name' => $process->commune->name,
                    ];
                    $this->replaceInDocumentContent($process, $replacements);
                }
                if(!is_null($process->quotas_qty)){
                    // WARNING: How to change in observer inside foreach
                    $replacement = array();
                    foreach($process->monthsArray as $month => $amount){
                        $replacements[$month] = array(
                            'name' => 'month',
                            'value' => $month,                                                        
                            'ref' => $month,
                        );
                        $replacements[$month] = array(
                            'name' => 'month',
                            'value' => $amount,                            
                            'affix' => ': $ ' . $amount . '.',
                        );
                    }
                    $this->replaceInDocumentContent($process, $replacements);
                }else if(!is_null($process->quotas)) {
                    // WARNING: How to change in observer inside foreach
                    $replacement = array();
                    foreach($process->quotas as $quota){
                        $replacements['description'] = array(
                            'name' => 'description',
                            'value' => $quota->description,
                            'prefix' => 'La ',
                            'affix' => ', de $  (' . $quota->amountInWords . ' pesos), correspondiente al ',
                            'ref' => $quota->id,
                        );
                        $replacements['total_amount_format'] = array(
                            'name' => 'total_amount_format',
                            'value' => $quota->amount_format,
                            'prefix' => 'La ' . $quota->description . ' de $ ',
                            'affix' => ' (' . $quota->amountInWords . ' pesos), correspondiente al ',
                            'ref' => $quota->id,
                        );
                        $replacements['total_amount_in_words'] = array(
                            'name' => 'total_amount_in_words',
                            'value' => $quota->amountInWords,
                            'prefix' => '$ ' . $quota->amountFormat . ' (',
                            'affix' => ' pesos), correspondiente al '. $quota->percentage . '% del total de los recursos',
                            'ref' => $quota->id,
                        );
                        $replacements['percentage'] = array(
                            'name' => 'percentage',
                            'value' => $quota->percentage,
                            'prefix' => $quota->amountInWords . ' pesos), correspondiente al ',
                            'affix' => '% del total de los recursos',
                            'ref' => $quota->id,
                        );
                    }                
                }
            }
            */
                $replacements = array();

                $replacements['period'] = array(
                    'name'  => 'period',
                    'value' => $process->period,
                    'positions' => array(
                        [
                            'prefix' => 'A&Ntilde;O ',
                            'affix'  => '&rdquo;',
                        ],
                        // [
                        //     'prefix' => '',
                        //     'affix'  => '',
                        //     'ref'    => 'span_center'
                        // ],
                        ['prefix' => 'Enero '],
                        ['prefix' => 'Febrero '],
                        ['prefix' => 'Marzo '],
                        ['prefix' => 'Abril '],
                        ['prefix' => 'Mayo '],
                        ['prefix' => 'Junio '],
                        ['prefix' => 'Agosto '],
                        ['prefix' => 'Septiembre '],
                        ['prefix' => 'Octubre '],
                        ['prefix' => 'Noviembre '],
                        ['prefix' => 'Diciembre '],
                        [
                            'prefix' => '31 de diciembre de ',
                            'affix'  => ', y respecto al',
                        ],
                        [
                            'prefix' => '&ldquo;' . $process->program->name . ' A&Ntilde;O ',
                            'affix'  => '&rdquo;',
                        ],
                        [
                            'prefix' => 'Servicio de Salud Tarapac&aacute; a&ntilde;o ',
                            'affix'  => '.',
                        ]
                    )
                );
                $replacements['nextPeriod'] = array(
                    'name'  => 'nextPeriod',
                    'value' => $process->nextPeriod,
                    'positions' => array(
                        ['prefix' => 'Enero '],
                        ['prefix' => 'Febrero&nbsp;'],
                    )
                );
                $replacements['program.name'] = array(
                    'name'  => 'program.name',
                    'value' => $process->program->name,
                    'positions' => array(
                        [
                            'prefix' => '&ldquo;',
                            'affix'  => ' A&Ntilde;O ',
                        ],
                        [
                            'prefix' => 'ha decidido desarrollar el &ldquo;',
                            'affix'  => '&rdquo; en adelante el',
                        ]
                    )
                );
                $this->replaceInDocumentContent($process, $replacements);
                
            }
            $bar->advance();
        }
        $bar->finish();
    }

    private function replaceDateInDocumentContent(Process $process): void
    {
        $pattern = '/En Iquique (a\s)?\d{1,2} de [a-zá-úñ]+ del (año\s)?\d{4}/i';
        $replacement = '<a data-lw="document_date_format">En Iquique a ' . $process->documentDateFormat . '</a>';

        if(preg_match($pattern, $process->document_content) && !str_contains($process->document_content, $replacement)){
            $doc = preg_replace(
                $pattern,
                $replacement,
                $process->document_content,
                1
            );
            $process->document_content = htmlspecialchars_decode($doc);
            $process->saveQuietly();
            $this->line('   - Date Replaced');
        }
    }

    private function replaceInDocumentContent(Process $process, array $replacements): void
    {
        // $dom = new \DOMDocument();
        // @$dom->loadHTML(mb_convert_encoding($process->document_content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD);

        foreach ($replacements as $replacement) {
            if(!is_null($replacement['value'])){
                $process->document_content = $this->agregarAnchors($process->document_content, $replacement['name'], $replacement['value'], $replacement['positions']);
            }
            // $this->replaceTextInNode($dom, $replacement['name'], $replacement['value'], $replacement['value']);
        }

        // $process->document_content = htmlspecialchars_decode($dom->saveHTML());

        // Guardar los cambios sin triggear el observer
        $process->saveQuietly();
    }

    private function replaceTextInNode(\DOMNode $node, string $name, string $val, string $prefix = '', string $affix = '', int $ref = null): void
    {
        if ($node->nodeType === XML_TEXT_NODE && str_contains($node->nodeValue, $val)) {
            $pass = true;
            foreach($node->parentNode->attributes as $attr){
                if($attr->name=='data-lw' && $node->nodeValue == $val){
                    $pass = false;
                    $this->line('   - ' . $name . ' Skipped');
                }
            }
            if($pass){
                $new = '<a data-lw="'. $name .'">' . $val . '</a>';
                $node->nodeValue = str_replace($val, $new, $node->nodeValue);
                $this->line('   - ' . $name . ' Replaced');
            }
            
        }
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                $this->replaceTextInNode($childNode, $name, $val);
            }
        }
    }

    function agregarAnchors(string $document_content, string $name, string $value, array $positions) {
        if (isset($positions) && is_array($positions)) {
            foreach ($positions as $pos) {
                $search = $pos['prefix'] ?? '';
                $search .= $value;
                $search .= $pos['affix'] ?? '';
                $replacement = '<a data-lw="' . $name . '"';
                
                if (isset($pos['ref'])) {
                    $replacement .= ' data-ref="' . $pos['ref'] . '"';
                }
                $replacement .= '>' . $value . '</a>';
                $search = html_entity_decode($search);
                $replacement = html_entity_decode($replacement);
                $document_content = html_entity_decode($document_content);
                if(str_contains($document_content, $search) && !str_contains($document_content, $replacement)){
                    $document_content = str_replace(
                        $search,
                        $replacement,
                        $document_content
                    );
                    $document_content = htmlspecialchars_decode($document_content);
                    $this->line('   - ' . $name . ' Replaced');
                }
            }
            return $document_content;
        }
    }

}