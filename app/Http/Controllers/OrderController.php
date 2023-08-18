<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstants;
use App\Constants\MessageConstants;
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

    private function getBaseDataForOrdersPage($paginator)
    {
        $data = [];
        $data['orders'] = $paginator->items();
        $data['paginator'] = $paginator;
        $data['nextSelectableStatusMap'] = $this->orderService->getNextSelectableStatusMap();
        $data['pageTitle'] = 'Orders';

        return $data;
    }

    public function index()
    {
        $today = date('Y-m-d');
        $paginator = $this->orderService->getCustomOrdersPaginator($today, $today);

        $data = $this->getBaseDataForOrdersPage($paginator);
        $data['orderIdKeyword'] = '';
        $data['emailKeyword'] = '';
        $data['statusFilter'] = OrderFilterRequestConstants::ALL;
        $data['paymentMethodFilter'] = OrderFilterRequestConstants::ALL;
        $data['fromDate'] = $today;
        $data['toDate'] = $today;

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filter(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProps = $orderFilterRequest->validated();
        $paginator = $this->orderService->getFilterCustomOrdersPaginator($orderFilterProps);
        $paginator = $paginator->withPath('filter?' . CommonUtil::convertMapToParamsString($orderFilterProps));

        $data = $this->getBaseDataForOrdersPage($paginator);
        $data['orderIdKeyword'] = $orderFilterProps['orderIdKeyword'];
        $data['emailKeyword'] = $orderFilterProps['emailKeyword'];
        $data['statusFilter'] = $orderFilterProps['statusFilter'];
        $data['paymentMethodFilter'] = $orderFilterProps['paymentMethodFilter'];
        $data['fromDate'] = $orderFilterProps['fromDate'];
        $data['toDate'] = $orderFilterProps['toDate'];

        return view('pages.order.orders-page', ['data' => $data]);
    }

    public function filterAndExportCsv(OrderFilterRequest $orderFilterRequest)
    {
        $orderFilterProps = $orderFilterRequest->validated();
        $this->orderExportCsvService->export($orderFilterProps);
    }

    public function updateOrderStatus(OrderStatusRequest $orderStatusRequest, int $orderId)
    {
        $orderStatusProps = $orderStatusRequest->validated();
        $this->orderService->updateOrderStatus($orderStatusProps, $orderId);

        Session::flash(CommonConstants::ACTION_SUCCESS, MessageConstants::UPDATE_SUCCESS);
        return redirect()->action([OrderController::class, 'index']);
    }

    public function showDetails(int $orderId)
    {
        $data = [];
        $data['orderDetails'] = $this->orderService->getOrderDetails($orderId);
        $data['pageTitle'] = 'Order details';

        return view('pages.order.order-details-page', ['data' => $data]);
    }
}
