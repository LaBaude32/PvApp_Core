<?php

namespace App\Domain\Pv\Data;

final class PvGetData
{
    /** @var int */
    public $id_pv;

    /** @var string */
    public $state;

    /** @var string */
    public $meeting_date;

    /** @var string */
    public $meeting_place;

    /** @var string */
    public $meeting_next_date;

    /** @var string */
    public $meeting_next_place;

    /** @var int */
    public $affair_id;

    /** @var string */
    public $release_date;

    /** @var int */
    public $pv_number;

    /** @var string */
    public $affair_name;

    /** @var string */
    public $affair_meeting_type;

    /** @var array */
    public $lots;
}
