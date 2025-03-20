<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationResource\Pages;
use App\Filament\Resources\EducationResource\RelationManagers;
use App\Models\Education;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EducationResource extends Resource
{
    protected static ?string $model = Education::class;
    protected static ?string $navigationLabel = 'Eğitim';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('school_name')
                    ->label('Okul İsmi')
                    ->required(),
                TextInput::make('field_of_study')
                    ->label('Bölüm'),
                TextInput::make('degree')
                    ->label('Ortalama')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal'),

                Forms\Components\Textarea::make('description')
                    ->label('Açıklama')
                    ->columnSpanFull(),

                DatePicker::make('start_date')
                    ->label('Başlangıç Tarihi')
                    ->required(),

                DatePicker::make('end_date')
                    ->label('Bitiş Tarihi')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                tables\Columns\TextColumn::make('school_name')
                ->label('Okul İsmi'),

            ])
            ->filters([
                //
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
            'index' => Pages\ListEducation::route('/'),
            'create' => Pages\CreateEducation::route('/create'),
            'edit' => Pages\EditEducation::route('/{record}/edit'),
        ];
    }
}
