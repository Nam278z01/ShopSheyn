<header class="h-[54px]">
    <div class="fixed left-0 w-full z-40">
        <!-- Navigation -->
        <nav
            class="relative flex items-center h-[54px] w-full px-5 shadow-[0_6px_12px_0_#0000000a] bg-[#fff] border-b border-transparent hover:bg-[#f7f8fa]"
        >
            <div class="flex h-[54px] items-center w-3/4">
                <div>
                    <a
                        href="#"
                        class="relative inline-block h-[54px] px-[15px] text-black text-3xl font-bold leading-[54px]"
                    >
                        <div
                            class="h-[54px]"
                            style="font-family: 'Beau Rivage', cursive"
                        >
                            Sheyn
                        </div>
                    </a>
                </div>
                <div class="group">
                    <a
                        href="/"
                        class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]"
                    >
                        <div
                            ng-class="{
                                'text-[#8e8e8e]': activeNavigation('/')
                            }"
                            class="h-[54px]"
                        >
                            Trang Chủ
                        </div>
                    </a>
                </div>
                <div class="group">
                    <a
                        href="#"
                        class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]"
                    >
                        <div class="h-[54px]">Hàng Mới</div>
                    </a>
                </div>
                <div class="group">
                    <a
                        href="#"
                        class="relative inline-block h-[54px] px-[15px] text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px] text-[#ed354b]"
                    >
                        <div class="h-[54px]">SALE</div>
                    </a>
                </div>
                <div class="group">
                    <a
                        href="#"
                        class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]"
                    >
                        <div class="h-[54px]">Xu Hướng</div>
                    </a>
                </div>
                <div class="group pointer-events-none">
                    <a
                        href="/product"
                        class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px] pointer-events-auto"
                    >
                        <div
                            ng-class="{
                                'text-[#8e8e8e]': activeNavigation('/product')
                            }"
                            class="h-[54px]"
                        >
                            Trang Phục
                        </div>
                    </a>
                    <nav
                        class="absolute z-10 top-full left-0 right-0 py-[20px] bg-white invisible group-hover:visible transition-all pointer-events-auto"
                    >
                        <div class="flex flex-wrap h-[300px] justify-center">
                            <div class="px-[15px] text-[13px] w-[400px]">
                                <h6 class="font-bold text-[#8e8e8e]">
                                    Danh Mục
                                </h6>
                                <ul
                                    class="mt-5 flex flex-col flex-wrap h-[270px]"
                                >
                                    <li class="leading-7 capitalize w-2/4">
                                        <a
                                            href="/product"
                                            ng-class="{
                                                'text-[#fa6338]':
                                                    changeCategory(
                                                        undefined,
                                                        true
                                                    )
                                            }"
                                            class="text-black font-bold hover:text-[#fa6338]"
                                            >Tất cả</a
                                        >
                                    </li>
                                    <li
                                        ng-repeat="c in categories"
                                        class="leading-7 capitalize w-2/4"
                                    >
                                        <a
                                            href="/product?category_id=@{{
                                                c.category_id
                                            }}"
                                            ng-class="{
                                                'text-[#fa6338]':
                                                    changeCategory(
                                                        c.category_id,
                                                        true
                                                    )
                                            }"
                                            class="text-black font-bold hover:text-[#fa6338]"
                                            >@{{ c.category_name }}</a
                                        >
                                    </li>
                                </ul>
                            </div>
                            <div class="px-[15px] text-[13px] w-[200px]">
                                <h6 class="font-bold text-[#8e8e8e]">
                                    Xu Hướng
                                </h6>
                                <ul class="mt-5">
                                    <li class="leading-7 capitalize">
                                        <a
                                            ng-class="{
                                                'text-[#fa6338]': changeSort(
                                                    true,
                                                    1
                                                )
                                            }"
                                            href="/product?sort=1"
                                            class="text-black font-bold hover:text-[#fa6338]"
                                            >Hàng mới nhất</a
                                        >
                                    </li>
                                    <li class="leading-7 capitalize">
                                        <a
                                            ng-class="{
                                                'text-[#fa6338]': changeSort(
                                                    true,
                                                    2
                                                )
                                            }"
                                            href="/product?sort=2"
                                            class="text-black font-bold hover:text-[#fa6338]"
                                            >Bán chạy nhất</a
                                        >
                                    </li>
                                    <li class="leading-7 capitalize">
                                        <a
                                            ng-class="{
                                                'text-[#fa6338]': changeSort(
                                                    true,
                                                    3
                                                )
                                            }"
                                            href="/product?sort=3"
                                            class="text-black font-bold hover:text-[#fa6338]"
                                            >Giảm giá nhiều nhất</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <div
                        class="absolute bg-[rgba(0,0,0,.5)] top-full left-0 w-full h-[100vh] pointer-events-none invisible group-hover:visible transition-all"
                    ></div>
                </div>
                <div class="group">
                    <a
                        href="#"
                        class="relative inline-block h-[54px] px-[15px] text-black text-[13px] font-semibold hover:text-[#8e8e8e] leading-[54px]"
                    >
                        <div class="h-[54px]">Giới Thiệu</div>
                    </a>
                </div>
            </div>

            <!-- Search -->
            <form class="w-[250px] h-[40px] relative">
                <input
                    ng-model="text_search"
                    type="text"
                    placeholder="Tìm kiếm sản phẩm..."
                    class="h-full w-full border border-[rgb(0 0 0 / 10%)] pl-3 pr-14 focus:outline-none focus:border-black text-xs"
                />
                <button
                    ng-click="search()"
                    class="absolute top-0 right-0 w-[40px] h-[40px] text-[30px] flex justify-center items-center text-white bg-black hover:bg-[rgba(34,34,34,.8)]"
                >
                    <i class="bx bx-search-alt-2"></i>
                </button>
            </form>

            <!-- User/Cart -->
            <div class="flex h-[54px] justify-end text-black ml-5 pr-[15px]">
                <div class="h-[54px] group">
                    <a
                        ng-class="{ 'bg-white': activeNavigation('/cart') }"
                        href="#"
                        class="relative h-[54px] flex justify-center items-center text-3xl ml-1 px-1 cursor-pointer group-hover:bg-white hover:bg-white"
                    >
                        <i ng-if="!is_login" class="bx bx-user"></i>
                        <img
                            ng-if="is_login"
                            class="rounded-full h-[30px] w-[30px]"
                            ng-src="/image/img/@{{ customer.image }}"
                            alt="Avatar"
                        />
                    </a>
                    <div
                        class="absolute top-[54px] right-0 min-w-[180px] bg-white shadow-[0_6px_6px_0_#00000014] invisible group-hover:visible"
                    >
                        <div class="mx-[20px] mb-[10px]">
                            <div
                                ng-if="!is_login"
                                ng-click="showModalLogin()"
                                class="border-b border-[#0000001a] text-xs leading-[45px] text-[#000000cc] font-bold cursor-pointer hover:text-black"
                            >
                                Đăng nhập / Đăng ký
                            </div>
                            <a
                                href="#"
                                ng-if="is_login"
                                class="block border-b border-[#0000001a] text-xs leading-[45px] text-[#000000cc] font-bold cursor-pointer hover:text-black"
                            >
                                @{{ customer.customer_name }}
                            </a>
                            <a
                                ng-if="is_login"
                                href="/orders"
                                class="text-xs leading-[36px] text-[#00000099] hover:text-[#222]"
                            >
                                Đơn hàng của tôi
                            </a>
                            <div
                                ng-if="is_login"
                                ng-click="logout()"
                                class="text-xs leading-[36px] text-[#00000099] hover:text-[#222] cursor-pointer"
                            >
                                Đăng xuất
                            </div>
                        </div>
                    </div>
                </div>
                <div class="h-[54px] group">
                    <a
                        ng-class="{ 'bg-white': activeNavigation('/cart') }"
                        href="/cart"
                        class="relative h-[54px] flex justify-center items-center text-3xl ml-1 px-1 cursor-pointer group-hover:bg-white hover:bg-white"
                    >
                        <i
                            class="bx bx-cart"
                            ng-class="{ 'bx-tada': cart.length > 0 }"
                        ></i>
                        <span
                            ng-if="cart.length > 0"
                            class="text-[#fa6338] text-sm font-bold ml-1 absolute left-1/2 top-[10px] bg-[rgba(255,255,255,0.9)] min-w-[15px] min-h-[15px] text-center block rounded-full"
                            >@{{ cart.length }}</span
                        >
                    </a>
                    <div
                        ng-class="{'invisible' : !isShowCart}"
                        class="absolute top-[54px] right-0 w-[400px] bg-white shadow-[0_6px_6px_0_#00000014] group-hover:visible"
                    >
                        <div
                            class="scrollbar overflow-y-scroll pt-[10px] max-h-[300px] min-h-[100px]"
                        >
                            <div ng-if="!cart || cart.length == 0">
                                <img
                                    class="w-[64px] h-[64px] m-auto"
                                    src="/image/product/cart-empty.png"
                                    alt="Giỏ hàng rỗng"
                                />
                                <span
                                    class="m-[20px] text-[#666] text-center block text-xs"
                                    >Giỏ hàng rỗng</span
                                >
                            </div>
                            <div
                                ng-repeat="product in cart track by product.cart_id"
                                class="flex my-[10px] mx-[20px]"
                            >
                                <div class="w-[90px] relative group-scope">
                                    <img
                                        ng-src="/image/product/@{{
                                            product.picked.color.product_image1
                                        }}"
                                        alt="@{{ product.product_name }}"
                                        class="w-full"
                                    />
                                    <img
                                        ng-src="/image/product/@{{
                                            product.picked.color
                                                .product_image2 ||
                                                product.picked.color
                                                    .product_image3 ||
                                                product.picked.color
                                                    .product_image4 ||
                                                product.picked.color
                                                    .product_image5
                                        }}"
                                        alt="@{{ product.product_name }}"
                                        class="absolute top-0 left-0 w-full opacity-0 group-scope-hover:opacity-100 transition-all duration-500"
                                    />
                                    <div
                                        ng-click="removeProductFromCart(product.cart_id)"
                                        class="absolute bottom-0 h-[26px] hidden justify-center items-center w-full bg-[rgba(0,0,0,0.3)] group-scope-hover:flex cursor-pointer"
                                    >
                                        <button>
                                            <i class='bx bxs-trash-alt text-[16px] text-white'></i>
                                        </button>
                                    </div>
                                    <div
                                        ng-if="product.product_discount != 0"
                                        class="absolute top-[6px] left-0 w-[40px] text-center text-xs leading-[20px] bg-[#222] text-white"
                                    >
                                        -@{{ product.product_discount }}%
                                    </div>
                                </div>
                                <div class="ml-[10px] flex-1">
                                    <a href="/details?product_id=@{{ product.product_id }}" class="text-xs mb-[5px] hover:underline">
                                        <span>@{{ product.product_name }}</span>
                                    </a>
                                    <div class="flex py-1 -mx-[10px]">
                                        <select
                                            ng-change="changeColorInCart(product, '@{{product}}')"
                                            ng-model="product.picked.color"
                                            ng-options="color.color_name for color in product.colors"
                                            class="mx-[10px] border border-solid text-[#222] font-bold rounded-[18px] border-gray-300 focus:border-black focus:outline-none text-xs px-3 py-1"
                                        ></select>
                                        <select
                                            ng-model="product.picked.size"
                                            ng-change="changeSizeInCart(product, '@{{product}}')"
                                            ng-options="size.size_name for size in product.picked.color.sizes"
                                            class="mx-[10px] border border-solid text-[#222] font-bold rounded-[18px] border-gray-300 focus:border-black focus:outline-none text-xs px-3 py-1"
                                        ></select>
                                    </div>
                                    <div
                                        class="flex justify-between items-center"
                                    >
                                        <div
                                            class="flex mt-[5px] h-[30px] items-center"
                                        >
                                            <button
                                                ng-click="decreaseInCart(product)"
                                                class="w-[25px] h-[24px] border border-gray-300 focus:border-black flex items-center justify-center rounded-tl-[100px] rounded-bl-[100px]"
                                            >
                                                <i
                                                    class="bx bx-minus text-xs"
                                                ></i>
                                            </button>
                                            <input
                                                ng-blur="editCart(product, product)"
                                                ng-keypress="validateNumber($event, product)"
                                                ng-model="product.picked.quantity"
                                                type="text"
                                                class="text-[13px] w-[30px] h-[24px] border-t border-b border-gray-300 focus:border focus:border-black focus:outline-none text-center"
                                            />
                                            <button
                                                ng-click="increaseInCart(product)"
                                                class="w-[25px] h-[24px] border border-gray-300 focus:border-black flex items-center justify-center rounded-tr-[100px] rounded-br-[100px]"
                                            >
                                                <i
                                                    class="bx bx-plus text-xs"
                                                ></i>
                                            </button>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                ng-if="
                                                    product.product_discount ==
                                                    0
                                                "
                                                class="text-black font-bold text-[13px]"
                                            >
                                                @{{
                                                    product.picked.color
                                                        .product_price *
                                                        product.picked.quantity
                                                        | number: 0
                                                }}₫
                                            </span>
                                        </div>
                                        <div
                                            ng-if="
                                                product.product_discount != 0
                                            "
                                            class="flex flex-col text-sm"
                                        >
                                            <span
                                                class="text-[#fa6338] font-bold text-[13px]"
                                            >
                                                @{{
                                                    (product.picked.color
                                                        .product_price -
                                                        (product.picked.color
                                                            .product_price *
                                                            product.product_discount) /
                                                            100) *
                                                        product.picked.quantity
                                                        | number: 0
                                                }}₫
                                            </span>
                                            <del class="text-[#999] text-xs">
                                                @{{
                                                    product.picked.color
                                                        .product_price *
                                                        product.picked.quantity
                                                        | number: 0
                                                }}₫
                                            </del>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            ng-if="cart && cart.length != 0"
                            class="h-[50px] m-[15px] pt-[15px] text-[13px] border-t border-dashed border-[#e5e5e5]"
                        >
                            {{-- <p class="flex justify-end items-center pb-2">
                                <span> Tổng cộng: </span>
                                <span
                                    class="text-[#fa6338] text-[18px] font-bold ml-1"
                                    >@{{ total_price | number: 0 }}₫</span
                                >
                            </p> --}}
                            <a
                                href="/cart"
                                class="flex justify-center items-center h-[36px] w-full text-sm px-[30px] font-extrabold border border-black text-black bg-white hover:bg-[rgba(34,34,34,.8)] hover:text-white"
                            >
                                Xem giỏ hàng
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
