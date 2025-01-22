<?php

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Resources\ProfileResource;
use App\Models\Book;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewProfile extends ViewRecord
{
    protected static string $resource = ProfileResource::class;

    public $defaultAction = '';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if (
            request()->query('new-borrower') == 'true' &&
            $this->getRecord()->borrowers()->doesntExist()
        ) {
            $this->defaultAction = 'newBorrower';
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            // $this->newBorrower(),
            $this->borrowBook(),
            Actions\EditAction::make(),
        ];
    }

    public function borrowBook(): Actions\Action
    {
        return Actions\Action::make('borrow-book')
            ->modal()
            ->label('Borrow Book')
            // ->modalWidth('7xl');
            ->disabled($this->getRecord()->trashed())
            ->closeModalByClickingAway(false)
            // ->slideOver()
            ->form([
                Forms\Components\Select::make('book_id')
                // ->columnSpanFull()
                    ->live()
                    ->required()
                    ->label('Borrow ISBN')
                    ->searchable(['isbn', 'title'])
                    ->preload()
                    ->options(Book::all()->pluck('isbn', 'id')->all())
                    ->afterStateUpdated(function ($set, $state) {

                        if (! empty($state)) {
                            $book = Book::findorFail($state)->latest()->first();

                            $author = $book->author()->latest()->first();
                            $authorFullname = $author->first_name.' '.$author->last_name;

                            $category = $book->category()->latest()->first()->name;

                            // dd($authorFullname);
                            // dd($book->book_image);
                            // $set('book_image', $book->book_image);
                            $set('title', $book->title);
                            $set('author', $authorFullname);
                            $set('category', $category);
                            $set('published_date', $book->published_date);
                        } else {
                            return null;
                        }
                    }),
                Forms\Components\Fieldset::make('Book Details')
                    ->columns(2)
                    ->schema([
                        // Forms\Components\FileUpload::make('book_image')
                        //     ->previewable()
                        //     ->columnSpanFull()
                        //     ->imagePreviewHeight(200)
                        //     ->image(),
                        Forms\Components\TextInput::make('title')
                            ->readOnly()
                            ->columnSpanFull()
                            ->label('Title'),
                        Forms\Components\TextInput::make('author')
                            ->readOnly()
                            ->label('Author'),
                        Forms\Components\TextInput::make('category')
                            ->readOnly()
                            ->label('Category'),
                        Forms\Components\DatePicker::make('published_date')
                            ->readOnly()
                            ->native(false)
                            ->label('Published Date'),
                    ])->visible(fn ($get) => ! empty($get('book_id'))),

            ])->action(function (array $data, $record) {
                // dd($data);

                $borrower = $this->getRecord()->borrowers()->latest()->first();

                $borrower->borrowed_books()->create([
                    'book_id' => $data['book_id'],
                ]);

                $borrower->save();

                Notification::make()
                    ->title('Borrowed Successfully!')
                    ->icon('heroicon-o-check-circle')
                    ->success()
                    ->send();

            });
    }

    public function newBorrower(): Actions\Action
    {
        return Actions\Action::make('new-borrower')
            ->label('New Borrower')
            ->requiresConfirmation()
            // ->live()
            ->disabled(! empty($this->getRecord()->borrowers()->latest()->first()))
            ->action(function (array $data, $record) {
                // dd('aw');
                // dd($record->id);
                $record->borrowers()->create();

                Notification::make()
                    ->title('Add to Borrower!')
                    ->icon('heroicon-o-check-circle')
                    ->success()
                    ->send();

                return $this->redirect(ProfileResource::getUrl('view', ['record' => $record]), navigate: true);
            });
    }
}
