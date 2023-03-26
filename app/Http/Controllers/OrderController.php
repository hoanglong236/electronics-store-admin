<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\OrderStatusRequest;
use App\ModelConstants\OrderStatusConstants;
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
        $orderStatusNameMap = [
            OrderStatusConstants::RECEIVED => 'Received',
            OrderStatusConstants::PROCESSING => 'Processing',
            OrderStatusConstants::DELIVERING => 'Delivering',
            OrderStatusConstants::COMPLETED => 'Completed',
            OrderStatusConstants::CANCELLED => 'Cancelled',
        ];
        $data = [
            'pageTitle' => 'Order',
            'customOrders' => $this->orderService->listCustomOrderData(),
            'nextSelectableStatusMap' => $this->orderService->getNextSelectableStatusMap(),
            'orderStatusNameMap' => $orderStatusNameMap,
        ];

        return view('pages.order.orders-page', ['data' => $data]);
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
        $customOrderItems = $this->orderItemService->getCustomOrderItemsByOrderId($orderId);

        return view('pages.order.order-details-page', [
            'pageTitle' => 'Order details',
            'customOrder' => $customOrder,
            'customOrderItems' => $customOrderItems,
        ]);
    }
}
