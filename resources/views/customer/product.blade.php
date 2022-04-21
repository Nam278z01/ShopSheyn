@extends('customer.index')
@section('customer.content')
<div class="px-[50px] bg-[#fff]" ng-controller="ProductController">
    <div class="mt-[10px]">
        <div class="p-[20px] text-sm">
            <span class="text-[#767676]">
                <span>Trang chủ</span>
                <span class="mx-1 ">/</span>
            </span>
            <span>
                Quần áo nữ
            </span>
        </div>

        <!-- Tag -->
        <div class="px-[30px] py-[24px] bg-[#f6f6f6] w-full">
            <div class="flex items-end">
                <h1 class="text-xl font-bold mr-3">Quần áo nữ</h1>
                <span class="text-sm leading-6 text-[#767676]">230842 sản phẩm</span>
            </div>
            <div class="mt-5">
                <ul class="list-none flex">
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Mới
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Đánh giá cao nhất
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Đầm
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Áo sơ mi
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Quần
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Váy
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Áo nỉ
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Áo thun
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Áo len & Áo len đan
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Đồ đi biển
                    </li>
                    <li
                        class="px-3 py-[6px] text-xs cursor-pointer border-[1px] border-[rgb(0 0 0 / 20%)] bg-[#fff] text-[#666] hover:border-[#000] mr-[10px] mb-[10px]">
                        Bộ thời trang
                    </li>
                </ul>
            </div>
        </div>

        <!-- Filter -->
        <div class="flex justify-end items-center my-[15px] h-[40px] px-[22px] text-xs">
            <label class="px-[22px]">Sắp xếp theo</label>
            <select
                class="w-[200px] border border-solid border-gray-300 focus:border-black focus:outline-none text-sm px-3 py-1.5">
                <option value="2" selected>Mới nhất</option>
                <option value="3">Bán chạy</option>
                <option value="4">Giá thấp đến cao</option>
                <option value="5">Giá cao đến thấp</option>
            </select>
        </div>
    </div>

    <div class="flex pl-[205px] relative">
        <!-- Filter -->
        <div class="absolute w-[205px] pr-[25px] pb-[10px] left-0 top-0">
            <div class="border-t border-[rgba(0,0,0,0.05]">
                <div class="pt-5 pb-4">
                    <h3 class="font-semibold text-sm">Danh Mục</h3>
                </div>
            </div>
        </div>

        <!-- List of Product -->
        <div class="w-full pl-[20px]">
            <div class="flex flex-wrap -mx-[10px]">
                <!-- Normal -->
                <div ng-repeat="p in products" class="w-1/4 px-[10px]" ng-init="changeColor(p, p.colors[0])">
                    <div class="w-full pb-[132%] h-0 relative overflow-hidden bg-[#f7f7f7] group">
                        <a href="#!/details" class="w-full inline-block">
                            <img src="/image/@{{p.picked.color.product_image1}}" alt="@{{ p.product_name }}"
                                class="w-full">
                            <img src="/image/@{{p.picked.color.product_image2}}" alt="@{{ p.product_name }}"
                                class="w-full absolute top-0 left-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        </a>
                        <div
                            class="absolute bottom-0 left-0 right-0 px-[15px] py-[15px] transition-all group-hover:flex flex-wrap hidden">
                            <div ng-repeat="s in p.picked.color.sizes" title="Còn @{{ s.quantity }} sản phẩm"
                                class="flex justify-center items-center w-[48px] h-[43px] m-1 text-sm font-bold rounded-2xl bg-white cursor-pointer transition-all hover:bg-black hover:text-white">
                                @{{ s.size_name }}
                            </div>
                        </div>
                        <!-- IF Discount -->
                        <div ng-if="p.product_discount != 0"
                            class="absolute top-[6px] left-0 w-[50px] text-center text-xs leading-[20px] bg-[#222] text-white">
                            -@{{ p.product_discount }}%</div>
                    </div>
                    <div class="min-h-[116px]">
                        <div class="mt-2 text-xs">
                            <a href="#!/details"
                                class="block w-full text-[#767676] overflow-hidden whitespace-nowrap text-ellipsis hover:text-black hover:underline ">
                                @{{ p.product_name }}
                            </a>
                        </div>
                        <div class="mt-[6px] flex items-center">
                            <span ng-if="p.product_discount == 0" class="text-black text-sm block font-bold">
                                @{{p.picked.color.product_price | number:0}}₫
                            </span>
                            <!-- IF Discount -->
                            <span ng-if="p.product_discount != 0" class="text-[#fa6338] text-sm block font-bold mr-1">
                                @{{p.picked.color.product_price - p.picked.color.product_price * p.product_discount / 100
                                | number:0}}₫
                            </span>
                            <del ng-if="p.product_discount != 0" class="text-[#999] text-xs">
                                @{{p.picked.color.product_price | number:0}}₫
                            </del>
                        </div>
                        <div ng-if="p.colors.length > 1" class="mt-[6px] flex">
                            <div ng-repeat="cl in p.colors"
                                ng-class="{'border-black p-[2px]' : p.picked.color.color_id == cl.color_id}"
                                ng-click="changeColor(p, cl)" title="@{{ cl.color_name }}"
                                class="w-[25px] h-[25px] rounded-full border mr-2 cursor-pointer">
                                <img src="/image/@{{ cl.product_image1 }}" alt="@{{ cl.color_name }}"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@stop
