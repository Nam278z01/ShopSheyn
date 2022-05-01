@extends('admin.index') @section('content')
<section ng-controller="ProductManagementController">
    <section class="content-header">
        <ol class="breadcrumb" style="position: relative; float: unset">
            <li>
                <a href="#"><i class="fa fa-edit"></i>Quản lý</a>
            </li>
            <li class="active">Quản lý sản phẩm</li>
        </ol>

        <section
            layout="row"
            layout-sm="column"
            layout-align="end center"
            layout-wrap
        >
            <md-button
                class="md-raised md-primary"
                data-toggle="modal"
                data-target="#modaladd-editsong"
                >Thêm sản phẩm</md-button
            >
        </section>
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
                    <td title="'Ảnh'">
                        <img
                            src="/image/product/@{{
                                row.colors[0].product_image1
                            }}"
                            alt="@{{ row.SongName }}"
                        />
                    </td>
                    <td
                        title="'Tên sản phẩm'"
                        filter="{'product_name': 'text'}"
                        sortable="'product_name'"
                    >
                        @{{ row.product_name }}
                    </td>
                    <td
                        title="'Giảm giá (%)'"
                        filter="{'product_discount': 'text'}"
                        sortable="'product_discount'"
                        align="right"
                    >
                        @{{ row.product_discount }}
                    </td>
                    <td
                        title="'Ngày tạo'"
                        filter="{'created_time': 'text'}"
                        sortable="'created_time'"
                    >
                        @{{ row.created_time }}
                    </td>
                    <td title="'Thao tác'" align="right">
                        <section
                            layout="row"
                            layout-sm="column"
                            layout-align="end center"
                            layout-wrap
                        >
                            <md-button class="md-icon-button md-raised">
                                <md-icon md-font-icon="ion-eye"></md-icon>
                            </md-button>
                            <md-button
                                class="md-icon-button md-raised md-warn"
                                md-colors="{background: 'amber-400'}"
                            >
                                <md-icon md-font-icon="ion-edit"></md-icon>
                            </md-button>
                            <md-button
                                class="md-icon-button md-raised"
                                md-colors="{background: 'red-400'}"
                                data-toggle="modal"
                                data-target="#modaldeletesong"
                            >
                                <md-icon md-font-icon="ion-trash-b"></md-icon>
                            </md-button>
                        </section>
                    </td>
                </tr>
            </table>
        </div>
        <div
            class="modal fade"
            id="modaladd-editsong"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
        >
            <form class="modal-dialog modal-lg" role="form" name="productForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            id="myModalLabel"
                            style="text-align: center"
                        >
                            @{{ feature }}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div layout="row">
                            <md-input-container flex="50">
                                <label>Danh mục lớn</label>
                                <md-select ng-model="category_picked" ng-change="show()">
                                    <md-option
                                        ng-repeat="category in categories"
                                        ng-value="category"
                                    >
                                        @{{ category.category_name }}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                            <md-input-container flex="50">
                                <label>Danh mục nhỏ</label>
                                <md-select
                                    ng-model="category_piked.subcategory"
                                >
                                    <md-option
                                        ng-repeat="subcategory in category_picked.subcategories"
                                        ng-value="subcategory"
                                    >
                                        @{{ subcategory.subcategory_name }}
                                    </md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <md-input-container class="md-block">
                            <label>Tên sản phẩm</label>
                            <input
                                md-maxlength="500"
                                required
                                md-no-asterisk
                                name="product_name"
                                ng-model="product.product_name"
                            />
                            <div ng-messages="productForm.product_name.$error">
                                <div ng-message="required">
                                    This is required.
                                </div>
                                <div ng-message="md-maxlength">
                                    The product_name must be less than 500
                                    characters long.
                                </div>
                            </div>
                        </md-input-container>

                        <md-input-container class="md-block">
                            <label>Giảm giá (%)</label>
                            <input
                                required
                                type="number"
                                step="any"
                                name="product_discount"
                                ng-model="product.product_discount"
                                min="0"
                                max="100"
                            />

                            <div
                                ng-messages="productForm.product_discount.$error"
                                multiple
                                md-auto-hide="false"
                            >
                                <div ng-message="required">
                                    You've got to charge something! You can't
                                    just <b>give away</b> a Missile Defense
                                    System.
                                </div>

                                <div ng-message="min">
                                    You should charge at least $800 an hour.
                                    This job is a big deal... if you mess up,
                                    everyone dies!
                                </div>

                                <div ng-message="max">
                                    @{{
                                        projectForm.rate.$viewValue
                                            | currency: "$":0
                                    }}
                                    an hour? That's a little ridiculous. I doubt
                                    even Bill Clinton could afford that.
                                </div>
                            </div>
                        </md-input-container>
                    </div>
                    <div class="modal-footer">
                        <section
                            layout="row"
                            layout-sm="column"
                            layout-align="end center"
                            layout-wrap
                        >
                            <md-button
                                class="md-raised"
                                md-colors="{background: 'red-400'}"
                                type="button"
                                data-dismiss="modal"
                                >Hủy</md-button
                            >
                            <md-button
                                class="md-raised md-primary"
                                type="submit"
                                >Lưu</md-button
                            >
                        </section>
                    </div>
                </div>
            </form>
        </div>
        <div
            class="modal fade"
            id="modaldeletesong"
            role="dialog"
            aria-labelledby="mySmallModalLabel"
        >
            <form class="modal-dialog modal-sm" role="form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4
                            class="modal-title"
                            id="myModalLabel"
                            style="text-align: center"
                        >
                            Bạn có đồng ý muốn xóa bài hát?
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
                                class="md-raised"
                                md-colors="{background: 'red-400'}"
                                type="button"
                                data-dismiss="modal"
                                >Hủy</md-button
                            >
                            <md-button
                                class="md-raised md-primary"
                                type="submit"
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
