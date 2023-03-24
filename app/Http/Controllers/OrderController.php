<?php

namespace App\Http\Controllers;

use App\Common\Constants;
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
        $customOrders = $this->orderService->listCustomOrderData();
        $nextSelectableStatusMap = $this->orderService->getNextSelectableStatusMap();

        return view('pages.order.orders', [
            'pageTitle' => 'Order',
            'customOrders' => $customOrders,
            'nextSelectableStatusMap' => $nextSelectableStatusMap,
        ]);
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

        return view('pages.order.order-details', [
            'pageTitle' => 'Order Detail',
            'customOrder' => $customOrder,
            'customOrderItems' => $customOrderItems,
        ]);
    }
}