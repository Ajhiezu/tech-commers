<?php

namespace App\Filament\Resources\Withdrawals\Schemas;

use App\Enums\WithdrawalStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('store_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('bank_name')
                    ->required(),
                TextInput::make('bank_account')
                    ->required(),
                TextInput::make('bank_holder')
                    ->required(),
                Select::make('status')
                    ->options(WithdrawalStatus::class)
                    ->default('pending')
                    ->required(),
                Textarea::make('admin_note')
                    ->columnSpanFull(),
                DateTimePicker::make('processed_at'),
            ]);
    }
}
