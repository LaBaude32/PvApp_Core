<?php

use Slim\App;

return function (App $app) {
    $app->get('/', \App\Action\HomeAction::class);
    $app->post('/addUser', \App\Action\UserCreateAction::class);
    $app->get('/getAllUsers', \App\Action\UsersGetAllAction::class);
    $app->post('/addAffair', \App\Action\AffairCreateAction::class);
    $app->get('/getAllAffairs', \App\Action\AffairsGetAllAction::class);
    $app->post('/addLot', \App\Action\LotCreateAction::class);
    $app->get('/getAffairById', \App\Action\AffairGetByIdAction::class);
    $app->post('/addPv', \App\Action\PvCreateAction::class);
    $app->get('/getPvByAffairId', \App\Action\PvGetByAffairIdAction::class);
    $app->post('/updatePv', \App\Action\PvUpdateAction::class);
    $app->post('/addItem', \App\Action\ItemCreateAction::class);
    $app->get('/getPvDetails', \App\Action\PvGetByIdAction::class);
};
