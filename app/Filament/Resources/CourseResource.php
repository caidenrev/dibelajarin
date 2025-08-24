<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // Add this import
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use App\Filament\Resources\CourseResource\RelationManagers;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->maxSize(2048)
                    ->directory('course-thumbnails')
                    ->visibility('public')
                    ->beforeUpload(function ($file) {
                        try {
                            if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'instructor'])) {
                                Log::error('Unauthorized upload attempt', [
                                    'user' => Auth::id(),
                                    'role' => Auth::user()->role ?? 'none'
                                ]);
                                return false;
                            }
                            return true;
                        } catch (\Exception $e) {
                            Log::error('Upload validation error: ' . $e->getMessage());
                            return false;
                        }
                    })
                    ->afterUpload(function ($file) {
                        Log::info('Course thumbnail uploaded', [
                            'filename' => $file->getFilename(),
                            'path' => $file->getPath(),
                            'user' => Auth::id()
                        ]);
                    })
                    ->required()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->panelAspectRatio('16:9')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('16:9'),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, \Filament\Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(Course::class, 'slug', ignoreRecord: true)
                    ->disabled(fn (string $operation): bool => $operation !== 'create'),
                RichEditor::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('instructor.name')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
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
            RelationManagers\LessonsRelationManager::class,
            RelationManagers\EnrolledStudentsRelationManager::class, // <-- Ini yang baru
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with('instructor', 'category');
        $user = auth()->user();

        // Jika user adalah admin, tampilkan semua kursus.
        if ($user->role === 'admin') {
            return $query;
        }

        // Jika bukan admin (misal: instruktur), hanya tampilkan kursus miliknya.
        return $query->where('user_id', $user->id);
    }
}
