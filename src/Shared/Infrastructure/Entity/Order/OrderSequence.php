<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Entity\Order;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\OrderSequence as BaseOrderSequence;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_order_sequence')]
class OrderSequence extends BaseOrderSequence
{
}
