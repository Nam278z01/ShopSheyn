<!DOCTYPE html>
<html ng-app="myApp">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@{{ title }}</title>
        <link rel="shortcut icon" href="/image/product/icon.png" />
        <link href="/css/customer.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Beau+Rivage&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
            rel="stylesheet"
        />
        <style>
            /* Loading */
            .loading {
                position: fixed;
                display: flex;
                z-index: 1000;
                background-color: white;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }

            .loading.hidden {
                opacity: 0;
                visibility: hidden;
                animation: fadeOut 0.5s linear;
            }

            .loading img {
                width: 100px;
                margin: auto;
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                }
                to {
                    opacity: 0;
                }
            }
        </style>
    </head>

    <body>
        <div class="loading">
            <img src="/image/product/loading-37.gif" alt="" />
        </div>
        <div id="root">
            <!-- Header -->
            @include('customer.includes.header')

            <!-- Main -->
            <div ng-view></div>

            <!-- Footer -->
            @include('customer.includes.footer')
        </div>
        <section
            ng-controller="LoginController"
            ng-if="is_show_modal_login && !is_login"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 flex"
        >
            <div
                ng-click="showModalLogin()"
                class="absolute w-full h-full bg-[#00000080]"
            ></div>
            <div class="relative m-auto w-[450px] rounded-md bg-white">
                <form class="w-full" novalidate name="LoginForm">
                    <div class="px-[32px]">
                        <div
                            class="py-[16px] px-[12px] flex justify-between items-center"
                        >
                            <h3
                                class="font-semibold text-[20px] text-[#2563eb]"
                            >
                                Đăng nhập
                            </h3>
                        </div>
                        <div>
                            <div class="mt-[20px]">
                                <div class="relative">
                                    <label
                                        for="EmailLogin"
                                        class="absolute top-0 left-[10px] cursor-pointer py-[1px] px-[5px] bg-white text-xs -translate-y-2/4 font-semibold text-[#2563eb]"
                                        >Email</label
                                    >
                                    <input
                                        ng-model="email"
                                        type="email"
                                        class="p-[15px] h-[44px] rounded text-sm w-full border focus:outline-none focus:border-[#2563eb]"
                                        name="EmailLogin"
                                        placeholder="Email của bạn"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="mt-[20px]">
                                <div class="relative">
                                    <label
                                        for="EmailLogin"
                                        class="absolute top-0 left-[10px] cursor-pointer py-[1px] px-[5px] bg-white text-xs -translate-y-2/4 font-semibold text-[#2563eb]"
                                        >Mật khẩu</label
                                    >
                                    <input
                                        ng-model="password"
                                        type="password"
                                        class="p-[15px] h-[44px] rounded text-sm w-full border focus:outline-none focus:border-[#2563eb]"
                                        name="PassLogin"
                                        placeholder="Mật khẩu của bạn"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="mt-[20px]">
                            <div class="flex justify-end items-center">
                                <a
                                    href="#"
                                    class="text-sm font-medium text-[#2563eb]"
                                    >Quên mật khẩu</a
                                >
                                <span
                                    class="border-l border-[#eaeaea] h-[22px] mx-[20px]"
                                ></span>
                                <a
                                    href="#"
                                    class="text-[#939393] text-sm font-medium"
                                    >Cần trợ giúp?</a
                                >
                            </div>
                        </div>
                        <div class="mt-[50px] flex justify-end">
                            <button
                                ng-click="showModalLogin()"
                                type="button"
                                class="mr-[10px] text-[13px] border border-[#1c1e2080] text-[#1c1e2080] rounded-[50px] flex justify-center items-center px-[14px] py-[6px]"
                            >
                                Quay lại
                            </button>
                            <button
                                ng-click="login()"
                                type="submit"
                                class="text-[13px] bg-gradient-to-r from-[#2563eb] to-[#6bcd87] text-white rounded-[50px] flex justify-center items-center px-[14px] py-[6px]"
                            >
                                Đăng nhập
                            </button>
                        </div>
                    </div>
                    <div
                        class="flex justify-center items-center mt-[20px] pt-[12px] pb-[24px] px-[32px] text-sm"
                    >
                        Hoặc đăng nhập bằng:
                        <button
                            class="ml-[16px] h-[42px] w-[42px] rounded-full flex justify-center items-center bg-[#eaeaea] text-xl"
                        >
                            <i class="bx bxl-facebook text-[#3b5998]"></i>
                        </button>
                        <button
                            class="ml-[16px] h-[42px] w-[42px] rounded-full flex justify-center items-center bg-[#eaeaea]"
                        >
                            <img src="/image/product/gg.png" alt="" />
                        </button>
                    </div>
                </form>
            </div>
        </section>
        <script src="/js/app.js"></script>
        <script src="/js/customer.js"></script>
        <script>
            window.addEventListener("load", function () {
                let loading = document.querySelector(".loading");
                setTimeout(function () {
                    loading.classList.add("hidden");
                }, 700)
            });
        </script>
    </body>
</html>
