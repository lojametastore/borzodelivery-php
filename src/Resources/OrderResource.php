<?php

namespace BorzoDelivery\Resources;

use BorzoDelivery\Classes\EndpointBase;
use BorzoDelivery\Requests\OrderRequest;
use BorzoDelivery\Responses\OrderResponse;

class OrderResource extends EndpointBase
{
    /**
     * Use this method to calculate order prices and validate parameters before actually placing the order.
     * It is possible to calculate an incomplete order, but such calculations may be imprecise.
     * @see https://borzodelivery.com/br/business-api/doc#calculate-order
     *
     * @param OrderRequest $order
     * @return OrderResponse
     */
    public function priceCalculation(OrderRequest $order): OrderResponse
    {
        $body = $order->toJson();
        $response = $this->request('POST', 'calculate-order', [
            'body' => $body
        ])->getContent();

        return new OrderResponse($response->order);
    }
}