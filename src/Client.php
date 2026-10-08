<?php

declare(strict_types=1);

namespace Ngandu\Maxicash;

use JsonException;
use Ngandu\Maxicash\Data\Language;

/**
 * Class Client.
 *
 * @author bernard-ng <bernard@ngandu.dev>
 */
final readonly class Client
{
    public function __construct(
        public Credential $credential,
        private Environment $environment = Environment::SANDBOX,
    ) {
    }

    /**
     * @throws JsonException
     */
    public function donationUrl(Language|string $language = Language::EN): string
    {
        $language = is_string($language) ? Language::from($language) : $language;
        $data = sprintf(
            '{MerchantID:%s,Language:%s}',
            json_encode($this->credential->merchantId, JSON_THROW_ON_ERROR),
            json_encode($language->value, JSON_THROW_ON_ERROR)
        );

        return $this->urlWithQuery('/donationentry', [
            'data' => $data,
        ]);
    }

    public function formPostPayment(): string
    {
        return sprintf('%s/PayEntryPost', $this->environment->getBaseUrl());
    }

    /**
     * @throws JsonException
     */
    public function queryStringURLPayment(PaymentEntry $data): string
    {
        return $this->urlWithQuery('/PayEntry', [
            'data' => $data->get(),
        ]);
    }

    public function payEntryWeb(): string
    {
        return sprintf('%s/Integration/PayEntryWeb', $this->environment->getWebApiBaseUrl());
    }

    public function payEntryWebLog(string $id): string
    {
        return $this->urlWithQuery('/payentryweb', [
            'logid' => $id,
        ]);
    }

    /**
     * @param array<string, string> $query
     */
    private function urlWithQuery(string $path, array $query): string
    {
        return sprintf(
            '%s%s?%s',
            $this->environment->getBaseUrl(),
            $path,
            http_build_query($query, encoding_type: PHP_QUERY_RFC3986)
        );
    }
}
