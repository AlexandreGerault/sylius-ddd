<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Payment\Model\PaymentMethodTranslation as BasePaymentMethodTranslation;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_payment_method_translation')]
class PaymentMethodTranslation extends BasePaymentMethodTranslation
{
}
