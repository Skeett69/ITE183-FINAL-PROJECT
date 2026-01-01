<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\JobController;
use App\Controllers\ApplicationController;

/**
 * Define routes for AJAX endpoints.
 *
 * @param Router $router
 */
function loadAjaxRoutes($router)
{
    $authMiddleware = function () {
        if (!App\Core\Session::get('user_id')) {
            header('Location: /login');
            exit;
        }
    };

    // Authentication
    $router->post('/login', [AuthController::class, 'login']);

    $router->group($authMiddleware, function ($router) {
        // User Management API
        $router->get('/api/users', [UserController::class, 'index']);
        $router->post('/api/users', [UserController::class, 'store']);
        $router->get('/api/users/{id}', [UserController::class, 'show']);
        $router->put('/api/users/{id}', [UserController::class, 'update']);
        $router->delete('/api/users/{id}', [UserController::class, 'destroy']);
        $router->get('/api/users/find-by-email', [UserController::class, 'findByEmail']);

        // Job Management API
        $router->get('/api/jobs', [JobController::class, 'index']);
        $router->post('/api/jobs', [JobController::class, 'store']);
        $router->get('/api/jobs/{id}', [JobController::class, 'show']);
        $router->put('/api/jobs/{id}', [JobController::class, 'update']);
        $router->delete('/api/jobs/{id}', [JobController::class, 'destroy']);
        $router->get('/api/jobs/find-by-creator/{creatorId}', [JobController::class, 'findByCreator']);
        $router->get('/api/jobs/find-by-category/{categoryId}', [JobController::class, 'findByCategory']);

        // Applications Management API
        $router->get('/api/applications', [ApplicationController::class, 'index']);
        $router->post('/api/applications', [ApplicationController::class, 'store']);
        $router->get('/api/applications/{id}', [ApplicationController::class, 'show']);
        $router->put('/api/applications/{id}', [ApplicationController::class, 'update']);
        $router->delete('/api/applications/{id}', [ApplicationController::class, 'destroy']);
    });
}
