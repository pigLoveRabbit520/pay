<?php

namespace Yansongda\Pay\Gateways\Wechat;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Log;

class WapGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws \Yansongda\Pay\Exceptions\GatewayException
     * @throws \Yansongda\Pay\Exceptions\InvalidArgumentException
     * @throws \Yansongda\Pay\Exceptions\InvalidSignException
     *
     * @return string
     */
    public function pay($endpoint, array $payload): string
    {
        $payload['trade_type'] = $this->getTradeType();

        Log::info('Starting To Pay A Wechat Wap Order', [$endpoint, $payload]);

        $data = $this->preOrder($payload);

        $url = is_null(Support::getInstance()->return_url) ? $data->mweb_url : $data->mweb_url.
                        '&redirect_url='.urlencode(Support::getInstance()->return_url);

        return $url;
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'MWEB';
    }
}
