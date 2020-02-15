<?php

namespace App\Domain\User\Repository;

use PDO;
use App\Domain\User\Data\UserGetData;
use App\Domain\User\Data\UserStatusGetData;

/**
 * Repository.
 */
class UserGetterRepository
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
     * Get All Users.
     *
     * @return array All the users
     */
    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM user";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $user = new UserGetData();
            $user->id_user = (int) $row['id_user'];
            $user->email = (string) $row['email'];
            $user->firstName = (string) $row['first_name'];
            $user->lastName = (string) $row['last_name'];
            $user->phone = (string) $row['phone'];
            $user->user_group = (string) $row['user_group'];
            $user->function = (string) $row['function'];
            $user->organism = (string) $row['organism'];

            $users[] = $user;
        }
        return (array) $users;
    }

    public function getUsersByPvId(int $pv_id): array
    {
        $query = "SELECT u.*, phu.status
        FROM user u
        INNER JOIN pv_has_user phu
        ON phu.user_id = u.id_user
        WHERE phu.pv_id =:pv_id";

        $statement = $this->connection->prepare($query);
        $statement->bindValue('pv_id', $pv_id, PDO::PARAM_INT);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $user = new UserStatusGetData();
            $user->id_user = (int) $row['id_user'];
            $user->email = (string) $row['email'];
            $user->firstName = (string) $row['first_name'];
            $user->lastName = (string) $row['last_name'];
            $user->phone = (string) $row['phone'];
            $user->user_group = (string) $row['user_group'];
            $user->function = (string) $row['function'];
            $user->organism = (string) $row['organism'];
            $user->status = (string) $row['status'];

            $users[] = $user;
        }
        return (array) $users;
    }
}