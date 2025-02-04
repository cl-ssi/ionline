<?php

namespace App\Observers\Documents\Agreements;

use App\Models\Parameters\Mayor;
use App\Models\Documents\Agreements\Signer;
use App\Models\Documents\Agreements\Process;

class ProcessObserver
{
    /**
     * Handle the Process "creating" event.
     */
    public function creating(Process $process): void
    {
        $process->signer_appellative = $process->signer->appellative;
        $process->signer_decree = $process->signer->decree;
        $process->signer_name = $process->signer->user->full_name;

        $process->municipality_name = $process->municipality->name;
        $process->municipality_rut = $process->municipality->rut;
        $process->municipality_address = $process->municipality->address;

        $process->mayor_name = $process->mayor->name;
        $process->mayor_run = $process->mayor->run;
        $process->mayor_appellative = $process->mayor->appellative;
        $process->mayor_decree = $process->mayor->decree;

        $process->period = $process->program->period;
        $process->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Handle the Process "created" event.
     */
    public function created(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "updating" event.
     */
    public function updating(Process $process): void
    {
        $process->signer_appellative = $process->signer->appellative;
        $process->signer_decree = $process->signer->decree;
        $process->signer_name = $process->signer->user->full_name;

        $process->municipality_name = $process->municipality->name;
        $process->municipality_rut = $process->municipality->rut;
        $process->municipality_address = $process->municipality->address;

        $process->mayor_name = $process->mayor->name;
        $process->mayor_run = $process->mayor->run;
        $process->mayor_appellative = $process->mayor->appellative;
        $process->mayor_decree = $process->mayor->decree;
        // $process->establishment_id = auth()->user()->establishment_id;
    }

    /**
     * Handle the Process "updated" event.
     */
    public function updated(Process $process): void
    {
        // Reemplazar la fecha en el document_content si cambia el document_date
        if ($process->isDirty('document_date')) {
            $this->replaceDateInDocumentContent($process);
        }

        // Reemplazar contenido si cambia el firmante
        if ($process->isDirty('signer_id')) {
            $this->replaceSignerInDocumentContent($process);
        }

        // Reemplazar contenido si cambia el alcalde
        if ($process->isDirty('mayor_id')) {
            $this->replaceMayorInDocumentContent($process);
        }
    }

    private function replaceDateInDocumentContent(Process $process): void
    {
        $pattern = '/En Iquique a \d{1,2} de [a-zá-úñ]+ del? \d{4}/i';
        $replacement = "En Iquique a " . $process->documentDateFormat;

        $process->document_content = preg_replace(
            $pattern,
            $replacement,
            $process->document_content,
            1
        );

        // Guardar los cambios sin triggear el observer
        $process->saveQuietly();
    }

    private function replaceSignerInDocumentContent(Process $process): void
    {
        $oldSigner = Signer::find($process->getOriginal('signer_id'));
        $newSigner = $process->signer;

        if ($oldSigner && $newSigner) {
            $replacements = [
                $oldSigner->appellative => $newSigner->appellative,
                $oldSigner->decree => $newSigner->decree,
                $oldSigner->user->full_name => $newSigner->user->full_name,
            ];

            $this->replaceInDocumentContent($process, $replacements);
        }
    }

    private function replaceMayorInDocumentContent(Process $process): void
    {
        $oldMayor = Mayor::find($process->getOriginal('mayor_id'));
        $newMayor = $process->mayor;

        if ($oldMayor && $newMayor) {
            $replacements = [
                $oldMayor->name => $newMayor->name,
                $oldMayor->run => $newMayor->run,
                $oldMayor->appellative => $newMayor->appellative,
                $oldMayor->decree => $newMayor->decree,
            ];

            $this->replaceInDocumentContent($process, $replacements);
        }
    }

    private function replaceInDocumentContent(Process $process, array $replacements): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML(mb_convert_encoding($process->document_content, 'HTML-ENTITIES', 'UTF-8'));

        foreach ($replacements as $old => $new) {
            $this->replaceTextInNode($dom, $old, $new);
        }

        $process->document_content = $dom->saveHTML();

        // Guardar los cambios sin triggear el observer
        $process->saveQuietly();
    }

    private function replaceTextInNode(\DOMNode $node, string $old, string $new): void
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $node->nodeValue = str_replace($old, $new, $node->nodeValue);
        }

        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $childNode) {
                $this->replaceTextInNode($childNode, $old, $new);
            }
        }
    }

    /**
     * Handle the Process "deleted" event.
     */
    public function deleting(Process $process): void
    {
        // Borrar todos los apprvals
        $process->quotas()->delete();
        $process->comments()->delete();
        $process->approval()->delete();
        $process->endorses()->delete();
        $process->signedCommuneFile()->delete();
        $process->finalProcessFile()->delete();
        $process->files()->delete();
    }

    /**
     * Handle the Process "deleted" event.
     */
    public function deleted(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "restored" event.
     */
    public function restored(Process $process): void
    {
        //
    }

    /**
     * Handle the Process "force deleted" event.
     */
    public function forceDeleted(Process $process): void
    {
        //
    }
}
