<?php

use Slim\App;
use App\Middleware\JwtMiddleware;
use Slim\Routing\RouteCollectorProxy;
use App\Action\PreflightAction;

return function (App $app) {
    // This route must not be protected
    $app->get('/', \App\Action\HomeAction::class);
    $app->post('/api/v1/tokens', \App\Action\TokenCreateAction::class);
    $app->post('/api/v1/addNewUser', \App\Action\UserCreateAction::class);

    //PreflightAction for OPTIONS Routes
    $app->group('/api/v1/', function (RouteCollectorProxy $group) {
        $group->options('tokens', PreflightAction::class);
        $group->options('addNewUser', PreflightAction::class);
        $group->options('login', PreflightAction::class);
        $group->options('getAllUsers', PreflightAction::class);
        $group->options('addAffair', PreflightAction::class);
        $group->options('addPv', PreflightAction::class);
        $group->options('addUser', PreflightAction::class);
        $group->options('updateUser', PreflightAction::class);
        $group->options('updateParticipant', PreflightAction::class);
        $group->options('deleteUser', PreflightAction::class);
        $group->options('getConnectedParticipants', PreflightAction::class);
        $group->options('getAllAffairs', PreflightAction::class);
        $group->options('getAffairById', PreflightAction::class);
        $group->options('getAffairsByUserId', PreflightAction::class);
        $group->options('updateAffair', PreflightAction::class);
        $group->options('deleteAffair', PreflightAction::class);
        $group->options('addLot', PreflightAction::class);
        $group->options('updateLot', PreflightAction::class);
        $group->options('deleteLot', PreflightAction::class);
        $group->options('getPvByAffairId', PreflightAction::class);
        $group->options('updatePv', PreflightAction::class);
        $group->options('getPvDetails', PreflightAction::class);
        $group->options('deletePv', PreflightAction::class);
        $group->options('getLastPvsByUserId', PreflightAction::class);
        $group->options('getPvReleasedDetails', PreflightAction::class);
        $group->options('validatePv', PreflightAction::class);
        $group->options('addPvHasUser', PreflightAction::class);
        $group->options('deleteParticipant', PreflightAction::class);
        $group->options('addItem', PreflightAction::class);
        $group->options('updateItem', PreflightAction::class);
        $group->options('updateVisibleOfItem', PreflightAction::class);
        $group->options('deleteItem', PreflightAction::class);
        $group->options('deleteItemHasPv', PreflightAction::class);
    });

    //Protected routes
    $app->group('/api/v1', function (RouteCollectorProxy $group) {
        $group->post('/login', \App\Action\LoginAction::class);

        // $group->options('/login', App\Action\PreflightAction::class);

        $group->get('/', \App\Action\HomeAction::class);
        //User
        $group->post('/addUser', \App\Action\UserCreateAction::class);
        $group->get('/getAllUsers', \App\Action\UsersGetAllAction::class);
        $group->post('/updateUser', \App\Action\UserUpdateAction::class);
        $group->post('/updateParticipant', \App\Action\ParticipantUpdateAction::class);
        $group->delete('/deleteUser', \App\Action\UserDeleteAction::class);
        $group->get('/getConnectedParticipants', \App\Action\ParticipantGetConnectedAction::class);

        //Affair
        $group->post('/addAffair', \App\Action\AffairCreateAction::class);
        $group->get('/getAllAffairs', \App\Action\AffairsGetAllAction::class);
        $group->get('/getAffairById', \App\Action\AffairGetByIdAction::class);
        //TODO: get Affair By User Id
        $group->get('/getAffairsByUserId', \App\Action\AffairsGetByUserIdAction::class);
        $group->post('/updateAffair', \App\Action\AffairUpdateAction::class);
        $group->delete('/deleteAffair', \App\Action\AffairDeleteAction::class);
        //Lot
        $group->post('/addLot', \App\Action\LotCreateAction::class);
        $group->post('/updateLot', \App\Action\LotUpdateAction::class);
        $group->delete('/deleteLot', \App\Action\LotDeleteAction::class);
        //Pv
        $group->post('/addPv', \App\Action\PvCreateAction::class);
        $group->get('/getPvByAffairId', \App\Action\PvGetByAffairIdAction::class);
        $group->post('/updatePv', \App\Action\PvUpdateAction::class);
        $group->get('/getPvDetails', \App\Action\PvGetByIdAction::class);
        $group->delete('/deletePv', \App\Action\PvDeleteAction::class);
        $group->get('/getLastPvsByUserId', \App\Action\PvsGetLastsByUserIdAction::class);
        $group->get('/getPvReleasedDetails', \App\Action\PvGetReleasedDetails::class);
        $group->post('/validatePv', \App\Action\PvValidateAction::class);
        //Pv Has User
        $group->post('/addPvHasUser', \App\Action\PvHasUserCreateAction::class);
        $group->delete('/deleteParticipant', \App\Action\ParticipantDeleteAction::class);
        //Item
        $group->post('/addItem', \App\Action\ItemCreateAction::class);
        $group->post('/updateItem', \App\Action\ItemUpdateAction::class);
        $group->post('/updateVisibleOfItem', \App\Action\ItemUpdateVisibleAction::class);
        $group->delete('/deleteItem', \App\Action\ItemDeleteAction::class);
        $group->delete('/deleteItemHasPv', \App\Action\ItemHasPvDeleteAction::class);
        //Tocken
        $group->post('/addToken', \App\Action\TokenCreateAction2::class);
        $group->delete('/deleteToken', \App\Action\TokenDeleteAction::class);
        $group->get('/getTokensByUserId', \App\Action\TokensGetByUserIdAction::class);
    })->add(JwtMiddleware::class);
};
    //Pv Has Item
    //TODO: créer une requete pour pouvoir mettre un item dans plusieurs Pv
