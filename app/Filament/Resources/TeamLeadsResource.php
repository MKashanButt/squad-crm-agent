<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamLeadsResource\Pages;
use App\Filament\Resources\LeadResource\Pages as LeadResource;
use App\Filament\Resources\TeamLeadsResource\RelationManagers;
use App\Models\TeamLeads;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TeamLeadsResource extends Resource
{
    protected static ?string $model = TeamLeads::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $id = Auth::id();
                $user = User::find($id);

                if ($user) {
                    $teamName = $user->team;
                    $query->where('team', $teamName);
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge('status')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transfer_status')
                    ->badge('status')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('centerCode.code')
                    ->numeric()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('insurance.insurance')
                    ->numeric()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products.products')
                    ->numeric()
                    ->copyable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient_phone')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('secondary_phone')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('first_name')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->copyable()
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('medicare_id')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_name')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('facility_name')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient_last_visit')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_phone')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_fax')
                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('doctor_npi')
                    ->copyable()
                    ->searchable()
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'denied' => 'Denied',
                        'error' => 'Error',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeamLeads::route('/'),
            'create' => LeadResource\CreateLead::route('/create'),
            'edit' => LeadResource\EditLead::route('/{record}/edit'),
        ];
    }
}
