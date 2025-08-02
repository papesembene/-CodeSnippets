<?php

use App\Controllers\CodeSnippetController;

// API pour récupérer les snippets (utilisé pour le filtrage JavaScript)
$router->get('/api/snippets', [CodeSnippetController::class, 'api']);
