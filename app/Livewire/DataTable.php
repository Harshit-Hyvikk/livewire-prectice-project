<?php

namespace App\Livewire;

use App\Filament\Exports\DataTableExporter;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;


class DataTable extends Component implements HasForms, HasTable
{
    public $darkMode = false;

    public function mount()
    {
        // Get the current dark mode status from session or local storage
        $this->darkMode = session('dark_mode', false);
    }

    public function toggleDarkMode()
    {
        // dd($this->darkMode);
        $this->darkMode = !$this->darkMode;
        session(['dark_mode' => $this->darkMode]); // Store preference in session
    }

    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                TextColumn::make('id')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')->searchable(),
                TextColumn::make('phone')->searchable(),
                TextColumn::make('address')->searchable(),
                TextColumn::make('city')->searchable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->extraAttributes(['class' => 'text-secondary-600']),
                    ExportBulkAction::make()
                        ->label('Export Data')
                        ->exporter(DataTableExporter::class),
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.data-table');
    }
}
