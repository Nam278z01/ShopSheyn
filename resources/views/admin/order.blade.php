@extends('admin.index') @section('content')
<section ng-controller="OrderManagementController">
    <section class="content-header">
        <ol class="breadcrumb" style="position: relative; float: unset">
            <li>
                <a href="#"><i class="fa fa-edit"></i>Quản lý</a>
            </li>
            <li class="active">Quản lý đơn hàng</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="table-responsive">
            <table
                ng-table="tableParams"
                show-filter="true"
                class="table table-bordered table-striped stickytb"
            >
                <tr ng-repeat="row in $data">
                    <td title="'#'" align="center">
                        @{{
                            $index +
                                1 +
                                (tableParams.page() - 1) * tableParams.count()
                        }}
                    </td>
                    <td
                        title="'Mã đơn hàng'"
                        filter="{'order_id': 'text'}"
                        sortable="'order_id'"
                        align="center"
                    >
                        @{{ row.order_id }}
                    </td>
                    <td
                        title="'Tên khách hàng'"
                        filter="{'customer_name': 'text'}"
                        sortable="'customer_name'"
                    >
                        @{{ row.customer_name }}
                    </td>
                    <td
                        title="'Địa chỉ khách hàng'"
                        filter="{'customer_address': 'text'}"
                        sortable="'customer_address'"
                    >
                        @{{ row.customer_address }}
                    </td>
                    <td
                        title="'Số điện thoại'"
                        filter="{'customer_phone': 'text'}"
                        sortable="'customer_phone'"
                        align="right"
                    >
                        @{{ row.customer_phone }}
                    </td>
                    <td
                        title="'Thời gian đặt'"
                        filter="{'order_date': 'text'}"
                        sortable="'order_date'"
                    >
                        @{{
                            row.order_date
                                | jsDate
                                | date: "yyyy-MM-dd HH:mm:ss"
                        }}
                    </td>
                    <td
                        title="'Tổng số tiền'"
                        filter="{'total': 'text'}"
                        sortable="'total'"
                        align="right"
                    >
                        @{{ row.total | number: 0 }}
                    </td>
                    <td
                        title="'Trạng thái đơn hàng'"
                        filter="{order_state_current: 'select'}" filter-data="order_states"
                        sortable="'order_state_current'"
                        align="center"
                    >
                        <span
                            class="badge"
                            style="border-radius: 2px"
                            ng-class="{
                                'bg-green': row.order_state_current == '1',
                                'bg-light-blue': row.order_state_current == '2',
                                'bg-red': row.order_state_current == '3',
                                'bg-yellow': row.order_state_current == '4',
                            }"
                            >Đơn hàng @{{
                                row.order_state_current | cvOrderState
                            }}</span
                        >
                    </td>
                    <td title="'Thao tác'" align="right">
                        <section
                            layout="row"
                            layout-sm="column"
                            layout-align="end center"
                            layout-wrap
                        >
                            <md-button
                                ng-click="showModalDetails(row)"
                                class="md-icon-button md-raised"
                                data-toggle="modal"
                                data-target="#modaladd-edit"
                            >
                                <md-icon md-font-icon="ion-eye"></md-icon>
                            </md-button>
                        </section>
                    </td>
                </tr>
            </table>
        </div>
        <div
            class="modal fade"
            id="modaladd-edit"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
        >
            <form class="modal-dialog modal-lg" role="form" name="productForm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #3f51b5">
                        <h4
                            class="modal-title"
                            id="myModalLabel"
                            style="text-align: center; color: white"
                        >
                            CHI TIẾT ĐƠN HÀNG
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div
                            class="flex-shrink-0 flex-grow"
                        >
                            <div class="mt-[12px]">
                                <div class="pt-[24px] px-[24px] pb-[12px] bg-white">
                                    <div class="text-[15px] pb-[12px] flex justify-between">
                                        <span class="text-black font-bold text-[12px] italic"
                                            >ID ĐƠN HÀNG: @{{ order.order_id }}</span
                                        >
                                        <span
                                            class="font-bold text-[12px] text-white px-[7px] py-[3px] rounded-[2px]"
                                            ng-class="{
                                                'bg-[#777]': order.order_state_current == '0',
                                                'bg-[#00a65a]': order.order_state_current == '1',
                                                'bg-[#3c8dbc]': order.order_state_current == '2',
                                                'bg-[#dd4b39]': order.order_state_current == '3',
                                                'bg-[#f39c12]': order.order_state_current == '4',
                                            }"
                                            >Đơn hàng @{{ order.order_state_current | cvOrderState }}</span
                                        >
                                    </div>
                                    <section
                                    layout="row"
                                    layout-sm="column"
                                    layout-align="center center"
                                    layout-wrap
                                    >
                                        <md-input-container flex="50">
                                            <label>Trạng thái đơn hàng</label>
                                            <md-select
                                                ng-model="order.order_state_change"
                                            >
                                                <md-option
                                                    ng-repeat="os in order_states.slice(1)"
                                                    ng-value="os"
                                                    ng-disabled="(order.order_state_current == 0 && os.id > 1) ||
                                                                 (order.order_state_current == 1 && (os.id < 1 || os.id > 3)) ||
                                                                 (order.order_state_current == 2 && (os.id < 2 || os.id == 3 )) ||
                                                                 (order.order_state_current == 3 && (os.id < 3 || os.id > 3 )) ||
                                                                 (order.order_state_current == 4 && (os.id < 4 || os.id > 4 ))"
                                                >
                                                    @{{ os.title }}
                                                </md-option>
                                            </md-select>
                                        </md-input-container>
                                        <md-button
                                            class="md-raised md-primary"
                                            type="submit"
                                            ng-click="updateOrderState()"
                                            >Cập nhập</md-button
                                        >
                                    </section>
                                    <div class="relative py-[30px] border-t border-[#eaeaea] rounded-br rounded-bl flex justify-between">
                                        <div ng-if="order.orderstates.length > 1" class="absolute top-[58px] h-1 w-full">
                                            <div class="absolute h-full w-[calc(100%-140px)] mx-[70px] bg-white"></div>
                                            <div class="absolute h-full w-[calc(100%-140px)] mx-[70px] bg-[#2dc258]"></div>
                                        </div>
                                        <div ng-repeat="os in order.orderstates" ng-class="{'m-auto': order.orderstates.length == 1}" class="relative w-[140px] text-center">
                                            <div class="bg-white m-auto w-[60px] h-[60px] flex justify-center items-center rounded-full border-[4px] border-[#2dc258] text-[#2dc258]">
                                                <i ng-class="{
                                                    'bx-food-menu' : os.orderstate_name == 0,
                                                    'bx-car' : os.orderstate_name == 1,
                                                    'bx-download' : os.orderstate_name == 2,
                                                    'bx-error-alt' : os.orderstate_name == 3,
                                                    'bx-undo' : os.orderstate_name == 4,
                                                }"
                                                    class="bx text-[24px] font-bold"></i>
                                            </div>
                                            <div class="text-[rgba(0,0,0,.8)] text-[13px] mt-[20px] mb-1">Đơn hàng @{{os.orderstate_name | cvOrderState}}</div>
                                            <div class="text-[rgba(0,0,0,.26)] text-[12px]">@{{os.orderstate_date | jsDate | date: "HH:mm dd-MM-yyyy"}}</div>
                                        </div>
                                    </div>
                                    <div class="py-[20px] border-t border-[#eaeaea] rounded-br rounded-bl">
                                        <div class="pb-[12px] text-[14px] font-medium" style="font-weight: 600;">
                                            Địa Chỉ Nhận Hàng
                                        </div>
                                        <div class="flex">
                                            <div class="pt-[10px] pr-[24px] flex-1">
                                                <div class="text-[13px] font-medium mb-[8px] text-[rgba(0,0,0,.8)]">@{{ order.customer_name }}</div>
                                                <div class="text-[12px] leading-[22px] text-[rgba(0,0,0,.54)]">
                                                    <span>@{{ order.customer_phone }}</span></br>
                                                    @{{ order.customer_address }}
                                                </div>
                                            </div>
                                            <div class="w-[500px] pt-[4px] pl-[24px] border-l border-[rgba(0,0,0,.09)]">
                                                <div ng-repeat="os in order.orderstates.slice().reverse()" class="relative">
                                                    <div ng-if="$index != order.orderstates.length - 1" class="absolute w-[1px] h-full top-[12px] left-[5px] bg-[#d8d8d8]"></div>
                                                    <div class="relative flex items-center h-[32px] text-[rgba(0,0,0,.8)] text-[13px]">
                                                        <div
                                                            ng-class="{'bg-[#26aa99]': $index == 0, 'bg-[#d8d8d8]':$index != 0}"
                                                            class="w-[11px] h-[11px] mr-[8px] rounded-full">
                                                        </div>
                                                        <div class="mr-3">
                                                            @{{ os.orderstate_date | jsDate | date: "HH:mm dd-MM-yyyy"}}
                                                        </div>
                                                        <div ng-class="{'text-[#26aa99]': $index == 0,'text-[rgba(0,0,0,.54)]': $index != 0}">
                                                            Đơn hàng @{{ os.orderstate_name | cvOrderState}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="border-t border-[#eaeaea] rounded-br rounded-bl"
                                    >
                                        <a
                                            target="_blank"
                                            ng-repeat="od in order.orderdetails"
                                            href="/details?product_id=@{{ od.size.color.product.product_id }}"
                                            class="flex pt-[12px] justify-between"
                                        >
                                            <div class="flex">
                                                <div
                                                    class="w-[90px] border border-[#e1e1e1] relative group"
                                                >
                                                    <img
                                                        class="w-full h-full"
                                                        ng-src="/image/product/@{{ od.size.color.product_image1 }}"
                                                        alt="@{{ od.size.color.product.product_name }}"
                                                    />
                                                    <img
                                                        ng-src="/image/product/@{{
                                                    od.size.color
                                                    .product_image2 ||
                                                    od.size.color
                                                        .product_image3 ||
                                                        od.size.color
                                                        .product_image4 ||
                                                        od.size.color
                                                        .product_image5
                                            }}"
                                                        alt="@{{ od.size.color.product.product_name }}"
                                                        class="absolute top-0 left-0 w-full opacity-0 group-hover:opacity-100 transition-all duration-500"
                                                    />
                                                </div>
                                                <div class="pl-[12px]">
                                                    <div
                                                        class="text-[13px] mb-[5px] hover:underline"
                                                    >
                                                        @{{ od.size.color.product.product_name }}
                                                    </div>
                                                    <div
                                                        class="text-[#0000008a] text-[13px] mb-[5px]"
                                                    >
                                                        Phân loại hàng: Màu @{{
                                                        od.size.color.color_name }}, Size @{{
                                                        od.size.size_name }}
                                                    </div>
                                                    <div class="text-[14px] mb-[5px]">
                                                        x@{{ od.product_quantity }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center" style="justify-content: end">
                                                <!-- Normal -->
                                                <span
                                                    ng-if="od.product_discount == 0"
                                                    class="font-semibold text-[20px] text-black"
                                                >
                                                    @{{od.price * od.product_quantity |
                                                    number:0}}₫
                                                </span>

                                                <!-- Discount -->
                                                <span
                                                    ng-if="od.product_discount != 0"
                                                    class="text-[#fa6338] text-[18px] block font-semibold mr-2"
                                                >
                                                    @{{(od.price - od.price * od.product_discount
                                                    / 100) * od.product_quantity | number:0}}₫
                                                </span>
                                                <del
                                                    ng-if="od.product_discount != 0"
                                                    class="text-[#999] text-[14px]"
                                                >
                                                    @{{od.price * od.product_quantity |
                                                    number:0}}₫
                                                </del>
                                                <div
                                                    ng-if="od.product_discount != 0"
                                                    class="w-[50px] text-center text-[12px] leading-[20px] bg-[#222] text-white ml-3"
                                                >
                                                    -@{{ od.product_discount }}%
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div
                                        class="mt-[12px] border-t border-[#eaeaea]"
                                    >
                                        <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                            <div class="flex-1 py-[13px] px-[10px] text-[12px] text-[rgba(0,0,0,.54)]">
                                                Tổng tiền hàng
                                            </div>
                                            <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-[14px] border-l border-dotted border-[rgba(0,0,0,.09)]">
                                                @{{ order.total | number:0}}₫
                                            </div>
                                        </div>
                                        <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                            <div class="flex-1 py-[13px] px-[10px] text-[12px] text-[rgba(0,0,0,.54)]">
                                                Phí vận chuyển
                                            </div>
                                            <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-[14px] border-l border-dotted border-[rgba(0,0,0,.09)]">
                                                Miễn phí
                                            </div>
                                        </div>
                                        <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                            <div class="flex-1 py-[13px] px-[10px] text-[12px] text-[rgba(0,0,0,.54)]">
                                                Tổng số tiền
                                            </div>
                                            <div class="w-[240px] text-[#fa6338] py-[13px] text-[24px] font-bold border-l border-dotted border-[rgba(0,0,0,.09)]">
                                                @{{ order.total | number:0}}₫
                                            </div>
                                        </div>
                                        <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                            <div class="flex-1 py-[13px] px-[10px] text-[12px] text-[rgba(0,0,0,.54)]">
                                                Phương thức Thanh toán
                                            </div>
                                            <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-[14px] border-l border-dotted border-[rgba(0,0,0,.09)]">
                                                Thanh toán khi nhận hàng
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <section
                            layout="row"
                            layout-sm="column"
                            layout-align="end center"
                            layout-wrap
                        >
                            <md-button
                                class="md-primary md-cancel-button md-button md-default-theme md-ink-ripple"
                                type="button"
                                data-dismiss="modal"
                                ng-click="showProduct()"
                                >Trở lại</md-button
                            >
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>

@endsection
