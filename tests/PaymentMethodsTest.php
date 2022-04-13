<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Tests;

use OtherSolution\Klix\KlixApi;
use OtherSolution\Klix\Model\PaymentMethodCollection;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use function getenv;

class PaymentMethodsTest extends AbstractTest
{
    public function testGetPaymentMethods(): void
    {
        $api = new KlixApi(getenv('BRAND_ID'), getenv('SECRET_KEY'));

        $this->assertInstanceOf(PaymentMethodCollection::class, $methods = $api->getPaymentMethods());
        $this->assertInstanceOf(PaymentMethodCollection::class, $api->getPaymentMethods());
        $this->assertJson($this->serializer->serialize($methods, 'json'));
        $this->assertJson($this->serializer->serialize($methods->jsonSerialize(), 'json'));
        $this->assertNotSame($methods->getPaymentMethods()->count(), $methods->removePaymentMethod($methods->getPaymentMethods()->first())->getPaymentMethods()->count());
        $this->assertSame($methods->getPaymentMethods()->count(), $methods->setPaymentMethods($methods->getPaymentMethods())->getPaymentMethods()->count());
    }

    public function testGetPaymentMethodsWrong(): void
    {
        $api = new KlixApi(getenv('BRAND_ID'), getenv('SECRET_KEY'), '');
        $this->expectException(ServiceUnavailableHttpException::class);
        $api->getPaymentMethods();
    }
}
