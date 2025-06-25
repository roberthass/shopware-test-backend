<?php

namespace App\Tests\unit;

use App\Model\Product;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * @return array[]
     */
    public static function createFromApiArrayProvider(): array
    {
        return [
            [
                [
                    'attributes' => [
                        'productNumber' => 'AB123'
                    ]
                ],
                new Product()->setNumber('AB123')
            ],
            [
                [
                    'attributes' => [
                        'productNumber' => 'AB123',
                        'name' => 'Test Product Name'
                    ]
                ],
                new Product()->setNumber('AB123')->setName('Test Product Name')
            ],
            [
                [
                    'attributes' => [
                        'productNumber' => 'AB123',
                        'name' => 'Test Product Name',
                        'availableStock' => 25
                    ]
                ],
                new Product()->setNumber('AB123')->setName('Test Product Name')->setAvailableStock(25)
            ],
            [
                [
                    'attributes' => [
                        'productNumber' => 'AB123',
                        'name' => 'Test Product Name',
                        'availableStock' => 25,
                        'price' => [
                            [
                                'gross' => 29.95
                            ]
                        ]
                    ]
                ],
                new Product()->setNumber('AB123')->setName('Test Product Name')->setAvailableStock(25)->setPriceGross(29.95)
            ],
        ];
    }

    /**
     * @param array $productsArray
     * @param Product $expectedProduct
     * @return void
     */
    #[DataProvider('createFromApiArrayProvider')]
    public function testCreateFromApiArray(array $productsArray, Product $expectedProduct): void
    {
        $this->assertEquals($expectedProduct, Product::createFromApiArray($productsArray));
    }
}
