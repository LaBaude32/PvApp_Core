<?php

namespace App\Domain\Pv\Repository;

use PDO;
use App\Domain\Pv\Data\PvCreateData;

/**
 * Repository.
 */
class PvUpdaterRepository
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
     * Insert lot row.
     *
     * @param PvCreateData $lot The affaire
     *
     * @return int The new ID
     */
    public function UpdatePv(PvCreateData $pv): int
    {
        $row = [
            'id_pv' => $pv->id_pv,
            'etat' => $pv->etat,
            'date_reunion' => $pv->date_reunion,
            'lieu_reunion' => $pv->lieu_reunion,
            'date_prochaine_reunion' => $pv->date_prochaine_reunion,
            'lieu_prochaine_reunion' => $pv->lieu_prochaine_reunion,
            'affaire_id' => $pv->affaire_id,
        ];

        $query = "UPDATE pv SET
                etat=:etat,
                date_reunion=:date_reunion,
                lieu_reunion=:lieu_reunion,
                date_pro_reunion=:date_prochaine_reunion,
                lieu_pro_reunion=:lieu_prochaine_reunion,
                affaire_id=:affaire_id
                WHERE id_pv=:id_pv";

        $statement = $this->connection->prepare($query);
        $statement->bindValue('id_pv', $pv->id_pv, PDO::PARAM_INT);
        $statement->execute($row);

        // return (int) $this->connection->lastInsertId(); //TODO: faire une requette et comparer avec le pv envoyé si probleme renvoyer.
        return (int) $pv->id_pv;
    }
}