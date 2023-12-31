<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Entity\Addressing;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Addressing\Model\Zone as BaseZone;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_zone')]
class Zone extends BaseZone
{
}
