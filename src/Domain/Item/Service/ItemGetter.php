<?php

namespace App\Domain\Item\Service;

use App\Domain\Item\Data\ItemGetData;
use UnexpectedValueException;
use App\Domain\Item\Repository\ItemGetterRepository;
use App\Domain\Pv\Data\PvGetData;

/**
 * Service.
 */
final class ItemGetter
{
    /**
     * @var ItemGetterRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param ItemGetterRepository $repository The repository
     */
    public function __construct(ItemGetterRepository $repository)
    {
        $this->repository = $repository;
    }

    // /**
    //  * Get all the pvs.
    //  *
    //  * @return array All the pvs
    //  */
    // public function getPvByPvId(int $id): array
    // {
    //     // Validation
    //     if (empty($id)) {
    //         throw new UnexpectedValueException('id required');
    //     }

    //     if ($id == 0) {
    //         throw new UnexpectedValueException('id doit Ãªtre positif');
    //     }

    //     // Get All pvs
    //     $pvs = $this->repository->getPvByAffaireId($id);

    //     return (array) $pvs;
    // }

    /**
     * Get all the items.
     *
     * @return array All the items
     */
    public function getAllItems(): array
    {
        // Get All items
        $items = $this->repository->getAllItems();

        return (array) $items;
    }

    /**
     * Get all the items.
     *
     * @return array All the items
     */
    public function getItemsByPvId($id): array
    {
        // Get All items
        $items = $this->repository->getItemsByPvId($id);

        return (array) $items;
    }

    /**
     * Get all the items.
     *
     * @return array All the items
     */
    public function getVisibleItemsByPvId($id): array
    {
        // Get All items
        $items = $this->repository->getVisibleItemsByPvId($id);

        return (array) $items;
    }

    public function getItemById($id_item): ItemGetData
    {
        // Get All items
        $item = $this->repository->getItemById($id_item);

        return $item;
    }

    public function getLotsForItems(array $items): array
    {
        $itemsToReturn = $this->repository->getLotsForItems($items);

        return $itemsToReturn;
    }

    public function getLotsForItem(ItemGetData $item): ItemGetData
    {
        $itemToReturn = $this->repository->getLotsForItem($item);

        return $itemToReturn;
    }

    public function getPvHasItem(PvGetData $pv): array
    {
        if (!$pv->id_pv) {
            throw new UnexpectedValueException('id doit être positif');
        }

        $pvHasItem = (array) $this->repository->getAllItemsFromPvHasItem($pv->id_pv);

        return $pvHasItem;
    }
}
