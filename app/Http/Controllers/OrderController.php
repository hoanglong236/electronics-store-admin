<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\DataFilterConstants\OrderPaymentFilterConstants;
use App\DataFilterConstants\OrderSearchOptionConstants;
use App\DataFilterConstants\OrderStatusFilterConstants;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Requests\OrderSearchRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Services\OrderItemService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $orderService;
    private $orderItemService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->orderItemService = new OrderItemService();
    }

    public function index()
    {
        $data = $this->getCommonDataForOrdersPage();
        $data['customOrders'] = $this->orderService->listCustomOrderData();

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function search(OrderSearchRequest $orderSearchRequest)
    {
        $orderSearchProperties = $orderSearchRequest->validated();

        $data = $this->getCommonDataForOrdersPage();
        $data['customOrders'] = $this->orderService->searchCustomOrders($orderSearchProperties);
        $data['searchKeyword'] = $orderSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $orderSearchProperties['searchOption'];

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filter(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();

        $data = $this->getCommonDataForOrdersPage();
        $data['customOrders'] = $this->orderService->filterCustomOrders($orderFilterProperties);
        $data['searchKeyword'] = $orderFilterProperties['searchKeyword'];
        $data['currentSearchOption'] = $orderFilterProperties['searchOption'];
        $data['currentStatusFilter'] = $orderFilterProperties['statusFilter'];
        $data['currentPaymentFilter'] = $orderFilterProperties['paymentFilter'];

        return view('pages.order.orders-page', ['data' => $data]);
    }

    private function getCommonDataForOrdersPage()
    {
        return [
            'pageTitle' => 'Order',
            'nextSelectableStatusMap' => $this->orderService->getNextSelectableStatusMap(),
            'searchKeyword' => '',
            'searchOptions' => OrderSearchOptionConstants::toArray(),
            'currentSearchOption' => OrderSearchOptionConstants::ALL,
            'statusFilters' => OrderStatusFilterConstants::toArray(),
            'currentStatusFilter' => OrderStatusFilterConstants::ALL,
            'paymentFilters' => OrderPaymentFilterConstants::toArray(),
            'currentPaymentFilter' => OrderPaymentFilterConstants::ALL,
        ];
    }

    public function updateOrderStatus(OrderStatusRequest $orderStatusRequest, $orderId)
    {
        $orderStatusProperties = $orderStatusRequest->validated();
        $this->orderService->updateOrderStatus($orderStatusProperties, $orderId);

        Session::flash(Constants::ACTION_SUCCESS, Constants::UPDATE_SUCCESS);
        return redirect()->action([OrderController::class, 'index']);
    }

    public function showDetails($orderId)
    {
        $data = [
            'pageTitle' => 'Order details',
            'customOrder' => $this->orderService->getCustomOrderById($orderId),
            'customOrderItems' => $this->orderItemService->getCustomOrderItemsByOrderId($orderId),
        ];

        return view('pages.order.order-details-page', ['data' => $data]);
    }
}
