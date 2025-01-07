<?php

namespace App\Filament\Clusters\Indicators\Pages;

use App\Filament\Clusters\Indicators;
use App\Models\Indicators\Rem;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Pages\SubNavigationPosition;
use Illuminate\Support\HtmlString;
use Livewire\WithFileUploads;

class RemImportMdb extends Page
{
    use InteractsWithForms, WithFileUploads;

    public ?array $data = [];

    public $mdbfiles;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $cluster = Indicators::class;

    protected static string $view = 'filament.clusters.indicators.pages.rem-import-mdb';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function canAccess(): bool
    {
        return auth()->user()->canAny(['be god','Rem: admin']);
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('mdbfiles')
                    ->label('Archivo MDB')
                    ->directory('rems')
                    ->helperText(new HtmlString('
                        <ul>
                            <li>Seleccione el archivo desde su computador, 
                                espere a que termine de cargar y luego presione el botón azúl para procesar.</li>
                            <li>Un solo archivo por cada mdb.</li>
                            <li>El archivo debe estar comprimido en zip, <b>Usar el compresor de zip de windows (enviar a > carpeta comprimida)</b></li>
                                ej: archivo 02A21022024.mdb > comprimir en 02A21022024.zip</li>
                            <li>El archivo debe pertenecer al año actual o al anterior</li>
                        </ul>'))
                    ->required(),

                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('cargarMdb')
                        ->icon('heroicon-m-star')
                        ->action(function () {
                            $this->validate();
                            Rem::importMdb(reset($this->mdbfiles));
                            $this->form->fill();
                        }),

                ]),
            ]);
    }
}
