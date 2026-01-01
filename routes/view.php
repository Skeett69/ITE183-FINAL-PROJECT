<?php

use App\Controllers\AuthController;
use App\Core\Session;

/**
 * Define routes for pages/views.
 *
 * @param Router $router
 */
function loadViewRoutes($router)
{
    $authMiddleware = function () {
        if (!Session::get('user_id')) {
            header('Location: /login');
            exit;
        }
    };

    // Root route - redirect to login or dashboard based on auth status
    $router->get('/', function () {
        if (Session::get('user_id')) {
            header('Location: /dashboard');
        } else {
            header('Location: /login');
        }
        exit;
    });

    $router->get('/login', [AuthController::class, 'showLogin']);

    $router->group($authMiddleware, function ($router) {
        $router->get('/dashboard', [AuthController::class, 'showDashboard']);
        $router->get('/logout', [AuthController::class, 'logout']);
        
        // View Routes for Pages
        $router->get('/jobs', function () {
            \App\Core\View::render('jobs.html', ['title' => 'Jobs']);
        });
        
        $router->get('/applications', function () {
            \App\Core\View::render('applications.html', ['title' => 'Applications']);
        });
        
        $router->get('/candidates', function () {
            \App\Core\View::render('candidates.html', ['title' => 'Candidates']);
        });
        
        $router->get('/messages', function () {
            \App\Core\View::render('messages.html', ['title' => 'Messages']);
        });
        
        $router->get('/profile', function () {
            \App\Core\View::render('profile.html', ['title' => 'Profile']);
        });
        
        $router->get('/settings', function () {
            \App\Core\View::render('settings.html', ['title' => 'Settings']);
        });
    });
}
