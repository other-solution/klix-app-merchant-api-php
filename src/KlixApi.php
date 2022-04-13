<?php declare(strict_types = 1);

namespace OtherSolution\Klix;

use Exception;
use OtherSolution\Klix\Factory\PaymentMethodCollectionArrayFactory;
use OtherSolution\Klix\Model\PaymentMethodCollection;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;
use function array_merge;
use function json_decode;
use const JSON_THROW_ON_ERROR;

class KlixApi
{
    public const DEFAULT_BASE = 'https://portal.klix.app/api/v1/';

    protected HttpClientInterface $client;

    protected ?PaymentMethodCollection $paymentMethods = null;

    public function __construct(protected string $brandId, protected string $apiKey, string $base = self::DEFAULT_BASE, array $config = [])
    {
        $config['base_uri'] = $base;
        $this->client = HttpClient::create(defaultOptions: $config);
    }

    public function getBrandId(): string
    {
        return $this->brandId;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getPaymentMethods(string $currency = 'EUR', string $country = 'LV', string $language = 'en'): ?PaymentMethodCollection
    {
        if (null === $this->paymentMethods) {
            $response = $this->request(Request::METHOD_GET, 'payment_methods/', [
                'query' => [
                    'brand_id' => $this->getBrandId(),
                    'currency' => $currency,
                    'language' => $language,
                ],
            ]);

            $this->paymentMethods = PaymentMethodCollectionArrayFactory::create($response, $country);
        }

        return $this->paymentMethods;
    }

    protected function request(string $method, string $endpoint, array $options = []): array
    {
        $headers = [];
        if ($this->getApiKey()) {
            $headers['Authorization'] = 'Bearer ' . $this->getApiKey();
        }

        try {
            $response = $this->client->request($method, $endpoint, array_merge([
                'headers' => $headers,
            ], $options));

            return json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);
        } catch (Exception|Throwable $exception) {
            throw new ServiceUnavailableHttpException(null, $exception->getMessage(), $exception);
        }
    }
}
