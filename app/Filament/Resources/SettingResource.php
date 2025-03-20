<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationLabel = 'Site Ayarları';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                textInput::make('site_title')
                    ->label('Site İsmi')
                    ->required(),
                textInput::make('site_description')
                    ->label('Site Açıklaması'),

                Fileupload::make('site_logo')
                    ->label('Site Logo')
                    ->required()
                    ->image()
                    ->imageEditor(),
                Fileupload::make('site_favicon')
                    ->label('Site Favicon')
                    ->required()
                    ->image()
                    ->imageEditor(),
                textInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                textInput::make('phone')
                    ->label('Telefon Numarası')
                    ->required()
                    ->tel(),

            Forms\Components\Section::make('Sosyal Medya')
            ->schema([
                textInput::make('instagram')
                    ->label('İnstagram Linki')
                    ->required()
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt'),
                textInput::make('linkedin')
                    ->label('Linkedin Linki')
                    ->required()
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt'),
                textInput::make('github')
                    ->label('Github Linki')
                    ->required()
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt'),
            ])
                ->collapsible(),

            Forms\Components\Section::make('META')
                ->schema([
                    Textarea::make('meta_keywords')
                        ->label('Meta Anahtar Kelimeler')
                        ->required()
                        ->maxLength(300),

                    Textarea::make('meta_description')
                        ->label('Meta Açıklama')
                        ->required()
                        ->maxLength(255),
                ])
                ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                textColumn::make('site_title')
                    ->label('Site Ayarları')
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
