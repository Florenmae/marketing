<template lang="">
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        @click="toggleSidebar"
        :class="{ clicked: clicked }"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 10 10"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>

    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar"
        :class="{ hovered: clicked }"
    >
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800 border border-gray-300"
        >
            <div class="flex items-center ps-2.5 mb-5 gap-2">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white"
                    >Marketing</span
                >
            </div>
            <ul class="space-y-4 font-medium flex flex-col justify-between">
                <div class="pb-[200px] space-y-3">
                    <li>
                        <router-link to="/home">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-chart-pie"
                                    style="font-size: 1.3rem"
                                ></i>
                                <span class="ms-3">Dashboard</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/user">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                                ><i
                                    class="pi pi-users"
                                    style="font-size: 1.5rem"
                                ></i>
                                <span class="ms-3">Users</span>
                            </a>
                        </router-link>
                    </li>

                    <li>
                        <button
                            type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-product"
                            data-collapse-toggle="dropdown-product"
                            @click="toggleDropdown('dropdown-product')"
                        >
                            <i
                                class="pi pi-shopping-bag"
                                style="font-size: 1.5rem"
                            ></i>
                            <span
                                class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                                >Product</span
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul id="dropdown-product" class="hidden py-2 space-y-2">
                            <li>
                                <a
                                    href="/category"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Category List</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/productlist"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Product List</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/product"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Inventory List</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/pendingOrder"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Orders</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button
                            type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-sales"
                            data-collapse-toggle="dropdown-sales"
                            @click="toggleDropdown('dropdown-sales')"
                        >
                            <img
                                src="../../../public/sales.png"
                                class="w-6 h-6"
                            />
                            <span
                                class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                                >Sales</span
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul id="dropdown-sales" class="hidden py-2 space-y-2">
                            <!-- <li>
                                <a
                                    href=""
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Sales List</a
                                >
                            </li> -->
                            <li>
                                <a
                                    href="/cashreg"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Cash Registry</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/pos"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >POS</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button
                            type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-trans"
                            data-collapse-toggle="dropdown-trans"
                            @click="toggleDropdown('dropdown-trans')"
                        >
                            <img
                                src="../../../public/invoice.png"
                                class="w-6 h-6"
                            />
                            <span
                                class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                                >Transactions</span
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul id="dropdown-trans" class="hidden py-2 space-y-2">
                            <li>
                                <a
                                    href="/transaction"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Transaction List</a
                                >
                            </li>
                            <li>
                                <a
                                    href="/orderlist"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Order List</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button
                            type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-return"
                            data-collapse-toggle="dropdown-return"
                            @click="toggleDropdown('dropdown-return')"
                        >
                            <img
                                src="../../../public/return.png"
                                class="w-7 h-7"
                            />
                            <span
                                class="flex-1 ms-2 text-left rtl:text-right whitespace-nowrap"
                                >Return</span
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul id="dropdown-return" class="hidden py-2 space-y-2">
                            <li>
                                <a
                                    href="/returnlist"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Returned Items</a
                                >
                            </li>
                        </ul>
                    </li>
                    <li>
                        <button
                            type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-report"
                            data-collapse-toggle="dropdown-report"
                            @click="toggleDropdown('dropdown-report')"
                        >
                            <img
                                src="../../../public/report.png"
                                class="w-7 h-7"
                            />
                            <span
                                class="flex-1 ms-2 text-left rtl:text-right whitespace-nowrap"
                                >Reports</span
                            >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 4 4 4-4"
                                />
                            </svg>
                        </button>
                        <ul id="dropdown-report" class="hidden py-2 space-y-2">
                            <li>
                                <a
                                    href="/salesreport"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Sales Report</a
                                >
                            </li>
                            <!-- <li>
                                <a
                                    href=""
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Inventory Report</a
                                >
                            </li> -->
                            <li>
                                <a
                                    href="/returnlist"
                                    class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                    >Returned Items Report</a
                                >
                            </li>
                        </ul>
                    </li>
                </div>

                <li @click="logout">
                    <a
                        href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 18 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                            />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap"
                            >Logout</span
                        >
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div
        class="fixed w-screen ml-64 h-16 bg-white border-b border-gray-300"
    ></div>
    <div class="ml-64 px-10">
        <div class="flex flex-col items-center pb-20 pt-10 min-h-screen">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            clicked: false,
        };
    },
    methods: {
        toggleSidebar() {
            this.clicked = !this.clicked;
        },
        toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle("hidden");
        },
        logout() {
            axios.post("/logout").then(() => {
                this.$router.push("/");
            });
        },
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                if (!data) {
                    this.$router.push("/");
                }
            });
        },
    },
    mounted() {
        this.checkAuth();
    },
};
</script>
