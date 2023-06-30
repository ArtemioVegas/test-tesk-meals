<?php

namespace Meals\Domain\User\Permission;

use MyCLabs\Enum\Enum;

class Permission extends Enum
{
    const VIEW_ACTIVE_POLLS = 'viewActivePolls'; // возможность видеть активные опросы
    const PARTICIPATION_IN_POLLS = 'participationInPolls'; // возможность участвовать в опросах
}
