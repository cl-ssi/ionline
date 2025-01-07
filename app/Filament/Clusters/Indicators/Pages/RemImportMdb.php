<?php

namespace App\Filament\Clusters\Indicators\Pages;

use App\Filament\Clusters\Indicators;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\WithFileUploads;
use ZipArchive;
use App\Jobs\ProcessSqlLine;
use Illuminate\Support\Facades\DB;

class RemImportMdb extends Page
{
    use InteractsWithForms, WithFileUploads;

    public ?array $data = [];

    public $attachment;

    public $file;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $cluster = Indicators::class;

    protected static string $view = 'filament.clusters.indicators.pages.rem-import-mdb';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('attachment')
                    ->label('Archivo MDB')
                    ->directory('rems')
                    ->required()

                    ->hintAction(
                        Forms\Components\Actions\Action::make('ImportarMbd')
                            ->icon('heroicon-m-clipboard')
                            ->action(function () {
                                $this->file = reset($this->attachment);

                                $safeFilename = str_replace(' ', '_', $this->file->getClientOriginalName());

                                $mdbFilename = str_replace('zip', 'mdb',$safeFilename);

                                $fullpath = storage_path("app/rems/$mdbFilename");

                                $this->file->storeAs('rems', $safeFilename, 'local');

                                $zip = new ZipArchive;
                                $res = $zip->open(storage_path("app/rems/$safeFilename"));

                                if ($res === true) {
                                    $zip->extractTo(storage_path('app/rems'));
                                    $zip->close();
                                }

                                $command = "mdb-export $fullpath Registros | cut -d',' -f6 | head -n 2 | tail -n 1 | tr -d '\"'";
                                $year = trim(shell_exec($command));

                                $command = "mdb-export $fullpath Registros | cut -d',' -f3 | head -n 2 | tail -n 1 | tr -d '\"' |cut -d' ' -f2";
                                $serie = trim(shell_exec($command));

                                $tabla = "{$year}rems";

                                $command = "mdb-export -I mysql $fullpath Datos | sed 's/INTO `Datos`/INTO `$tabla`/'";
                                $sqlContent = shell_exec($command);
                        
                                $sqlLines = explode(";\n", $sqlContent);
                                foreach ($sqlLines as $index => $sql) {
                                    if (stripos($sql, 'INSERT INTO') !== false) {
                                        $tempSqlFile = storage_path("app/rems/sql_line_$index.sql");
                                        file_put_contents($tempSqlFile, $sql . ";\n");
                                    }
                                }

                                $connection = DB::connection('mysql_rem');
                                $sql = "DELETE FROM $tabla WHERE codigoprestacion IN (SELECT codigo_prestacion FROM {$year}prestaciones WHERE serie='$serie')";
                                $connection->statement($sql);

                                $files = glob(storage_path("app/rems/sql_line_*.sql"));

                                foreach ($files as $file) {
                                    $content = file_get_contents($file);
                                    ProcessSqlLine::dispatch($content);
                                    unlink($file); // Elimina el archivo después de despacharlo
                                }

                                Notification::make()
                                    ->title('Saved successfully '.$year)
                                    ->success()
                                    ->send();
                            })
                    ),
            ]);
    }
}
