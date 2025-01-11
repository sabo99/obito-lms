<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Pricing;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Customers';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Product and Price')
                        ->schema([
                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\Select::make('pricing_id')
                                        ->relationship('pricing', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function (Set $set, ?string $state) {
                                            $pricing = Pricing::find($state);

                                            $price = $pricing->price;
                                            $duration = $pricing->duration;

                                            $subTotal = $price * $state;
                                            $totalPpn = $subTotal * 0.11;
                                            $totalAmount = $subTotal + $totalPpn;

                                            $set('sub_total_amount', $subTotal);
                                            $set('total_tax_amount', $totalPpn);
                                            $set('grand_total_amount', $totalAmount);
                                            $set('duration', $duration);
                                            $set('started_at', null);
                                            $set('ended_at', null);
                                        })
                                        ->afterStateHydrated(function ($state, Set $set) {
                                            $pricingId = $state;
                                            if ($pricingId) {
                                                $pricing = Pricing::find($pricingId);
                                                $duration = $pricing->duration;
                                                $set('duration', $duration);
                                            }
                                        }),
                                    Forms\Components\TextInput::make('duration')
                                        ->numeric()
                                        ->required()
                                        ->readOnly()
                                        ->prefix('Months'),
                                ]),

                            Forms\Components\Grid::make(3)
                                ->schema([
                                    Forms\Components\TextInput::make('sub_total_amount')
                                        ->numeric()
                                        ->required()
                                        ->readOnly()
                                        ->prefix('IDR'),
                                    Forms\Components\TextInput::make('total_tax_amount')
                                        ->numeric()
                                        ->required()
                                        ->readOnly()
                                        ->prefix('IDR'),
                                    Forms\Components\TextInput::make('grand_total_amount')
                                        ->numeric()
                                        ->required()
                                        ->readOnly()
                                        ->prefix('IDR')
                                        ->helperText('Harga sudah termasuk PPN 11%'),
                                ]),

                            Forms\Components\Grid::make(2)
                                ->schema([
                                    Forms\Components\DatePicker::make('started_at')
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                            $duration = $get('duration');
                                            if ($state && $duration) {
                                                $endedAt = Carbon::parse($state)->addMonths($duration);
                                                $set('ended_at', $endedAt->format('Y-m-d'));
                                            }
                                        }),

                                    Forms\Components\DatePicker::make('ended_at')
                                        ->readOnly()
                                        ->required(),
                                ]),

                        ]),

                    Forms\Components\Wizard\Step::make('Customer Information')
                        ->schema([
                            Forms\Components\Select::make('user_id')
                                ->relationship('student', 'email')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->afterStateUpdated(function (Set $set, ?string $state) {
                                    $user = User::find($state);

                                    $name = $user->name;
                                    $email = $user->email;

                                    $set('name', $name);
                                    $set('email', $email);
                                })
                                ->afterStateHydrated(function ($state, Set $set) {
                                    $userId = $state;
                                    if ($userId) {
                                        $user = User::find($userId);
                                        $name = $user->name;
                                        $email = $user->email;
                                        $set('name', $name);
                                        $set('email', $email);
                                    }
                                }),
                            Forms\Components\TextInput::make('name')
                                ->maxLength(255)
                                ->required()
                                ->readOnly(),
                            Forms\Components\TextInput::make('email')
                                ->maxLength(255)
                                ->required()
                                ->readOnly(),
                        ]),

                    Forms\Components\Wizard\Step::make('Payment Information')
                        ->schema([
                            Forms\Components\ToggleButtons::make('is_paid')
                                ->label('Payment Status')
                                ->boolean()
                                ->grouped()
                                ->icons([
                                    true => 'heroicon-o-pencil',
                                    false => 'heroicon-o-clock',
                                ])
                                ->required(),

                            Forms\Components\Select::make('payment_type')
                                ->options([
                                    'Manual' => 'Manual',
                                    'Midtrans' => 'Midtrans',
                                ])
                                ->required(),

                            Forms\Components\FileUpload::make('payment_proof')
                                ->image(),
                        ]),
                ])
                    ->columnSpanFull()
                    ->columns(1)
                    ->skippable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('student.photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('student.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pricing.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grand_total_amount')
                    ->label('Total Amount')
                    ->money('IDR'),
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Payment Status'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->action(function (Transaction $record) {
                        $record->is_paid = true;
                        $record->save();

                        Notification::make()
                            ->title('Payment Approved')
                            ->success()
                            ->body('Payment has been approved successfully')
                            ->send();
                    })
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Transaction $record) => ! $record->is_paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
