<?php

namespace App\DTO\Price;

use App\Models\Pricing;

class PriceWithTaxDTO
{
    /**
     * PriceWithTaxDTO constructor.
     *
     * This constructor initializes the PriceWithTaxDTO object.
     *
     * @param Pricing $pricing The pricing object.
     * @param float $subTotal The subtotal of the item.
     * @param float $tax The tax applied to the item.
     * @param float $totalTax The total tax applied to the item.
     * @param float $grandTotal The grand total including tax.
     */
    public function __construct(
        public Pricing $pricing,
        public float $subTotal,
        public float $tax,
        public float $totalTax,
        public float $grandTotal
    ) {}
}
