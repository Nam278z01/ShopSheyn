<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>In hóa đơn</title>
    <link rel="shortcut icon" href="/image/product/icon.png" />
    <link href="/css/customer.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet"
    />
</head>
<body ng-app="myApp" ng-controller="PrintController">
    <div class="bg-[#fafafc]">
        <div class="mx-auto flex relative overflow-hidden" style="width: 650px">
            <div
                class="w-full flex-shrink-0 flex-grow shadow-[0_6px_12px_0_#0000000a]"
            >
                <div class="mt-[12px]">
                    <div class="pt-[24px] px-[24px] pb-[12px] bg-white">
                        <div class="text-[15px] pb-[12px] flex justify-between">
                            <span class="text-black font-bold text-xs italic"
                                >ID ĐƠN HÀNG: @{{ order.order_id }}</span
                            >
                        </div>
                        <div class="py-[10px] text-xs font-bold text-[#fa6338] border-t border-[#eaeaea] text-center">
                            Cảm ơn bạn đã mua sắm tại Shop Sheyn!
                        </div>
                        <div class="py-[20px] border-t border-[#eaeaea] rounded-br rounded-bl">
                            <div class="pb-[12px] text-sm font-medium">
                                Địa Chỉ Nhận Hàng
                            </div>
                            <div class="flex">
                                <div class="w-full pt-[10px] pr-[24px] flex-1">
                                    <div class="text-[13px] font-medium mb-[8px] text-[rgba(0,0,0,.8)]">@{{ order.customer_name }}</div>
                                    <div class="text-xs leading-[22px] text-[rgba(0,0,0,.54)]">
                                        <span>@{{ order.customer_phone }}</span></br>
                                        @{{ order.customer_address }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="border-t border-[#eaeaea] rounded-br rounded-bl"
                        >
                            <span
                                ng-repeat="od in order.orderdetails"
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
                                    </div>
                                    <div class="pl-[12px]">
                                        <div
                                            class="text-[13px] mb-[5px]"
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
                                        <div class="text-sm mb-[5px]">
                                            x@{{ od.product_quantity }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <!-- Normal -->
                                    <span
                                        ng-if="od.product_discount == 0"
                                        class="font-semibold text-xl text-black"
                                    >
                                        @{{od.price * od.product_quantity |
                                        number:0}}₫
                                    </span>
    
                                    <!-- Discount -->
                                    <span
                                        ng-if="od.product_discount != 0"
                                        class="text-[#fa6338] text-lg block font-semibold mr-2"
                                    >
                                        @{{(od.price - od.price * od.product_discount
                                        / 100) * od.product_quantity | number:0}}₫
                                    </span>
                                    <del
                                        ng-if="od.product_discount != 0"
                                        class="text-[#999] text-sm"
                                    >
                                        @{{od.price * od.product_quantity |
                                        number:0}}₫
                                    </del>
                                    <div
                                        ng-if="od.product_discount != 0"
                                        class="w-[50px] text-center text-xs leading-[20px] bg-[#222] text-white ml-3"
                                    >
                                        -@{{ od.product_discount }}%
                                    </div>
                                </div>
                            </span>
                        </div>
                        <div
                            class="mt-[12px] border-t border-[#eaeaea]"
                        >
                            <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                <div class="flex-1 py-[13px] px-[10px] text-xs text-[rgba(0,0,0,.54)]">
                                    Tổng tiền hàng
                                </div>
                                <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-sm border-l border-dotted border-[rgba(0,0,0,.09)]">
                                    @{{ order.total | number:0}}₫
                                </div>
                            </div>
                            <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                <div class="flex-1 py-[13px] px-[10px] text-xs text-[rgba(0,0,0,.54)]">
                                    Phí vận chuyển
                                </div>
                                <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-sm border-l border-dotted border-[rgba(0,0,0,.09)]">
                                    Miễn phí
                                </div>
                            </div>
                            <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                <div class="flex-1 py-[13px] px-[10px] text-xs text-[rgba(0,0,0,.54)]">
                                    Tổng số tiền
                                </div>
                                <div class="w-[240px] text-[#fa6338] py-[13px] text-2xl font-bold border-l border-dotted border-[rgba(0,0,0,.09)]">
                                    @{{ order.total | number:0}}₫
                                </div>
                            </div>
                            <div class="border-b border-dotted border-[rgba(0,0,0,.09)] flex items-center justify-end w-full text-right">
                                <div class="flex-1 py-[13px] px-[10px] text-xs text-[rgba(0,0,0,.54)]">
                                    Phương thức Thanh toán
                                </div>
                                <div class="w-[240px] text-[rgba(0,0,0,.8)] py-[13px] text-sm border-l border-dotted border-[rgba(0,0,0,.09)]">
                                    Thanh toán khi nhận hàng
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
    <script src="/ckeditor/ckeditor.js"></script>
    <script src="/js/admin.js"></script>
</body>
</html>