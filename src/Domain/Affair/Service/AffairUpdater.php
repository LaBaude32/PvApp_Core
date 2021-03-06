<?php

namespace App\Domain\Affair\Service;

use UnexpectedValueException;
use App\Domain\Affair\Data\AffairGetData;
use App\Domain\Affair\Repository\AffairUpdaterRepository;

/**
 * Service.
 */
final class AffairUpdater
{
    /**
     * @var AffairUpdaterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param AffairUpdaterRepository $repository The repository
     */
    public function __construct(AffairUpdaterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update an Affair.
     *
     * @param AffairGetData $Affair The Affair data
     */
    public function updateAffair(AffairGetData $affair): int
    {
        // Validation
        if (empty($affair->id_affair)) {
            throw new UnexpectedValueException('id required');
        }

        // Insert Affair
        $affairId = $this->repository->updateAffair($affair);

        // Logging here: Affair created successfully

        return $affairId;
    }
}
