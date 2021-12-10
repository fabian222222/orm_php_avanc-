<?php
    require_once(__DIR__.'/../vendor/autoload.php');

    require_once(__DIR__.'/../Controller/CommentController.php');
    require_once(__DIR__.'/../Controller/TicketController.php');

    use App\Controller\TicketController;
    use App\Controller\CommentController;

    $router = new \Bramus\Router\Router();
    $router->setNamespace('\App\Controller');

    $router->get('/tickets', 'TicketController@findAll');
    $router->get('/ticket/file/{ticket_id}', 'TicketController@createFile');
    $router->get('/tickets/{ticket_id}', 'TicketController@findById');
    $router->get('/comments', 'CommentController@findAll');
    $router->get('/comments/{comment_id}', 'CommentController@findById');
    $router->post('/tickets', 'TicketController@create');
    $router->post('/comments/{ticket_id}', 'CommentController@create');
    
    $router->run();