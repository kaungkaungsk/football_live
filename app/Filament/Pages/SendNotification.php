<?php

namespace App\Filament\Pages;

use App\FireNotification;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification as NotificationsNotification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class SendNotification extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.send-notification';

    protected static ?string $navigationLabel = 'Send Message';

    protected static ?string $navigationGroup = 'Management';

    protected static ?string $modelLabel = 'Send Message';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Notification Title')
                    ->required(),
                TextInput::make('message')
                    ->label('Message')
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Send')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            FireNotification::sendNotification($data['title'], $data['message']);

            $this->reset('data.title', 'data.message');
        } catch (Halt $exception) {
            return;
        }

        NotificationsNotification::make()
            ->success()
            ->title('Successfully Send!')
            ->send();
    }
}
