<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class Biodata extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.biodata';

    public $user;

    public ?array $data = [];

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->form->fill([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'image' => $this->user->image,
            'scanijazah' => $this->user->scanijazah,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Section::make('Biodata Diri')
                    ->schema([
                        TextInput::make('name')->label('Full Name')->required(),
                        TextInput::make('email')->label('Email Address')->email()->required(),
                        TextInput::make('password')->label('Password')->password()->nullable(),
                        TextInput::make('phone')->label('Phone Number')->required(),
                        FileUpload::make('image')->label('Profile Image')->directory('profile-images'),
                        FileUpload::make('scanijazah')->label('Scan Ijazah')->directory('scan-ijazah'),
                    ])
            ]);
    }

    public function edit(): void
    {
        $validatedData = $this->form->getState();

        $this->user->name = $validatedData['name'];
        $this->user->email = $validatedData['email'];
        $this->user->phone = $validatedData['phone'];

        if (!empty($validatedData['password'])) {
            $this->user->password = Hash::make($validatedData['password']);
        }

        if (isset($validatedData['image'])) {
            if ($this->user->image) {
                Storage::delete($this->user->image);
            }
            $this->user->image = $validatedData['image'];
        }

        if (isset($validatedData['scanijazah'])) {
            if ($this->user->scanijazah) {
                Storage::delete($this->user->scanijazah);
            }
            $this->user->scanijazah = $validatedData['scanijazah'];
        }

        $this->user->save();

        Notification::make()
            ->title('Biodata updated successfully.')
            ->success()
            ->send();
    }
}
