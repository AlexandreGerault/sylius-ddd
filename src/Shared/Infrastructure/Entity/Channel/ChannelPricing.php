<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Entity\Channel;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ChannelPricing as BaseChannelPricing;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_channel_pricing')]
class ChannelPricing extends BaseChannelPricing
{
}
