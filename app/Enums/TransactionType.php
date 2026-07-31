<?php

namespace App\Enums;

enum TransactionType: string
{
    case Income = 'income';
    case Expense = 'expense';

    public function label(): string
    {
        return match ($this) {
            self::Income => 'Kas Masuk',
            self::Expense => 'Kas Keluar',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::Income => 'success',
            self::Expense => 'danger',
        };
    }

    public function prefix(): string
    {
        return match ($this) {
            self::Income => 'KM',
            self::Expense => 'KK',
        };
    }

    public function isIncome(): bool
    {
        return $this === self::Income;
    }

    public function isExpense(): bool
    {
        return $this === self::Expense;
    }
}