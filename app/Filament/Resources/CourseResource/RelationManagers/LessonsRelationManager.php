<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

// ==========================================================
// BAGIAN 1: Perbaiki dan tambahkan 'use statement'
// ==========================================================
use App\Filament\Resources\QuizResource;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LessonsRelationManager extends RelationManager
{
    protected static string $relationship = 'lessons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->required()
                    ->fileAttachmentsDisk('public') // <-- Tambahkan ini
                    ->fileAttachmentsDirectory('editor-uploads') // <-- Tambahkan ini
                    ->columnSpanFull(),
                FileUpload::make('attachment')
                    ->label('Materi Tambahan (Opsional)')
                    ->directory('lesson-attachments') // Simpan di folder storage/app/public/lesson-attachments
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // ==========================================================
                // BAGIAN 2: Tambahkan action "Kelola Kuis" di sini
                // ==========================================================
                Tables\Actions\Action::make('manage_quiz')
                    ->label('Kelola Kuis')
                    ->icon('heroicon-o-question-mark-circle')
                    // Arahkan ke halaman edit kuis yang dimiliki oleh lesson ini.
                    // Jika belum ada kuis, Filament akan otomatis mengarahkan ke halaman create.
                    ->url(fn ($record) => QuizResource::getUrl($record->quiz ? 'edit' : 'create', [
                        'record' => $record->quiz,
                        'lesson_id' => $record->id, // Mengirim ID lesson untuk form create
                    ])),
                Tables\Actions\Action::make('view_lesson')
                    ->label('View Lesson')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => route('lessons.show', [$record->course, $record]), shouldOpenInNewTab: true),
           ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
