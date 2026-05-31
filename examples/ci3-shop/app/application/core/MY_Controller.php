<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use CoffeeR\Digtrace\Collector;
use CoffeeR\Digtrace\Config;
use CoffeeR\Digtrace\Flow;
use CoffeeR\Digtrace\Http\HttpInput;
use CoffeeR\Digtrace\Http\HttpResponse;
use CoffeeR\Digtrace\Sink\JsonlSink;
use CoffeeR\Digtrace\Sql\OracleSqlAnalyzer;

class MY_Controller extends CI_Controller
{
    /** @var Collector */
    public $digtraceCollector;

    /** @var mixed */
    protected $jsonBody = null;

    public function __construct()
    {
        parent::__construct();
        $this->startDigtrace();
    }

    protected function startDigtrace()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = strtoupper($_SERVER['REQUEST_METHOD']);

        $http = new HttpInput($method, $path);
        $http->pathPattern = $this->pathPattern($method, $path);
        $http->queryRaw = $this->input->get();
        $http->requestHeadersRaw = function_exists('getallheaders') ? getallheaders() : array();

        $raw = $this->input->raw_input_stream;
        if ($raw !== '') {
            $decoded = json_decode($raw, true);
            $this->jsonBody = is_array($decoded) ? $decoded : array('_raw' => $raw);
            $http->requestRaw = $this->jsonBody;
        } else {
            $this->jsonBody = array();
            $http->requestRaw = array();
        }

        $config = new Config(getenv('DIGTRACE_SECRET') ?: null, array(
            'keepKeys' => array(
                'scenario', 'product_code', 'payment_method',
                'shipping_method', 'prefecture', 'delivery_date',
                'delivery_time', 'status'
            ),
            'keepHeaderKeys' => array(),
            'sqlValueAllowlist' => array(
                'shop_orders.status', 'shop_orders.payment_status', 'shop_orders.payment_method',
                'shop_orders.shipping_method', 'shop_cart_items.product_code',
                'shop_reservation_cart_items.product_code'
            ),
            'captureText' => false,
            'maxTimelineSize' => 700,
        ));

        $this->digtraceCollector = new Collector(
            $config,
            new JsonlSink(getenv('DIGTRACE_LOG') ?: APPPATH . '../var/digtrace.jsonl'),
            new OracleSqlAnalyzer()
        );

        $flowId = $this->header('X-Digtrace-Flow');
        $flowSeq = $this->header('X-Digtrace-Seq');
        $flow = $flowId ? new Flow($flowId, $flowSeq !== null ? (int) $flowSeq : null) : null;
        $this->digtraceCollector->start($http, $flow);
    }

    protected function sendJson($status, array $payload)
    {
        $response = new HttpResponse();
        $response->status = $status;
        $response->responseKind = 'json';
        $response->contentType = 'application/json';
        $response->responseBodyRaw = $payload;

        $this->digtraceCollector->finish($response);

        return $this->output
            ->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    protected function customEvent($label, $data = null)
    {
        $this->digtraceCollector->addCustom($label, $data);
    }

    protected function body($key, $default = null)
    {
        return is_array($this->jsonBody) && array_key_exists($key, $this->jsonBody)
            ? $this->jsonBody[$key]
            : $default;
    }

    private function header($name)
    {
        $serverKey = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return isset($_SERVER[$serverKey]) ? $_SERVER[$serverKey] : null;
    }

    private function pathPattern($method, $path)
    {
        $patterns = array(
            'GET /api/health' => '/api/health',
            'POST /api/cart/items' => '/api/cart/items',
            'GET /api/cart' => '/api/cart',
            'POST /api/checkout/quote' => '/api/checkout/quote',
            'POST /api/orders' => '/api/orders',
            'POST /api/payments/credit/callback' => '/api/payments/credit/callback',
        );

        $key = $method . ' ' . $path;
        if (isset($patterns[$key])) {
            return $patterns[$key];
        }

        if ($method === 'POST' && preg_match('#^/api/orders/[0-9]+/cancel$#', $path)) {
            return '/api/orders/{id}/cancel';
        }

        return null;
    }
}
