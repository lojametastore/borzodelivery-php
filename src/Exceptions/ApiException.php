<?php

namespace BorzoDelivery\Exceptions;

use BorzoDelivery\Client\Response;
use Exception;

class ApiException extends Exception
{
    /**
     * The server response.
     *
     * @var Response
     */
    protected $response;

    public function __construct(Response $response, $message = null, int $code = null)
    {
        $this->response = $response;
        $message = ((string)$this->response->getBody()) ?: $this->response->getContent()->Message ?? $message;

        parent::__construct($message, $code);
    }

    /**
     * Get the HTTP response header
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getErrors(): array
    {
        return $this->getResponse()->getContent()->errors;
    }

    public function getWarnings(): array
    {
        return $this->getResponse()->getContent()->warnings;
    }

    public function getparametersWarnings(): \Stdclass
    {
        return $this->getResponse()->getContent()->parameter_warnings;
    }

    /**
     * Return message error
     * @see https://borzodelivery.com/br/business-api/doc#errors
     *
     * @param string $code
     * @return string
     */
    public function getErrorMessage(string $code): string
    {
        switch ($code) {
            case 'unexpected_error':
            {
                return 'Unexpected error. Please let us know at api.br@borzodelivery.com.';
            }
            case 'invalid_api_version':
            {
                return 'Unknown API version. Available versions are 1.0 and 1.1.';
            }
            case 'required_api_upgrade':
            {
                return 'Requested API version was discontinued. You should use the latest version instead.';
            }
            case 'requests_limit_exceeded':
            {
                return 'You have reached an API usage limit. Limits are: 100 requests per minute, 5 000 requests per 24 hours.';
            }
            case 'required_auth_token':
            {
                return 'X-DV-Auth-Token header is missing from the request.';
            }
            case 'invalid_auth_token':
            {
                return 'X-DV-Auth-Token you are sending is invalid.';
            }
            case 'required_method_get':
            {
                return 'HTTP method GET is required.';
            }
            case 'required_method_post':
            {
                return 'HTTP method POST is required.';
            }
            case 'invalid_post_json':
            {
                return 'POST request body must be in JSON format.';
            }
            case 'invalid_parameters':
            {
                return 'Request parameters contain errors. Look at parameter_errors response field for details.';
            }
            case 'unapproved_contract':
            {
                return 'Your agreement is not approved yet (for legal entities).';
            }
            case 'service_unavailable':
            {
                return 'Our service is temporarily unavailable. Please try again later.';
            }
            case 'invalid_api_method':
            {
                return 'Unknown API method was requested.';
            }
            case 'buyout_not_allowed':
            {
                return 'You do not have access to buyout feature.';
            }
            case 'insufficient_balance_for_buyout':
            {
                return 'You do not have enough money for buyout.';
            }
            case 'order_cannot_be_edited':
            {
                return 'Order cannot be edited.';
            }
            case 'order_cannot_be_canceled':
            {
                return 'Order cannot be canceled.';
            }
            case 'insufficient_balance':
            {
                return 'Your balance is too low (for legal entities).';
            }
            case 'buyout_amount_limit_exceeded':
            {
                return 'Total buyout amount in your active orders is too large. You do not have sufficient balance / credit limit to place the new order.';
            }
            case 'route_not_found':
            {
                return 'Route not found.';
            }
            case 'total_payment_amount_limit_exceeded':
            {
                return 'Exceeded maximum order price.';
            }
            case 'order_is_duplicate':
            {
                return 'Duplicate order rejected';
            }
            case 'insufficient_funds':
            {
                return 'Insufficient funds on your bank card';
            }
            case 'card_payment_failed':
            {
                return 'Bank card payment failed';
            }
        }

        return $code;
    }

    /**
     * Return parameter error message
     * @see https://borzodelivery.com/br/business-api/doc#parameter-errors
     *
     * @param string $code
     * @return string
     */
    public function getparameterErrorMessage(string $code): string
    {
        switch ($code) {
            case 'required':
            {
                return "Required parameter was not provided.";
            }

            case 'unknown':
            {
                return "Unknown parameter was encountered.";
            }

            case 'invalid_value':
            {
                return "Invalid promo code.";
            }

            case 'invalid_list':
            {
                return "Invalid JSON list.";
            }

            case 'invalid_object':
            {
                return "Invalid JSON object.";
            }

            case 'invalid_boolean':
            {
                return "Invalid boolean.";
            }

            case 'invalid_date':
            {
                return "Invalid date or time.";
            }

            case 'invalid_date_format':
            {
                return "Invalid date and time format.";
            }

            case 'invalid_float':
            {
                return "Invalid floating point number.";
            }

            case 'invalid_integer':
            {
                return "Invalid integer number.";
            }

            case 'invalid_string':
            {
                return "Invalid string.";
            }

            case 'invalid_order':
            {
                return "Order ID was not found.";
            }

            case 'invalid_point':
            {
                return "Point ID was not found.";
            }

            case 'invalid_order_status':
            {
                return "Invalid order status.";
            }

            case 'invalid_vehicle_type':
            {
                return "Invalid vehicle type.";
            }

            case 'invalid_courier':
            {
                return "Invalid courier ID.";
            }

            case 'invalid_phone':
            {
                return "Invalid phone number.";
            }

            case 'invalid_region':
            {
                return "Address is out of the delivery area for the region.";
            }

            case 'invalid_order_package':
            {
                return "Package was not found.";
            }

            case 'invalid_delivery_id':
            {
                return "Delivery ID was not found.";
            }

            case 'invalid_delivery_package':
            {
                return "Package ID for delivery was not found.";
            }

            case 'invalid_delivery_status':
            {
                return "Invalid delivery status.";
            }

            case 'invalid_bank_card':
            {
                return "Bank card ID was not found.";
            }

            case 'invalid_url':
            {
                return "Invalid url.";
            }

            case 'invalid_postal_code':
            case 'invalid_enum_value':
            {
                return "Invalid enum value.";
            }

            case 'invalid_delivery_method':
            {
                return "Invalid delivery method.";
            }

            case 'invalid_delivery_interval':
            {
                return "Invalid postal code.";
            }

            case 'sameday_pickup_interval_too_short':
            {
                return "Same day pickup interval is too short.";
            }

            case 'different_regions':
            {
                return "Addresses from different regions are not allowed.";
            }

            case 'address_not_found':
            {
                return "Address geocoding failed. Check your address with Google Maps service.";
            }

            case 'min_length':
            {
                return "String value is too short.";
            }

            case 'max_length':
            {
                return "String value is too long.";
            }

            case 'min_date':
            {
                return "Date and time is older than possible.";
            }

            case 'max_date':
            {
                return "Date and time is later than possible.";
            }

            case 'min_size':
            {
                return "List size is too small.";
            }

            case 'max_size':
            {
                return "List size is too large.";
            }

            case 'min_value':
            {
                return "Value is too small.";
            }

            case 'max_value':
            {
                return "Value is too large.";
            }

            case 'cannot_be_past':
            {
                return "Date and time cannot be in the past.";
            }

            case 'start_after_end':
            {
                return "Incorrect time interval. Start time should be earlier than the end.";
            }

            case 'earlier_than_previous_point':
            {
                return "Incorrect time interval. Time cannot be earlier than previous point time.";
            }

            case 'coordinates_out_of_bounds':
            {
                return "Point coordinates are outside acceptable delivery areas.";
            }

            case 'not_nullable':
            {
                return "Value can not be null.";
            }

            case 'not_allowed':
            {
                return "Parameter not allowed.";
            }

            case 'order_payment_only_one_point':
            {
                return "Order payment can be specified only for one point.";
            }

            case 'cod_agreement_required':
            {
                return "COD agreement required.";
            }

            case 'promo_code_already_used':
            {
                return "Promo code has already been used.";
            }

            case 'promo_code_not_available':
            {
                return "Promo code not available for selected address.";
            }
        }

        return $code;
    }
}