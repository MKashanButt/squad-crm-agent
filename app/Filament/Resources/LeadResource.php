<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\Leads;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Laravel\Prompts\SearchPrompt;

class LeadResource extends Resource
{
    protected static ?string $model = Leads::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transfer_status')
                    ->options([
                        'Transferred' => 'Transferred',
                        'Not transferred' => 'Not transferred',
                        'Awaiting' => 'Awaiting'
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_status')
                    ->badge('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('centerCode.code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insurance.insurance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products.products')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('secondary_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('medicare_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facility_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient_last_visit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_fax')
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_npi')
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'denied' => 'Denied',
                        'error' => 'Error',
                        'payable' => 'Payable',
                        'approved' => 'Approved',
                        'wrong doc' => 'Wrong doc',
                        'paid' => 'Paid',
                    ]),
                SelectFilter::make('center_code_id')
                    ->relationship('centerCode', 'code')
                    ->searchable()
                    ->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            'create' => Pages\CreateLead::route('/create'),
            'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
