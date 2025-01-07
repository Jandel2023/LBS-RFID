<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum BorrowTypeEnum: string implements HasLabel
{
    //
    case BORROW = 'borrow';
    case RETURN = 'return';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::BORROW => 'borrow',
            self::RETURN => 'return',
        };
    }
}
