<?php

declare(strict_types=1);

namespace Src\Application\UseCases\GetFeaturedProductList;

class GetFeaturedProductListOutput
{
    /**
     * @param GetFeaturedProductListOutputItem[] $products
     */
    public function __construct(
        public readonly array $products,
    ) {}

    public static function build(array $products): self
    {
        $products = array_map(
            callback: fn(array $item) => new GetFeaturedProductListOutputItem(
                id: $item['id'],
                name: $item['name'],
                price: $item['price']
            ),
            array: $products
        );

        return new self(
            products: $products,
        );
    }
}


class GetFeaturedProductListOutputItem
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int|float $price,
    ) {}
}
