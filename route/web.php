<?php

use App\Controllers\CodeSnippetController;


return [
    '/'=>[
        'controller' => CodeSnippetController::class,
        'method' => 'index',
        'methods' => ['GET']
    ],
    '/snippets/create'=>[
        'controller' => CodeSnippetController::class,
        'method' => 'create',
        'methods' => ['GET']
    ],  
    '/snippets/store'=>[
        'controller' => CodeSnippetController::class,
        'method' => 'store',
        'methods' => ['POST']
    ],
    '/snippets/show'=>[
        'controller' => CodeSnippetController::class,
        'method' => 'show',
        'methods' => ['GET']
    ],
    '/api/snippets'=>[
        'controller' => CodeSnippetController::class,
        'method' => 'api',
        'methods' => ['GET']
    ]
];