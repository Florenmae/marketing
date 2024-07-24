<template lang="">
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
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
            <ul class="space-y-2 font-medium flex flex-col justify-between">
                <div class="pb-[200px] space-y-4">
                    <li>
                        <router-link to="/userHome">
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
                        <router-link to="/userproduct">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"
                            >
                                <i
                                    class="pi pi-shopping-bag"
                                    style="font-size: 1.5rem"
                                ></i>
                                <span class="ms-3">POS</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/userproductList">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"
                            >
                                <img
                                    src="../../../public/inventory.png"
                                    class="w-6 h-6"
                                />
                                <span class="ms-3">Inventory</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/usersalesreport">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"
                            >
                                <img
                                    src="../../../public/sales.png"
                                    class="w-6 h-6"
                                />
                                <span class="ms-3">Sales</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/userReturnlist">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"
                            >
                                <img
                                    src="../../../public/return.png"
                                    class="w-6 h-6"
                                />
                                <span class="ms-3">Returned Items</span>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/InventoryReport">
                            <a
                                href="#"
                                class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group"
                            >
                                <img
                                    src="../../../public/invoice.png"
                                    class="w-6 h-6"
                                />
                                <span class="ms-3">Inventory Report</span>
                            </a>
                        </router-link>
                    </li>
                </div>

                <li @click="logout">
                    <a
                        href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 group fixed bottom-10 w-60"
                    >
                        <svg
                            class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 18 16"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                            />
                        </svg>
                        <span class="flex-2 ms-4 whitespace-nowrap"
                            >Logout</span
                        >
                    </a>
                </li>
            </ul>
        </div>
    </aside>
    <div
        class="absolute fixed w-screen ml-64 h-14 bg-white border-b border-gray-300"
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
