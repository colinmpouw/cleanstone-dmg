<?php

namespace controllers;

class BundelsController
{
    public function __construct($router)
    {

        $router->get('/bundels', [$this, 'bundelsPage']);
        $router->get('/api/get_all_bundels', [$this, 'get_all_bundels']);


    }

    public function bundelsPage()
    {
        require __DIR__ . '/../public/bundels.php';
    }
    public function get_all_bundels() {
        $bundels = [
            [
                "image"         => "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&auto=format&fit=crop",
                "imageAlt"      => "Aanrechtblad",
                "discount"      => "-18%",
                "bestseller"    => true,
                "rating"        => 4.5,
                "reviewCount"   => 294,
                "title"         => "Aanrechtblad Starter",
                "subtitle"      => "Compleet pakket voor dagelijks onderhoud van uw aanrechtblad",
                "package"       => [
                    "Lithofin MN Allesreiniger 1L",
                    "Akemi Stone Sealer 500ml",
                    "Microvezel doeken (3st)",
                    "Gebruiksinstructies"
                ],
                "suitableFor"   => ["Graniet", "Marmer", "Composiet"],
                "price"         => "€89.95",
                "originalPrice" => "€109.95",
                "savings"       => "Bespaar €20",
                "link"          => "#"
            ],
            [
                "image"         => "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&auto=format&fit=crop",
                "imageAlt"      => "Bundel 2",
                "discount"      => null,
                "bestseller"    => false,
                "rating"        => 4.0,
                "reviewCount"   => 120,
                "title"         => "Bundel 2",
                "subtitle"      => "Beschrijving van bundel 2",
                "package"       => [
                    "Product A",
                    "Product B"
                ],
                "suitableFor"   => ["Graniet", "Marmer"],
                "price"         => "€29.99",
                "originalPrice" => "€39.99",
                "savings"       => "Bespaar €10",
                "link"          => "#"
            ],
            [
                "image"         => "https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=800&auto=format&fit=crop",
                "imageAlt"      => "Bundel 3",
                "discount"      => "-10%",
                "bestseller"    => false,
                "rating"        => 3.5,
                "reviewCount"   => 80,
                "title"         => "Bundel 3",
                "subtitle"      => "Beschrijving van bundel 3",
                "package"       => [
                    "Product X",
                    "Product Y",
                    "Product Z"
                ],
                "suitableFor"   => ["Composiet"],
                "price"         => "€39.99",
                "originalPrice" => "€44.99",
                "savings"       => "Bespaar €5",
                "link"          => "#"
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($bundels);
    }


}