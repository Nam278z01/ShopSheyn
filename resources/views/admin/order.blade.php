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
                            ng-class="{
                                'bg-green': row.order_state_current == '1',
                                'bg-light-blue': row.order_state_current == '2',
                                'bg-red': row.order_state_current == '3',
                                'bg-yellow': row.order_state_current == '4',
                            }"
                            >@{{
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
                                ng-click="showModalEditAndCreate('SỬA THÔNG TIN SẢN PHẨM', row)"
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
                    <div class="modal-body"></div>
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
                                >Hủy</md-button
                            >
                            <md-button
                                class="md-raised md-primary"
                                type="submit"
                                ng-click="addOrEditProduct()"
                                >Lưu</md-button
                            >
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </section>
</section>

@endsection
