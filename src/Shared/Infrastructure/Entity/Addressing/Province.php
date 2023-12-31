<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Entity\Addressing;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Addressing\Model\Province as BaseProvince;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_province')]
class Province extends BaseProvince
{
}
