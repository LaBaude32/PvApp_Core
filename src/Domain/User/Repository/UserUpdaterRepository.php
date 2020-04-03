<?php

namespace App\Domain\User\Repository;

use PDO;
use App\Domain\User\Data\UserGetData;

/**
 * Repository.
 */
class UserUpdaterRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Update user row.
     *
     * @param UserGetData $user The user
     */
    public function updateUser(UserGetData $user)
    {
        $row = [
            'id_user' => $user->id_user,
            'email' => $user->email,
            'pwd' => $user->pwd,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'phone' => $user->phone,
            'user_group' => $user->userGroup,
            'function' => $user->function,
            'organism' => $user->organism
        ];

        $query = "UPDATE user SET
        email=:email,
        password=:pwd,
        first_name=:first_name,
        last_name=:last_name,
        phone=:phone,
        user_group=:user_group,
        function=:function,
        organism=:organism
        WHERE id_user=:id_user";

        $statement = $this->connection->prepare($query);
        $statement->bindValue('id_user', $user->id_user, PDO::PARAM_INT);
        $statement->execute($row);
    }
}
