<?php

namespace App\Domain\User\Data;

final class UserGetData
{
    /** @var int */
    public $id_user;

    /** @var string */
    public $email;

    /** @var string */
    public $pwd;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var string */
    public $phone;

    /** @var string */
    public $userGroup;

    /** @var string */
    public $userFunction;

    /** @var string */
    public $organism;
}
