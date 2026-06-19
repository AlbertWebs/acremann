<?php

namespace Tests\Unit;

use App\Support\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function test_format_kes_adds_thousands_separators(): void
    {
        $this->assertSame('850,000', Money::formatKes(850000));
        $this->assertSame('1,200,000', Money::formatKes('1200000.00'));
    }

    public function test_format_kes_prefixed_includes_currency(): void
    {
        $this->assertSame('KES 400,000', Money::formatKesPrefixed(400000));
    }

    public function test_format_property_price_uses_numeric_price_when_label_missing(): void
    {
        $this->assertSame('KES 950,000', Money::formatPropertyPrice(950000));
    }

    public function test_normalize_price_label_adds_commas_to_bare_amounts(): void
    {
        $this->assertSame('From 430,000', Money::normalizePriceLabel('From 430000'));
        $this->assertSame('From KES 850,000', Money::normalizePriceLabel('From KES 850,000'));
        $this->assertSame('From KES 950,000', Money::normalizePriceLabel('From KES 950000'));
    }
}
