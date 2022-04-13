<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Factory;

use OtherSolution\Klix\Model\PaymentMethod;
use OtherSolution\Klix\Model\PaymentMethodCollection;
use function array_merge;
use function in_array;

class PaymentMethodCollectionArrayFactory
{
    public static function create(array $array, string $country): PaymentMethodCollection
    {
        $collection = new PaymentMethodCollection();

        $available = array_merge($array['by_country']['any'], $array['by_country'][$country]);
        $methods = array_merge($array['available_payment_methods'], $array['card_methods']);

        foreach ($methods as $paymentMethod) {
            if (in_array($paymentMethod, $available, true)) {
                $method = (new PaymentMethod())
                    ->setKey($paymentMethod ?? null)
                    ->setName($array['names'][$paymentMethod] ?? null)
                    ->setLogo($array['logos'][$paymentMethod] ?? null);

                $collection->addPaymentMethod($method);
            }
        }

        return $collection;
    }
}
