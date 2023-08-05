<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Services\Exports\OrderExportCsvService;
use App\Services\OrderService;
use App\Utils\CommonUtil;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    private $orderService;
    private $orderExportCsvService;

    public function __construct(OrderService $orderService, OrderExportCsvService $orderExportCsvService)
    {
        $this->orderService = $orderService;
        $this->orderExportCsvService = $orderExportCsvService;
    }

    private function getCommonDataForOrdersPage()
    {
        $nextSelectableStatusMap = $this->orderService->getNextSelectableStatusMap();
        return [
            'pageTitle' => 'Order',
            'nextSelectableStatusMap' => $nextSelectableStatusMap,
            'orderIdKeyword' => '',
            'emailKeyword' => '',
            'statusFilter' => OrderFilterRequestConstants::ALL,
            'paymentMethodFilter' => OrderFilterRequestConstants::ALL,
        ];
    }

    public function index()
    {
        $today = date('Y-m-d');
        $paginator = $this->orderService->getCustomOrdersPaginator($today, $today);

        $data = $this->getCommonDataForOrdersPage();
        $data['orders'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['fromDate'] = $today;
        $data['toDate'] = $today;

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filter(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();
        $paginator = $this->orderService->getFilterCustomOrdersPaginator($orderFilterProperties);

        $data = $this->getCommonDataForOrdersPage();
        $data['orderIdKeyword'] = $orderFilterProperties['orderIdKeyword'];
        $data['emailKeyword'] = $orderFilterProperties['emailKeyword'];
        $data['statusFilter'] = $orderFilterProperties['statusFilter'];
        $data['paymentMethodFilter'] = $orderFilterProperties['paymentMethodFilter'];
        $data['fromDate'] = $orderFilterProperties['fromDate'];
        $data['toDate'] = $orderFilterProperties['toDate'];
        $data['orders'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'filter?' . CommonUtil::convertMapToParamsString($orderFilterProperties)
        );

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filterAndExportCsv(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();
        $this->orderExportCsvService->export($orderFilterProperties);
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
        $data = [];

        $data['pageTitle'] = 'Order details';
        $data['orderDetails'] = $this->orderService->getOrderDetails($orderId);

        return view('pages.order.order-details-page', ['data' => $data]);
    }
}
