<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkResource\Pages;
use App\Filament\Resources\WorkResource\RelationManagers;
use App\Models\Work;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;
    protected static ?string $navigationLabel = 'Portfolyo';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Başlık')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                        $set('slug', Str::slug($state)); // başlıktan otomatik slug oluştur
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('URL')
                    ->unique(ignoreRecord: true)
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Açıklama')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->label('Kapak Resmi')
                    ->image(),
                Forms\Components\TextInput::make('demo_link')
                    ->label('Demo Linki')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('github_link')
                    ->label('Github URL')
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('work_type')
                    ->label('Proje Türü')
                    ->required(),
                Forms\Components\TextInput::make('technologies')
                    ->label('Kullanılan Teknolojiler')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            RelationManagers\WorkImagesRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorks::route('/'),
            'create' => Pages\CreateWork::route('/create'),
            'edit' => Pages\EditWork::route('/{record}/edit'),
        ];
    }
}
