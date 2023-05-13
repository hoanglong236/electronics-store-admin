<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\DataFilterConstants\OrderPaymentFilterConstants;
use App\DataFilterConstants\OrderSearchOptionConstants;
use App\DataFilterConstants\OrderStatusFilterConstants;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Requests\OrderSearchRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Services\OrderService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }

    public function index()
    {
        $paginator = $this->orderService->getListCustomOrdersPaginator();

        $data = $this->getCommonDataForOrdersPage();
        $data['customOrders'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function search(OrderSearchRequest $orderSearchRequest)
    {
        $orderSearchProperties = $orderSearchRequest->validated();
        $paginator = $this->orderService->getSearchCustomOrdersPaginator($orderSearchProperties);

        $data = $this->getCommonDataForOrdersPage();
        $data['searchKeyword'] = $orderSearchProperties['searchKeyword'];
        $data['currentSearchOption'] = $orderSearchProperties['searchOption'];
        $data['customOrders'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'search?' . UtilsService::convertMapToParamsString($orderSearchProperties)
        );

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filter(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();
        $paginator = $this->orderService->getFilterCustomOrdersPaginator($orderFilterProperties);

        $data = $this->getCommonDataForOrdersPage();
        $data['searchKeyword'] = $orderFilterProperties['searchKeyword'];
        $data['currentSearchOption'] = $orderFilterProperties['searchOption'];
        $data['currentStatusFilter'] = $orderFilterProperties['statusFilter'];
        $data['currentPaymentFilter'] = $orderFilterProperties['paymentFilter'];
        $data['customOrders'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'filter?' . UtilsService::convertMapToParamsString($orderFilterProperties)
        );

        return view('pages.order.orders-page', ['data' => $data]);
    }

    private function getCommonDataForOrdersPage()
    {
        $nextSelectableStatusMap = $this->orderService->getNextSelectableStatusMap();

        return [
            'pageTitle' => 'Order',
            'nextSelectableStatusMap' => $nextSelectableStatusMap,
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
        $customOrder = $this->orderService->getCustomOrderById($orderId);
        $customOrderItems = $this->orderService->getCustomOrderItemsByOrderId($orderId);

        $data = [
            'pageTitle' => 'Order details',
            'customOrder' => $customOrder,
            'customOrderItems' => $customOrderItems,
        ];

        return view('pages.order.order-details-page', ['data' => $data]);
    }
}
