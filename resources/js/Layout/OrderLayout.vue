<template>
    <div class="flex flex-col h-screen border-gray-300">
        <header
            class="bg-slate-500 text-black p-4 border-b border-gray-300 flex justify-between items-center"
        >
            <div class="flex items-center space-x-4">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <h1 class="text-lg mr-4">Point of Sale System</h1>
            </div>

            <div class="flex items-center space-x-4 relative">
                <div class="relative" @click="toggleDropdown">
                    <button class="text-black flex items-center space-x-4">
                        <img src="../../../public/user.png" class="w-10 h-10" />
                    </button>
                    <div
                        v-if="showDropdown"
                        class="absolute right-0 mt-2 bg-white rounded-md shadow-md"
                    >
                        <a
                            href="UserOrders"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                        >
                            Orders
                        </a>
                        <a
                            href="orderDashboard"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                        >
                            Exit
                        </a>
                        <a
                            href="/"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                        >
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <div class="px-5">
            <div class="flex flex-col items-center pb-20 pt-5 min-h-screen">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PosLayout",
    data() {
        return {
            showDropdown: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
    },
};
</script>
