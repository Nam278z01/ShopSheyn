@extends('admin.index') @section('content')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<style>
    .product-color {
        display: flex;
    }

    .product-color-element {
        width: 80px;
        margin-right: 16px;
    }

    .product-color-element > div {
        position: relative;
        height: 0;
        padding-bottom: 132%;
    }

    .product-color-img {
        width: 80px;
        height: 100%;
        object-fit: contain;
        position: absolute;
        top: 0;
        left: 0;
        border: 1px solid rgba(0, 0, 0, 0.2);
    }

    .product-color-remove {
        cursor: pointer;
        display: none;
        justify-content: center;
        align-items: center;
        position: absolute;
        bottom: 0;
        width: 80px;
        height: 24px;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .product-color-element > div:hover .product-color-remove {
        display: flex;
    }

    .product-color-file {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
        left: 0;
        right: 0;
        border: 1px dashed rgb(23, 145, 242);
        border-radius: 2px;
    }

    .btn-customer {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px dashed rgb(23, 145, 242);
        border-radius: 2px;
        background-color: white;
        padding: 6px 10px;
        width: 100%;
    }

    .btn-customer:hover {
        background: rgb(245, 251, 255);
    }

    .btn-customer:active {
        background: rgb(250, 250, 250);
    }
</style>
<style>
    .product-classify {
        display: flex;
        box-sizing: border-box;
        border: 1px solid #ebebeb;
        border-top-width: 0;
        border-left-width: 0;
    }

    .product-classify-header {
        display: flex;
    }

    .product-classify-body {
        display: flex;
        flex-wrap: wrap;
    }

    .product-classify-wrap {
        display: flex;
        width: 100%;
    }

    .product-classify-cell {
        color: #999;
        border: 1px solid #ebebeb;
        border-right-width: 0;
        border-bottom-width: 0;
        height: 40px;
        width: 50%;
    }

    .product-classify-content {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fafafa;
        padding: 8px;
        width: 100%;
        height: 100%;
    }

    .product-classify-body-cell {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 40px;
        width: 50%;
        border: 1px solid #ebebeb;
        border-right-width: 0;
        border-bottom-width: 0;
    }

    .product-classify-body-cell-group {
        display: flex;
        width: 50%;
        flex-wrap: wrap;
    }

    .product-classify-body-cell-group > div {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40px;
        width: 100%;
        border: 1px solid #ebebeb;
        border-right-width: 0;
        border-bottom-width: 0;
    }

    .product-classify-body-cell-input {
        color: #333;
        text-align: center;
        font-size: 14px;
        height: 100%;
        width: 100%;
        border: none;
        outline: none;
    }

    .product-classify-body-cell-input:focus {
        border: 1px solid #333;
    }
</style>
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
                >Thêm sản phẩm
            </md-button>
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
                    <td title="'Danh mục nhỏ'"
                        filter="{'subcategory.subcategory_name': 'text'}"
                        sortable="'subcategory.subcategory_name'"
                    >
                        @{{
                            row.subcategory.subcategory_name
                        }}
                    </td>
                    <td title="'Ảnh'">
                        <img
                            ng-src="/image/product/@{{
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
                        @{{ row.created_time | jsDate | date: "dd-MM-yyyy HH:mm:ss" }}
                    </td>
                    <td title="'Thao tác'" align="right">
                        <section
                            layout="row"
                            layout-sm="column"
                            layout-align="end center"
                            layout-wrap
                        >
                            <md-button
                                class="md-icon-button md-raised md-warn"
                                md-colors="{background: 'amber-400'}"
                            >
                                <md-icon md-font-icon="ion-edit"></md-icon>
                            </md-button>
                            <md-button
                                ng-click="showModalDelete(row)"
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
                        <p
                            style="
                                color: rgb(51, 51, 51);
                                font-size: 20px;
                                font-weight: bold;
                            "
                        >
                            Thông tin cơ bản
                        </p>

                        <div layout="row">
                            <md-input-container flex="50">
                                <label>Danh mục lớn</label>
                                <md-select
                                    ng-model="category_picked"
                                    ng-change="show()"
                                >
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
                                        productForm.rate.$viewValue
                                            | currency: "$":0
                                    }}
                                    an hour? That's a little ridiculous. I doubt
                                    even Bill Clinton could afford that.
                                </div>
                            </div>
                        </md-input-container>

                        <p
                            style="
                                font-weight: bold;
                                color: rgba(0, 0, 0, 0.54);
                            "
                        >
                            Mô tả
                        </p>
                        <div
                            ckeditor="options"
                            ng-model="product.product_description"
                            ready="onReady()"
                        ></div>

                        <p
                            style="
                                color: rgb(51, 51, 51);
                                font-size: 20px;
                                font-weight: bold;
                                margin: 30px 0;
                            "
                        >
                            Thông tin bán hàng
                        </p>

                        <div style="margin-bottom: 30px">
                            <div class="row" style="margin-bottom: 20px">
                                <div class="col-md-3" style="text-align: end">
                                    Phân loại nhóm màu sắc
                                </div>
                                <div
                                    class="col-md-8"
                                    style="background-color: rgb(250, 250, 250)"
                                >
                                    <div class="row">
                                        <div
                                            ng-repeat="cl in product.colors"
                                            class="col-md-12"
                                        >
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <md-input-container
                                                        class="md-block"
                                                    >
                                                        <label
                                                            >Tên màu sắc</label
                                                        >
                                                        <input
                                                            md-maxlength="100"
                                                            required
                                                            md-no-asterisk
                                                            name="product_color"
                                                            ng-model="cl.color_name"
                                                        />
                                                        <div
                                                            ng-messages="productForm.product_color.$error"
                                                        >
                                                            <div
                                                                ng-message="required"
                                                            >
                                                                This is
                                                                required.
                                                            </div>
                                                            <div
                                                                ng-message="md-maxlength"
                                                            >
                                                                The product_name
                                                                must be less
                                                                than 500
                                                                characters long.
                                                            </div>
                                                        </div>
                                                    </md-input-container>
                                                </div>
                                                <div class="col-md-1">
                                                    <md-button
                                                        ng-if="
                                                            product.colors
                                                                .length > 1
                                                        "
                                                        ng-click="removeColor($index)"
                                                        class="md-icon-button"
                                                    >
                                                        <md-icon
                                                            md-font-icon="ion-ios-trash-outline"
                                                            ng-style="{
                                                                'font-size':
                                                                    '24px'
                                                            }"
                                                        ></md-icon>
                                                    </md-button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <button
                                                ng-click="addColor()"
                                                class="btn-customer"
                                                type="button"
                                            >
                                                <i
                                                    class="ion-ios-plus-outline"
                                                    style="
                                                        color: rgb(
                                                            23,
                                                            145,
                                                            242
                                                        );
                                                        font-size: 18px;
                                                        padding-right: 10px;
                                                    "
                                                ></i>
                                                <span
                                                    >Thêm phân loại màu
                                                    sắc</span
                                                >
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                ng-repeat="cl in product.colors"
                                class="row"
                                style="margin-bottom: 10px"
                            >
                                <div class="col-md-3" style="text-align: end">
                                    Ảnh sản phẩm màu @{{ cl.color_name }}
                                </div>
                                <div class="col-md-8">
                                    <div class="product-color">
                                        <div class="product-color-element">
                                            <div>
                                                <img
                                                    class="product-color-img"
                                                    ng-if="cl.files[0]"
                                                    ngf-src="cl.files[0]"
                                                />
                                                <div
                                                    ng-click="removeFile(cl, 0)"
                                                    class="product-color-remove"
                                                    ng-if="cl.files[0]"
                                                >
                                                    <i
                                                        class="ion-ios-trash-outline"
                                                        style="
                                                            color: white;
                                                            font-size: 18px;
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    class="product-color-file"
                                                    ng-if="!cl.files[0]"
                                                    ngf-select="uploadFiles($files, cl)"
                                                    multiple
                                                    accept="image/*"
                                                    name="file"
                                                >
                                                    <i
                                                        class="ion-ios-plus-outline"
                                                        style="
                                                            color: rgb(
                                                                23,
                                                                145,
                                                                242
                                                            );
                                                            font-size: 24px;
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-color-element">
                                            <div>
                                                <img
                                                    class="product-color-img"
                                                    ng-if="cl.files[1]"
                                                    ngf-src="cl.files[1]"
                                                />
                                                <div
                                                    ng-click="removeFile(cl, 1)"
                                                    class="product-color-remove"
                                                    ng-if="cl.files[1]"
                                                >
                                                    <i
                                                        class="ion-ios-trash-outline"
                                                        style="
                                                            color: white;
                                                            font-size: 18px;
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    class="product-color-file"
                                                    ng-if="!cl.files[1]"
                                                    ngf-select="uploadFiles($files, cl)"
                                                    multiple
                                                    accept="image/*"
                                                    name="file"
                                                >
                                                    <i
                                                        class="ion-ios-plus-outline"
                                                        style="
                                                            color: rgb(
                                                                23,
                                                                145,
                                                                242
                                                            );
                                                            font-size: 24px;
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-color-element">
                                            <div>
                                                <img
                                                    class="product-color-img"
                                                    ng-if="cl.files[2]"
                                                    ngf-src="cl.files[2]"
                                                />
                                                <div
                                                    ng-click="removeFile(cl, 2)"
                                                    class="product-color-remove"
                                                    ng-if="cl.files[2]"
                                                >
                                                    <i
                                                        class="ion-ios-trash-outline"
                                                        style="
                                                            color: white;
                                                            font-size: 18px;
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    class="product-color-file"
                                                    ng-if="!cl.files[2]"
                                                    ngf-select="uploadFiles($files, cl)"
                                                    multiple
                                                    accept="image/*"
                                                    name="file"
                                                >
                                                    <i
                                                        class="ion-ios-plus-outline"
                                                        style="
                                                            color: rgb(
                                                                23,
                                                                145,
                                                                242
                                                            );
                                                            font-size: 24px;
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-color-element">
                                            <div>
                                                <img
                                                    class="product-color-img"
                                                    ng-if="cl.files[3]"
                                                    ngf-src="cl.files[3]"
                                                />
                                                <div
                                                    ng-click="removeFile(cl, 3)"
                                                    class="product-color-remove"
                                                    ng-if="cl.files[3]"
                                                >
                                                    <i
                                                        class="ion-ios-trash-outline"
                                                        style="
                                                            color: white;
                                                            font-size: 18px;
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    class="product-color-file"
                                                    ng-if="!cl.files[3]"
                                                    ngf-select="uploadFiles($files, cl)"
                                                    multiple
                                                    accept="image/*"
                                                    name="file"
                                                >
                                                    <i
                                                        class="ion-ios-plus-outline"
                                                        style="
                                                            color: rgb(
                                                                23,
                                                                145,
                                                                242
                                                            );
                                                            font-size: 24px;
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-color-element">
                                            <div>
                                                <img
                                                    class="product-color-img"
                                                    ng-if="cl.files[4]"
                                                    ngf-src="cl.files[4]"
                                                />
                                                <div
                                                    ng-click="removeFile(cl, 4)"
                                                    class="product-color-remove"
                                                    ng-if="cl.files[4]"
                                                >
                                                    <i
                                                        class="ion-ios-trash-outline"
                                                        style="
                                                            color: white;
                                                            font-size: 18px;
                                                        "
                                                    ></i>
                                                </div>
                                                <div
                                                    class="product-color-file"
                                                    ng-if="!cl.files[4]"
                                                    ngf-select="uploadFiles($files, cl)"
                                                    multiple
                                                    accept="image/*"
                                                    name="file"
                                                >
                                                    <i
                                                        class="ion-ios-plus-outline"
                                                        style="
                                                            color: rgb(
                                                                23,
                                                                145,
                                                                242
                                                            );
                                                            font-size: 24px;
                                                        "
                                                    ></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 40px">
                                <div class="col-md-3" style="text-align: end">
                                    Phân loại nhóm size
                                </div>
                                <div
                                    class="col-md-8"
                                    style="background-color: rgb(250, 250, 250)"
                                >
                                    <div class="row">
                                        <div
                                            ng-repeat="s in product.sizes"
                                            class="col-md-12"
                                        >
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <md-input-container
                                                        class="md-block"
                                                    >
                                                        <label>Tên size</label>
                                                        <input
                                                            md-maxlength="100"
                                                            required
                                                            md-no-asterisk
                                                            name="product_size"
                                                            ng-model="s.size_name"
                                                            ng-change="changeSizeName($index, s)"
                                                        />
                                                        <div
                                                            ng-messages="productForm.product_size.$error"
                                                        >
                                                            <div
                                                                ng-message="required"
                                                            >
                                                                This is
                                                                required.
                                                            </div>
                                                            <div
                                                                ng-message="md-maxlength"
                                                            >
                                                                The product_name
                                                                must be less
                                                                than 500
                                                                characters long.
                                                            </div>
                                                        </div>
                                                    </md-input-container>
                                                </div>
                                                <div class="col-md-1">
                                                    <md-button
                                                        ng-if="
                                                            product.sizes
                                                                .length > 1
                                                        "
                                                        ng-click="removeSize($index)"
                                                        class="md-icon-button"
                                                    >
                                                        <md-icon
                                                            md-font-icon="ion-ios-trash-outline"
                                                            ng-style="{
                                                                'font-size':
                                                                    '24px'
                                                            }"
                                                        ></md-icon>
                                                    </md-button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <button
                                                ng-click="addSize()"
                                                class="btn-customer"
                                                type="button"
                                            >
                                                <i
                                                    class="ion-ios-plus-outline"
                                                    style="
                                                        color: rgb(
                                                            23,
                                                            145,
                                                            242
                                                        );
                                                        font-size: 18px;
                                                        padding-right: 10px;
                                                    "
                                                ></i>
                                                <span>Thêm phân loại size</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 40px">
                                <div class="col-md-3" style="text-align: end">
                                    Danh sách phân loại hàng
                                </div>
                                <div class="col-md-8">
                                    <div class="product-classify">
                                        <div style="width: 50%">
                                            <div
                                                class="product-classify-header"
                                            >
                                                <div
                                                    class="product-classify-cell"
                                                >
                                                    <div
                                                        class="product-classify-content"
                                                    >
                                                        Màu
                                                    </div>
                                                </div>
                                                <div
                                                    class="product-classify-cell"
                                                >
                                                    <div
                                                        class="product-classify-content"
                                                    >
                                                        Size
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-classify-body">
                                                <div
                                                    ng-repeat="cl in product.colors"
                                                    class="product-classify-wrap"
                                                >
                                                    <div
                                                        class="product-classify-body-cell"
                                                    >
                                                        @{{ cl.color_name }}
                                                    </div>
                                                    <div
                                                        class="product-classify-body-cell-group"
                                                    >
                                                        <div
                                                            ng-repeat="s in cl.sizes"
                                                        >
                                                            @{{ s.size_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="width: 50%">
                                            <div
                                                class="product-classify-header"
                                            >
                                                <div
                                                    class="product-classify-cell"
                                                >
                                                    <div
                                                        class="product-classify-content"
                                                    >
                                                        Kho hàng
                                                    </div>
                                                </div>
                                                <div
                                                    class="product-classify-cell"
                                                >
                                                    <div
                                                        class="product-classify-content"
                                                    >
                                                        Giá (VNĐ)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-classify-body">
                                                <div
                                                    ng-repeat="cl in product.colors"
                                                    class="product-classify-wrap"
                                                >
                                                    <div
                                                        class="product-classify-body-cell-group"
                                                    >
                                                        <div
                                                            ng-repeat="s in cl.sizes"
                                                        >
                                                            <input
                                                                class="product-classify-body-cell-input"
                                                                type="text"
                                                                placeholder="Nhập vào"
                                                                ng-model="s.quantity"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="product-classify-body-cell"
                                                    >
                                                        <input
                                                            class="product-classify-body-cell-input"
                                                            type="text"
                                                            ng-model="cl.product_price"
                                                            placeholder="Nhập vào"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <md-progress-linear
                            ng-if="progress"
                            md-mode="determinate"
                            value="@{{ progress }}"
                        >
                        </md-progress-linear>
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
                                >Hủy</md-button
                            >
                            <md-button
                                class="md-raised md-primary"
                                type="submit"
                                ng-click="addProduct()"
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
                            Bạn có đồng ý muốn xóa sản phẩm?
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
                                >Hủy</md-button
                            >
                            <md-button
                                ng-click="deleteProduct()"
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
