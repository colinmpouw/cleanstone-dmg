<?php

namespace controllers;

class MijnReviewsController {

    public function __construct($router)
    {
        $router->get('/mijn-reviews', [$this, 'ShowMijnReviews']);
    }

    public function ShowMijnReviews(): void
    {
        require __DIR__ . '/../public/mijn-reviews.php';
    }
}