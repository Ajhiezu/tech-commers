<?php

namespace App\Filament\Resources\Stores\Schemas;

use App\Enums\StoreStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('logo'),
                TextInput::make('banner'),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(StoreStatus::class)
                    ->default('pending')
                    ->required(),
                TextInput::make('commission_rate')
                    ->numeric(),
                TextInput::make('balance')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('address')
                    ->columnSpanFull(),
                TextInput::make('province_id'),
                TextInput::make('city_id'),
                Toggle::make('is_featured')
                    ->required(),
                DateTimePicker::make('verified_at'),
                Textarea::make('rejected_reason')
                    ->columnSpanFull(),
            ]);
    }
}
