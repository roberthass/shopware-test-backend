<?php

namespace App\Controller;

use App\Model\Product;
use App\Service\ShopwareAdminApi\Fetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Attribute\Model;

class ProductController extends AbstractController
{
    #[Route('/api/products', name: 'get_products', methods: ['GET'])]
    #[OA\Get(
        description: 'Fetches products from shopware api and return reduced product data array',
        tags: ['Product'],
        responses: [
            new OA\Response(
                response: Response::HTTP_OK,
                description: 'Success',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(
                        ref: new Model(
                            type: Product::class,
                        )
                    )
                )
            )
        ]
    )]
    public function getProducts(Fetcher $fetcher): JsonResponse
    {
        return new JsonResponse($fetcher->getProducts());
    }
}
