<?php

declare(strict_types=1);

use App\Shared\Infrastructure\Entity\Addressing\Address;
use App\Shared\Infrastructure\Entity\Addressing\Country;
use App\Shared\Infrastructure\Entity\Addressing\Province;
use App\Shared\Infrastructure\Entity\Addressing\Zone;
use App\Shared\Infrastructure\Entity\Addressing\ZoneMember;
use App\Shared\Infrastructure\Entity\Channel\Channel;
use App\Shared\Infrastructure\Entity\Channel\ChannelPricing;
use App\Shared\Infrastructure\Entity\Currency\Currency;
use App\Shared\Infrastructure\Entity\Currency\ExchangeRate;
use App\Shared\Infrastructure\Entity\Customer\Customer;
use App\Shared\Infrastructure\Entity\Customer\CustomerGroup;
use App\Shared\Infrastructure\Entity\Locale\Locale;
use App\Shared\Infrastructure\Entity\Order\Adjustment;
use App\Shared\Infrastructure\Entity\Order\Order;
use App\Shared\Infrastructure\Entity\Order\OrderItem;
use App\Shared\Infrastructure\Entity\Order\OrderItemUnit;
use App\Shared\Infrastructure\Entity\Order\OrderSequence;
use App\Shared\Infrastructure\Entity\Payment\GatewayConfig;
use App\Shared\Infrastructure\Entity\Payment\Payment;
use App\Shared\Infrastructure\Entity\Payment\PaymentMethod;
use App\Shared\Infrastructure\Entity\Payment\PaymentMethodTranslation;
use App\Shared\Infrastructure\Entity\Payment\PaymentSecurityToken;
use App\Shared\Infrastructure\Entity\Product\Product;
use App\Shared\Infrastructure\Entity\Product\ProductAssociation;
use App\Shared\Infrastructure\Entity\Product\ProductAssociationType;
use App\Shared\Infrastructure\Entity\Product\ProductAssociationTypeTranslation;
use App\Shared\Infrastructure\Entity\Product\ProductAttribute;
use App\Shared\Infrastructure\Entity\Product\ProductAttributeTranslation;
use App\Shared\Infrastructure\Entity\Product\ProductAttributeValue;
use App\Shared\Infrastructure\Entity\Product\ProductImage;
use App\Shared\Infrastructure\Entity\Product\ProductOption;
use App\Shared\Infrastructure\Entity\Product\ProductOptionTranslation;
use App\Shared\Infrastructure\Entity\Product\ProductOptionValue;
use App\Shared\Infrastructure\Entity\Product\ProductOptionValueTranslation;
use App\Shared\Infrastructure\Entity\Product\ProductReview;
use App\Shared\Infrastructure\Entity\Product\ProductTaxon;
use App\Shared\Infrastructure\Entity\Product\ProductTranslation;
use App\Shared\Infrastructure\Entity\Product\ProductVariant;
use App\Shared\Infrastructure\Entity\Product\ProductVariantTranslation;
use App\Shared\Infrastructure\Entity\Promotion\CatalogPromotion;
use App\Shared\Infrastructure\Entity\Promotion\CatalogPromotionAction;
use App\Shared\Infrastructure\Entity\Promotion\CatalogPromotionScope;
use App\Shared\Infrastructure\Entity\Promotion\Promotion;
use App\Shared\Infrastructure\Entity\Promotion\PromotionAction;
use App\Shared\Infrastructure\Entity\Promotion\PromotionCoupon;
use App\Shared\Infrastructure\Entity\Promotion\PromotionRule;
use App\Shared\Infrastructure\Entity\Shipping\Shipment;
use App\Shared\Infrastructure\Entity\Shipping\ShippingCategory;
use App\Shared\Infrastructure\Entity\Shipping\ShippingMethod;
use App\Shared\Infrastructure\Entity\Shipping\ShippingMethodTranslation;
use App\Shared\Infrastructure\Entity\Taxation\TaxCategory;
use App\Shared\Infrastructure\Entity\Taxation\TaxRate;
use App\Shared\Infrastructure\Entity\Taxonomy\Taxon;
use App\Shared\Infrastructure\Entity\Taxonomy\TaxonImage;
use App\Shared\Infrastructure\Entity\Taxonomy\TaxonTranslation;
use App\Shared\Infrastructure\Entity\User\AdminUser;
use App\Shared\Infrastructure\Entity\User\ShopUser;
use App\Shared\Infrastructure\Entity\User\UserOAuth;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import('@SyliusCoreBundle/Resources/config/app/config.yml');

    $containerConfigurator->import('@SyliusAdminBundle/Resources/config/app/config.yml');

    $containerConfigurator->import('@SyliusApiBundle/Resources/config/app/config.yaml');

    $containerConfigurator->import('@SyliusShopBundle/Resources/config/app/config.yml');

    $containerConfigurator->import('@SyliusPayPalPlugin/Resources/config/config.yaml');

    $parameters = $containerConfigurator->parameters();

    $parameters->set('sylius_core.public_dir', '%kernel.project_dir%/public');
    if ($containerConfigurator->env() === 'dev') {
        $containerConfigurator->extension('sylius_api', [
            'enabled' => true,
        ]);
    }

    $containerConfigurator->extension('sylius_addressing', [
        'resources' => [
            'address' => [
                'classes' => [
                    'model' => Address::class,
                ],
            ],
            'country' => [
                'classes' => [
                    'model' => Country::class,
                ],
            ],
            'province' => [
                'classes' => [
                    'model' => Province::class,
                ],
            ],
            'zone' => [
                'classes' => [
                    'model' => Zone::class,
                ],
            ],
            'zone_member' => [
                'classes' => [
                    'model' => ZoneMember::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_attribute', [
        'resources' => [
            'product' => [
                'attribute' => [
                    'classes' => [
                        'model' => ProductAttribute::class,
                    ],
                    'translation' => [
                        'classes' => [
                            'model' => ProductAttributeTranslation::class,
                        ],
                    ],
                ],
                'attribute_value' => [
                    'classes' => [
                        'model' => ProductAttributeValue::class,
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_channel', [
        'resources' => [
            'channel' => [
                'classes' => [
                    'model' => Channel::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_core', [
        'resources' => [
            'product_image' => [
                'classes' => [
                    'model' => ProductImage::class,
                ],
            ],
            'taxon_image' => [
                'classes' => [
                    'model' => TaxonImage::class,
                ],
            ],
            'product_taxon' => [
                'classes' => [
                    'model' => ProductTaxon::class,
                ],
            ],
            'channel_pricing' => [
                'classes' => [
                    'model' => ChannelPricing::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_currency', [
        'resources' => [
            'currency' => [
                'classes' => [
                    'model' => Currency::class,
                ],
            ],
            'exchange_rate' => [
                'classes' => [
                    'model' => ExchangeRate::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_customer', [
        'resources' => [
            'customer' => [
                'classes' => [
                    'model' => Customer::class,
                ],
            ],
            'customer_group' => [
                'classes' => [
                    'model' => CustomerGroup::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_locale', [
        'resources' => [
            'locale' => [
                'classes' => [
                    'model' => Locale::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_order', [
        'resources' => [
            'order' => [
                'classes' => [
                    'model' => Order::class,
                ],
            ],
            'order_item' => [
                'classes' => [
                    'model' => OrderItem::class,
                ],
            ],
            'order_item_unit' => [
                'classes' => [
                    'model' => OrderItemUnit::class,
                ],
            ],
            'adjustment' => [
                'classes' => [
                    'model' => Adjustment::class,
                ],
            ],
            'order_sequence' => [
                'classes' => [
                    'model' => OrderSequence::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_payment', [
        'resources' => [
            'payment_method' => [
                'classes' => [
                    'model' => PaymentMethod::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => PaymentMethodTranslation::class,
                    ],
                ],
            ],
            'payment' => [
                'classes' => [
                    'model' => Payment::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_payum', [
        'resources' => [
            'payment_security_token' => [
                'classes' => [
                    'model' => PaymentSecurityToken::class,
                ],
            ],
            'gateway_config' => [
                'classes' => [
                    'model' => GatewayConfig::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_product', [
        'resources' => [
            'product' => [
                'classes' => [
                    'model' => Product::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ProductTranslation::class,
                    ],
                ],
            ],
            'product_variant' => [
                'classes' => [
                    'model' => ProductVariant::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ProductVariantTranslation::class,
                    ],
                ],
            ],
            'product_option' => [
                'classes' => [
                    'model' => ProductOption::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ProductOptionTranslation::class,
                    ],
                ],
            ],
            'product_option_value' => [
                'classes' => [
                    'model' => ProductOptionValue::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ProductOptionValueTranslation::class,
                    ],
                ],
            ],
            'product_association' => [
                'classes' => [
                    'model' => ProductAssociation::class,
                ],
            ],
            'product_association_type' => [
                'classes' => [
                    'model' => ProductAssociationType::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ProductAssociationTypeTranslation::class,
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_promotion', [
        'resources' => [
            'catalog_promotion' => [
                'classes' => [
                    'model' => CatalogPromotion::class,
                ],
            ],
            'catalog_promotion_action' => [
                'classes' => [
                    'model' => CatalogPromotionAction::class,
                ],
            ],
            'catalog_promotion_scope' => [
                'classes' => [
                    'model' => CatalogPromotionScope::class,
                ],
            ],
            'promotion' => [
                'classes' => [
                    'model' => Promotion::class,
                ],
            ],
            'promotion_rule' => [
                'classes' => [
                    'model' => PromotionRule::class,
                ],
            ],
            'promotion_action' => [
                'classes' => [
                    'model' => PromotionAction::class,
                ],
            ],
            'promotion_coupon' => [
                'classes' => [
                    'model' => PromotionCoupon::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_review', [
        'resources' => [
            'product' => [
                'review' => [
                    'classes' => [
                        'model' => ProductReview::class,
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_shipping', [
        'resources' => [
            'shipment' => [
                'classes' => [
                    'model' => Shipment::class,
                ],
            ],
            'shipping_method' => [
                'classes' => [
                    'model' => ShippingMethod::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => ShippingMethodTranslation::class,
                    ],
                ],
            ],
            'shipping_category' => [
                'classes' => [
                    'model' => ShippingCategory::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_taxation', [
        'resources' => [
            'tax_category' => [
                'classes' => [
                    'model' => TaxCategory::class,
                ],
            ],
            'tax_rate' => [
                'classes' => [
                    'model' => TaxRate::class,
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_taxonomy', [
        'resources' => [
            'taxon' => [
                'classes' => [
                    'model' => Taxon::class,
                ],
                'translation' => [
                    'classes' => [
                        'model' => TaxonTranslation::class,
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_user', [
        'resources' => [
            'admin' => [
                'user' => [
                    'classes' => [
                        'model' => AdminUser::class,
                    ],
                ],
            ],
            'shop' => [
                'user' => [
                    'classes' => [
                        'model' => ShopUser::class,
                    ],
                ],
            ],
            'oauth' => [
                'user' => [
                    'classes' => [
                        'model' => UserOAuth::class,
                    ],
                ],
            ],
        ],
    ]);

    $containerConfigurator->extension('sylius_shop', [
        'product_grid' => [
            'include_all_descendants' => true,
        ],
    ]);

    $containerConfigurator->extension('sylius_theme', [
        'sources' => [
            'filesystem' => [
                'scan_depth' => 1,
                'directories' => [
                    '%kernel.project_dir%/themes',
                ],
            ],
        ],
    ]);
};
