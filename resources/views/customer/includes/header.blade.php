<header class="h-[54px]">
    <div class="fixed left-0 w-full z-50">
        <!-- Navigation -->
        <nav class="relative flex items-center h-[54px] w-full px-5 shadow-[0_6px_12px_0_#0000000a] bg-[#fff] border-b border-transparent hover:bg-[#f7f8fa]">

            <div class="flex h-[54px] items-center w-3/4">
                <div>
                    <a href="#" class="relative inline-block h-[54px] px-[15px] text-black text-3xl font-bold leading-[54px]">
                        <div class="h-[54px]" style="font-family: 'Beau Rivage', cursive;">Sheyn
                        </div>
                    </a>
                </div>
                <div class="group">
                    <a href="#!/" class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]">
                        <div ng-class="{'text-[#8e8e8e]': activeNavigation('/')}" class="h-[54px]">Trang Chủ
                        </div>
                    </a>
                </div>
                <div class="group">
                    <a href="#" class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]">
                        <div class="h-[54px]">Hàng Mới
                        </div>
                    </a>
                </div>
                <div class="group">
                    <a href="#" class="relative inline-block h-[54px] px-[15px] text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px] text-[#ed354b]">
                        <div class="h-[54px]">SALE</div>
                    </a>
                </div>
                <div class="group">
                    <a href="#" class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]">
                        <div class="h-[54px]">Xu Hướng
                        </div>
                    </a>
                </div>
                <div class="group pointer-events-none">
                    <a href="#!/product" class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px] pointer-events-auto">
                        <div ng-class="{'text-[#8e8e8e]': activeNavigation('/product')}" class="h-[54px]">Trang Phục</div>
                    </a>
                    <nav class="absolute z-10 top-full left-0 right-0 py-[20px] bg-white invisible group-hover:visible transition-all pointer-events-auto">
                        <div class="flex flex-wrap h-[320px] justify-center">
                            <div class="px-[15px] text-[13px] w-[400px]">
                                <h6 class="font-bold text-[#8e8e8e]">Danh Mục</h6>
                                <ul class="mt-5 flex flex-col flex-wrap h-[300px]">
                                    <li class="leading-7 capitalize w-2/4">
                                        <a href="#!/product" ng-class="{'text-[#fa6338]': changeCategory(undefined, true)}" class="text-black font-bold hover:text-[#fa6338]">Tất cả</a>
                                    </li>
                                    <li ng-repeat="c in categories" class="leading-7 capitalize w-2/4">
                                        <a href="#!/product?category_id=@{{ c.category_id }}" ng-class="{'text-[#fa6338]': changeCategory(c.category_id, true)}" class="text-black font-bold hover:text-[#fa6338]">@{{ c.category_name }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="px-[15px] text-[13px] w-[200px]">
                                <h6 class="font-bold text-[#8e8e8e]">Xu Hướng</h6>
                                <ul class="mt-5">
                                    <li class="leading-7 capitalize">
                                        <a ng-class="{'text-[#fa6338]': changeSort(true, 1)}" href="#!/product?sort=1" class="text-black font-bold hover:text-[#fa6338]">Hàng mới nhất</a>
                                    </li>
                                    <li class="leading-7 capitalize">
                                        <a ng-class="{'text-[#fa6338]': changeSort(true, 2)}" href="#!/product?sort=2" class="text-black font-bold hover:text-[#fa6338]">Bán chạy nhất</a>
                                    </li>
                                    <li class="leading-7 capitalize">
                                        <a ng-class="{'text-[#fa6338]': changeSort(true, 3)}" href="#!/product?sort=3" class="text-black font-bold hover:text-[#fa6338]">Giảm giá nhiều nhất</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div class="absolute bg-[rgba(0,0,0,.5)] top-full left-0 w-full h-[100vh] pointer-events-none invisible group-hover:visible transition-all"></div>
                </div>
                <div class="group">
                    <a href="#" class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]">
                        <div class="h-[54px]">Giới Thiệu
                        </div>
                    </a>
                </div>
            </div>

            <!-- Search -->
            <form class="w-[250px] h-[40px] relative">
                <input ng-model="text_search" type="text" placeholder="Tìm kiếm sản phẩm..." class="h-full w-full border border-[rgb(0 0 0 / 10%)] pl-3 pr-14 focus:outline-none focus:border-black text-xs" />
                <button ng-click="search()" class="absolute top-0 right-0 w-[40px] h-[40px] text-[30px] flex justify-center items-center text-white bg-black hover:bg-[rgba(34,34,34,.8)]">
                    <i class='bx bx-search-alt-2'></i>
                </button>
            </form>

            <!-- User/Cart -->
            <div class="flex h-[58px] justify-end text-black ml-5 pr-[15px]">
                <div class="relative h-[58px] flex justify-center items-center text-3xl mr-1 cursor-pointer p-1 hover:bg-white">
                    <i class='bx bx-user'></i>
                </div>
                <div class="h-[58px] p-1 group">
                    <a ng-class="{'bg-white': activeNavigation('/cart')}" href="#!/cart" class="relative h-[58px] flex justify-center items-center text-3xl ml-1 cursor-pointer p-1 group-hover:bg-white hover:bg-white">
                        <i class='bx bx-cart bx-tada'></i>
                        <span class="text-[#fa6338] text-sm font-bold ml-1 absolute left-1/2 top-[10px] bg-[rgba(255,255,255,0.9)] min-w-[15px] min-h-[15px] text-center block rounded-full">1</span>
                    </a>
                    <div class="absolute top-[54px] right-0 w-[400px] bg-white shadow-[0_6px_6px_0_#00000014] invisible group-hover:visible">
                        <div class="pt-[10px]">
                            <!-- Normal -->
                            <div class="flex my-[10px] mx-[20px]">
                                <div class="w-[90px]">
                                    <img src="../image/image5.webp" alt="Image" class="w-full">
                                </div>
                                <div class="ml-[10px] flex-1">
                                    <div class="text-xs mb-[5px]">
                                        <span>Cover Ups Bé gái Thắt nút Chim hồng hạc</span>
                                    </div>
                                    <div class="flex py-1 -mx-[10px]">
                                        <select class="mx-[10px] border border-solid border-transparent text-[#222] font-bold bg-stone-200 rounded-[18px] focus:border-black focus:outline-none text-xs px-3 py-1">
                                            <option value="1" selected>Trắng</option>
                                            <option value="2">Xanh</option>
                                        </select>
                                        <select class="mx-[10px] border border-solid border-transparent text-[#222] font-bold bg-stone-200 rounded-[18px] focus:border-black focus:outline-none text-xs px-3 py-1">
                                            <option value="1" selected>X</option>
                                            <option value="2">XL</option>
                                        </select>
                                    </div>
                                    <div class="flex mt-[5px] h-[30px] items-center">
                                        <button class="w-[25px] h-[24px] border border-gray-300 flex items-center justify-center rounded-tl-[100px] rounded-bl-[100px] text-gray-300 cursor-default">
                                            <i class='bx bx-minus text-xs'></i>
                                        </button>
                                        <input type="text" value="1" class="text-[13px] w-[30px] h-[24px] border-t border-b border-gray-300 focus:border focus:border-black focus:outline-none text-center">
                                        <button class="w-[25px] h-[24px] border border-gray-300 focus:border-black flex items-center justify-center rounded-tr-[100px] rounded-br-[100px]">
                                            <i class='bx bx-plus text-xs'></i>
                                        </button>
                                    </div>
                                    <div class="py-1 flex justify-between">
                                        <button>
                                            <i class='bx bx-trash text-[16px]'></i>
                                        </button>
                                        <div class="flex flex-col">
                                            <span class="text-black font-bold text-[13px]">
                                                378.000đ
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Discount -->
                            <div class="flex my-[10px] mx-[20px]">
                                <div class="w-[90px] relative">
                                    <img src="../image/image5.webp" alt="Image" class="w-full">
                                    <div class="absolute top-[6px] left-0 w-[40px] text-center text-xs leading-[20px] bg-[#222] text-white">-45%</div>
                                </div>
                                <div class="ml-[10px] flex-1">
                                    <div class="text-xs mb-[5px]">
                                        <span>Cover Ups Bé gái Thắt nút Chim hồng hạc</span>
                                    </div>
                                    <div class="flex py-1 -mx-[10px]">
                                        <select class="mx-[10px] border border-solid border-transparent text-[#222] font-bold bg-stone-200 rounded-[18px] focus:border-black focus:outline-none text-xs px-3 py-1">
                                            <option value="1" selected>Trắng</option>
                                            <option value="2">Xanh</option>
                                        </select>
                                        <select class="mx-[10px] border border-solid border-transparent text-[#222] font-bold bg-stone-200 rounded-[18px] focus:border-black focus:outline-none text-xs px-3 py-1">
                                            <option value="1" selected>X</option>
                                            <option value="2">XL</option>
                                        </select>
                                    </div>
                                    <div class="flex mt-[5px] h-[30px] items-center">
                                        <button class="w-[25px] h-[24px] border border-gray-300 flex items-center justify-center rounded-tl-[100px] rounded-bl-[100px] text-gray-300 cursor-default">
                                            <i class='bx bx-minus text-xs'></i>
                                        </button>
                                        <input type="text" value="1" class="text-[13px] w-[30px] h-[24px] border-t border-b border-gray-300 focus:border focus:border-black focus:outline-none text-center">
                                        <button class="w-[25px] h-[24px] border border-gray-300 focus:border-black flex items-center justify-center rounded-tr-[100px] rounded-br-[100px]">
                                            <i class='bx bx-plus text-xs'></i>
                                        </button>
                                    </div>
                                    <div class="py-1 flex justify-between">
                                        <button>
                                            <i class='bx bx-trash text-[16px]'></i>
                                        </button>
                                        <div class="flex flex-col text-sm">
                                            <span class="text-[#fa6338] font-bold text-[13px]">
                                                378.000đ
                                            </span>
                                            <del class="text-[#999] text-xs">
                                                398.000đ
                                            </del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="h-[90px] m-[15px] pt-[15px] text-[13px] border-t border-dashed border-[#e5e5e5]">
                            <p class="flex justify-end items-center pb-2">
                                <span>
                                    Tổng cộng:
                                </span>
                                <span class="text-[#fa6338] text-[18px] font-bold ml-1">398.000đ</span>
                            </p>
                            <a href="#!/cart" class="flex justify-center items-center h-[36px] w-full text-sm px-[30px] font-extrabold border border-black text-black bg-white hover:bg-[rgba(34,34,34,.8)] hover:text-white">
                                Xem giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>