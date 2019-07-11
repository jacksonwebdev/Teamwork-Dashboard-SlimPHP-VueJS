<?php

// root, home to dashboard general info
$app->get('/', 'controller.app:home')
    ->setName('home');

// login routes
$app->group('', function () {
    $this->map(['GET', 'POST'], '/login', 'controller.auth:login')->setName('login');
    $this->map(['GET', 'POST'], '/register', 'controller.auth:register')->setName('register');
})->add($container['middleware.guest']);

$app->get('/logout', 'controller.auth:logout')
    ->add($container['middleware.auth']())
    ->setName('logout');

// API routes
// Teamwork
$app->group('/api/teamwork', function () {
    // teamwork billable hours
   $this->map(['GET'], '/hours/{type}[/{user_id}]', 'App\Controller\Teamwork\TeamworkBillableHoursController:get')->setName('login');
})->add($container['middleware.guest']);