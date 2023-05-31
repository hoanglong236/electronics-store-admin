<?php

namespace App\Http\Controllers;

use App\Common\Constants;
use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Http\Requests\OrderFilterRequest;
use App\Http\Requests\OrderStatusRequest;
use App\Services\OrderExportCsvService;
use App\Services\OrderService;
use App\Services\UtilsService;
use Illuminate\Http\Request;
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

    public function index()
    {
        $paginator = $this->orderService->getCustomOrdersPaginator();

        $data = $this->getCommonDataForOrdersPage();
        $data['orders'] = $paginator->items();
        $data['paginator'] = $paginator;

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filter(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();
        $paginator = $this->orderService->getFilterCustomOrdersPaginator($orderFilterProperties);

        $data = $this->getCommonDataForOrdersPage();
        $data['orderIdKeyword'] = $orderFilterProperties['orderIdKeyword'];
        $data['phoneOrEmailKeyword'] = $orderFilterProperties['phoneOrEmailKeyword'];
        $data['deliveryAddressKeyword'] = $orderFilterProperties['deliveryAddressKeyword'];
        $data['statusFilter'] = $orderFilterProperties['statusFilter'];
        $data['paymentMethodFilter'] = $orderFilterProperties['paymentMethodFilter'];
        $data['sortField'] = $orderFilterProperties['sortField'];
        $data['orders'] = $paginator->items();
        $data['paginator'] = $paginator->withPath(
            'filter?' . UtilsService::convertMapToParamsString($orderFilterProperties)
        );

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filterAndExportCsv(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProperties = $orderFilterRequest->validated();
        $this->orderExportCsvService->filterAndExportCsv($orderFilterProperties);
    }

    private function getCommonDataForOrdersPage()
    {
        $nextSelectableStatusMap = $this->orderService->getNextSelectableStatusMap();
        return [
            'pageTitle' => 'Order',
            'nextSelectableStatusMap' => $nextSelectableStatusMap,
            'orderIdKeyword' => '',
            'phoneOrEmailKeyword' => '',
            'deliveryAddressKeyword' => '',
            'statusFilter' => OrderFilterRequestConstants::ALL,
            'paymentMethodFilter' => OrderFilterRequestConstants::ALL,
            'sortField' => OrderFilterRequestConstants::SORT_BY_CREATED_AT,
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
        $data = [];

        $data['pageTitle'] = 'Order details';
        $data['orderDetails'] = $this->orderService->getOrderDetails($orderId);

        return view('pages.order.order-details-page', ['data' => $data]);
    }
}
