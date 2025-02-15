<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Documents\Agreements\Process;
use App\Models\Documents\Agreements\ProcessType;
use App\Models\Documents\Template;
use Carbon\Carbon;

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
            'signer.appellative',
            'signer.decree',
            'signer.user.full_name',
            'mayor.name',
            'mayor.run',
            'mayor.appellative',
            'mayor.decree'
        ];
        foreach($replacements as $ref){
            $val = '{{'. $ref . '}}';
            $this->replaceTextInNode($dom, $ref, $val);            
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
                $this->replaceDateInDocumentContent($process);                
                if(!is_null($process->signer)){
                    $this->replaceSignerInDocumentContent($process);                    
                }
                if(!is_null($process->mayor)){
                    $this->replaceMayorInDocumentContent($process);                    
                }
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

    private function replaceSignerInDocumentContent(Process $process): void
    {
        $replacements = [
            'signer.appellative' => $process->signer->appellative,
            'signer.decree' => $process->signer->decree,
            'signer.user.full_name' =>  $process->signer->user->full_name
        ];
        $this->replaceInDocumentContent($process, $replacements);
        
    }

    private function replaceMayorInDocumentContent(Process $process): void
    {
        $replacements = [
            'mayor.name' => $process->mayor->name,
            'mayor.run' => $process->mayor->run,
            'mayor.appellative' => $process->mayor->appellative,
            'mayor.decree' => $process->mayor->decree,
        ];
        $this->replaceInDocumentContent($process, $replacements);
    }

    private function replaceInDocumentContent(Process $process, array $replacements): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($process->document_content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD);

        foreach ($replacements as $ref => $val) {
            $this->replaceTextInNode($dom, $ref, $val);
        }

        $process->document_content = htmlspecialchars_decode($dom->saveHTML());

        // Guardar los cambios sin triggear el observer
        $process->saveQuietly();
    }

    private function replaceTextInNode(\DOMNode $node, string $ref, string $val): void
    {
        if ($node->nodeType === XML_TEXT_NODE && str_contains($node->nodeValue, $val)) {
            $pass = true;
            foreach($node->parentNode->attributes as $attr){
                if($attr->name=='data-lw'){
                    $pass = false;
                    $this->line('   - ' . $ref . ' Skipped');
                }
            }
            if($pass){
                $new = '<a data-lw="'. $ref .'">' . $val . '</a>';
                $node->nodeValue = str_replace($val, $new, $node->nodeValue);
                $this->line('   - ' . $ref . ' Replaced');
            }
            
        }
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                $this->replaceTextInNode($childNode, $ref, $val);
            }
        }
    }
}
