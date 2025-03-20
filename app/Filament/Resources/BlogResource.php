<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationLabel = 'Blog Yazıları';


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

                Forms\Components\RichEditor::make('content')
                    ->label('İçerik')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('excerpt')
                    ->label('Özet')
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('Resim')
                    ->image()
                    ->imageEditor(),

                TextInput::make('meta_description')
                    ->label('Meta Açıklama')
                    ->maxLength(155),

                TextInput::make('meta_keywords')
                    ->label('Meta Anahtar Kelimeler')
                    ->maxLength(50),

                TextInput::make('seo_title')
                    ->label('SEO Başlığı')
                    ->maxLength(70),

                Toggle::make('status')
                    ->label('Yayında mı?')
                    ->default(true),

                DateTimePicker::make('published_at')
                    ->label('Yayınlanma Tarihi')
                    ->default(now()->startOfDay())
                    ->displayFormat('d.m.Y')
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? $state : now())


            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Yayında mı?'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayım Tarihi')
                    ->date('d.m.Y')
                    ->sortable(),
            ])

            ->defaultSort('published_at', 'desc')

            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Yayında mı?')
                    ->placeholder('Tümü')
                    ->trueLabel('Yayında')
                    ->falseLabel('Taslak'),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
