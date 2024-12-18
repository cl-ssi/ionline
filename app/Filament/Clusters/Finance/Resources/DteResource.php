<?php

namespace App\Filament\Clusters\Finance\Resources;

use App\Filament\Clusters\Finance;
use App\Filament\Clusters\Finance\Resources\DteResource\Pages;
use App\Filament\Clusters\Finance\Resources\DteResource\RelationManagers;
use App\Models\Finance\Dte;
use App\Models\Finance\PaymentFlow;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DteResource extends Resource
{
    protected static ?string $model = Dte::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Finance::class;

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tipo')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('tipo_documento')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('folio')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('emisor')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('razon_social_emisor')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('receptor')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('publicacion'),
                Forms\Components\DatePicker::make('emision'),
                Forms\Components\TextInput::make('monto_neto')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('monto_exento')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('monto_iva')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('monto_total')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('impuestos')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estado_acepta')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estado_sii')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estado_intercambio')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('informacion_intercambio')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('uri')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('referencias')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('fecha_nar'),
                Forms\Components\TextInput::make('estado_nar')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('uri_nar')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('mensaje_nar')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('uri_arm')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_arm'),
                Forms\Components\TextInput::make('fmapago')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('controller')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('fecha_vencimiento'),
                Forms\Components\TextInput::make('estado_cesion')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('url_correo_cesion')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_recepcion_sii'),
                Forms\Components\TextInput::make('estado_reclamo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_reclamo'),
                Forms\Components\TextInput::make('mensaje_reclamo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('estado_devengo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('codigo_devengo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('folio_oc')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_ingreso_oc'),
                Forms\Components\TextInput::make('folio_rc')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_ingreso_rc'),
                Forms\Components\TextInput::make('ticket_devengo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('folio_sigfe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tarea_actual')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('area_transaccional')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\DateTimePicker::make('fecha_ingreso'),
                Forms\Components\DateTimePicker::make('fecha_aceptacion'),
                Forms\Components\DateTimePicker::make('fecha'),
                Forms\Components\Select::make('contract_manager_id')
                    ->relationship('contractManager', 'name')
                    ->default(null),
                Forms\Components\Toggle::make('confirmation_status'),
                Forms\Components\TextInput::make('confirmation_sender_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('confirmation_send_at'),
                Forms\Components\Toggle::make('all_receptions'),
                Forms\Components\Select::make('all_receptions_user_id')
                    ->relationship('allReceptionsUser', 'name')
                    ->default(null),
                Forms\Components\Select::make('all_receptions_ou_id')
                    ->relationship('allReceptionsOu', 'name')
                    ->default(null),
                Forms\Components\DateTimePicker::make('all_receptions_at'),
                Forms\Components\TextInput::make('confirmation_signature_file')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('payment_ready'),
                Forms\Components\DateTimePicker::make('fin_payed_at'),
                Forms\Components\TextInput::make('fin_folio_devengo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('fin_folio_tesoreria')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('sender_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sender_ou')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('sender_at'),
                Forms\Components\TextInput::make('payer_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('payer_ou')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('payer_at'),
                Forms\Components\Select::make('establishment_id')
                    ->relationship('establishment', 'name')
                    ->default(null),
                Forms\Components\TextInput::make('cenabast_reception_file')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('cenabast_signed_pharmacist')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\TextInput::make('cenabast_signed_boss')
                    ->required()
                    ->maxLength(255)
                    ->default(0),
                Forms\Components\Toggle::make('block_signature')
                    ->required(),
                Forms\Components\TextInput::make('folio_compromiso_sigfe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('archivo_compromiso_sigfe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('folio_devengo_sigfe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('archivo_devengo_sigfe')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('comprobante_liquidacion_fondo')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('archivo_carga_manual')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('devuelto'),
                Forms\Components\Toggle::make('rejected'),
                Forms\Components\Textarea::make('reason_rejection')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('rejected_user_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\DateTimePicker::make('rejected_at'),
                Forms\Components\Toggle::make('excel_proveedor'),
                Forms\Components\Toggle::make('excel_cartera'),
                Forms\Components\Toggle::make('excel_requerimiento'),
                Forms\Components\Textarea::make('observation')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('paid'),
                Forms\Components\TextInput::make('paid_folio')
                    ->numeric()
                    ->default(null),
                Forms\Components\DatePicker::make('paid_at'),
                Forms\Components\TextInput::make('paid_effective_amount')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('paid_automatic'),
                Forms\Components\Toggle::make('paid_manual'),
                Forms\Components\Toggle::make('check_tesoreria')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('establishment.alias')
                    ->label('Estab.')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('emisor')
                    ->description(fn (Dte $record): string => $record->razon_social_emisor)
                    ->searchable()
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('folio')
                    ->label('Documento')
                    ->prefix(fn (Dte $record): string => $record->tipo_documento_iniciales .' ')
                    ->searchable()
                    ->wrap()
                    ->url(fn(Dte $record) => $record->uri ? $record->uri : null)
                    ->description(fn (Dte $record): string => str_replace('_', ' ', $record->estado_reclamo) ?? '')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('purchaseOrder.code')
                    ->label('OC')
                    ->description(fn (Dte $record): string => $record->purchaseOrder?->json?->Listado[0]?->Estado ?? '')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('requestForm.folio')
                    ->label('FR')
                    ->description(fn (Dte $record): string => $record->requestForm?->contractManager?->tinyName ?? '')
                    ->url(fn(Dte $record) => $record->requestForm ? route('request_forms.show', $record->requestForm?->id) : null)
                    ->searchable(),
                Tables\Columns\TextColumn::make('receptions.id')
                    ->label('Recepción')
                    ->bulleted()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('fecha_recepcion_sii')
                    ->label('Fecha Aceptación SII (días)')
                    ->date('Y-m-d')
                    ->description(fn (Dte $record): string => $record->fecha_recepcion_sii ? '(' . (int) $record->fecha_recepcion_sii->diffInDays(now()) .' días)': '')
                    ->sortable()
                    ->wrap()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('all_receptions_at')
                    ->label('A Revisión')
                    ->description(fn (Dte $record): string => $record->allReceptionsUser ? $record->allReceptionsUser?->shortName : '', position: 'above')
                    ->tooltip(fn (Dte $record): string => "{$record->allReceptionsOU?->name}")
                    ->sortable()
                    ->toggleable(),

                    // {{$dte->allReceptionsUser?->shortName}}<br>
                    // {{$dte->allReceptionsOU?->name}}<br>
                    // {{$dte->all_receptions_at}}
            
                // Tables\Columns\TextColumn::make('razon_social_emisor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('receptor')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('publicacion')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('emision')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('monto_neto')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('monto_exento')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('monto_iva')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('monto_total')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('impuestos')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('estado_acepta')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('estado_sii')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('estado_intercambio')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('informacion_intercambio')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('uri')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_nar')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('estado_nar')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('uri_nar')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('mensaje_nar')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('uri_arm')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_arm')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('fmapago')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_vencimiento')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('estado_cesion')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('url_correo_cesion')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('estado_reclamo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_reclamo')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('mensaje_reclamo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('estado_devengo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('codigo_devengo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('folio_oc')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_ingreso_oc')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('folio_rc')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_ingreso_rc')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('ticket_devengo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('folio_sigfe')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('tarea_actual')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('area_transaccional')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fecha_ingreso')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('fecha_aceptacion')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('fecha')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('contractManager.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('confirmation_status')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('confirmation_sender_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('confirmation_send_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('all_receptions')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('allReceptionsUser.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('allReceptionsOu.name')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('all_receptions_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('confirmation_signature_file')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('payment_ready')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('fin_payed_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('fin_folio_devengo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('fin_folio_tesoreria')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('sender_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sender_ou')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('sender_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('payer_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('payer_ou')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('payer_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('cenabast_reception_file')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('cenabast_signed_pharmacist')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('cenabast_signed_boss')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('block_signature')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('folio_compromiso_sigfe')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('archivo_compromiso_sigfe')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('folio_devengo_sigfe')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('archivo_devengo_sigfe')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('comprobante_liquidacion_fondo')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('archivo_carga_manual')
                //     ->searchable(),
                // Tables\Columns\IconColumn::make('devuelto')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('rejected')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('rejected_user_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('rejected_at')
                //     ->dateTime()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('excel_proveedor')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('excel_cartera')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('excel_requerimiento')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('paid')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('paid_folio')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('paid_at')
                //     ->date()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('paid_effective_amount')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\IconColumn::make('paid_automatic')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('paid_manual')
                //     ->boolean(),
                // Tables\Columns\IconColumn::make('check_tesoreria')
                //     ->boolean(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('A revisión')
                    ->action(action: function ($record): void {
                        $record->update([
                            'all_receptions' => true,
                            'all_receptions_user_id' => auth()->id(),
                            'all_receptions_ou_id' => auth()->user()->organizational_unit_id,
                            'all_receptions_at' => now(),
                        ]);
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible(condition: fn (Dte $record): bool => $record->all_receptions === false),
                Tables\Actions\Action::make('pendienteTgr')
                    ->label('Pendiente TGR')
                    ->action(action: function ($record): void {
                        $record->update([
                            'payment_ready' => true,
                            'sender_id' => auth()->id(),
                            'sender_ou' => auth()->user()->organizational_unit_id,
                            'sender_at' => now(),
                        ]);
                        //TODO: porque es necesario el save()?
                        // No me funciona si no lo agrego
                        $record->save();
                        PaymentFlow::create([
                            'dte_id' => $record->id,
                            'user_id' => auth()->id(),
                            'status' => 'Enviado a Pendiente Para Pago',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->hidden( fn (Dte $record) => $record->payment_ready),
                Tables\Actions\Action::make('Devolver a revisión')
                    ->label('Devolver a revisión')
                    ->action(action: function ($record): void {
                        $record->update([
                            'payment_ready' => null,
                            'sender_id' => null,
                            'sender_ou' => null,
                            'sender_at' => null,
                            ]);
                        //TODO: porque es necesario el save()?
                        // No me funciona si no lo agrego
                        $record->save();
                        PaymentFlow::create([
                            'dte_id' => $record->id,
                            'user_id' => auth()->id(),
                            'status' => 'Enviado a Pendiente Para Pago',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-currency-dollar')
                    ->color('success')
                    ->visible( fn (Dte $record) => $record->payment_ready),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('fecha_recepcion_sii', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDtes::route('/'),
            'create' => Pages\CreateDte::route('/create'),
            // 'edit' => Pages\EditDte::route('/{record}/edit'),
        ];
    }
}
