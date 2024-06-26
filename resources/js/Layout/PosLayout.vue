<template>
    <div class="flex flex-col h-screen border-gray-300">
        <header
            class="bg-slate-500 text-black p-4 border-b border-gray-300 flex justify-between items-center"
        >
            <!-- Logo and title -->
            <div class="flex items-center space-x-4">
                <img
                    src="../../../public/mmsu_logo.png"
                    alt=""
                    class="w-10 h-10"
                />
                <h1 class="text-lg mr-4">Point of Sale System</h1>
                <!-- 
                <div class="relative rounded-full bg-gray-200">
                    <input
                        type="text"
                        placeholder="Search..."
                        class="p-1 pl-10 bg-transparent outline-none rounded-full"
                    />
                    <svg
                        class="absolute left-4 top-2 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-5.2-5.2"
                        ></path>
                        <circle cx="10" cy="10" r="8"></circle>
                    </svg>
                </div> -->
            </div>

            <div class="flex items-center space-x-4 relative">
                <div class="relative" @click="toggleDropdown">
                    <button
                        class="relative right-5 text-black flex items-center space-x-4"
                    >
                        <img src="../../../public/user.png" class="w-10 h-10" />
                    </button>
                    <div
                        v-if="showDropdown"
                        class="absolute right-0 mt-2 bg-white rounded-md shadow-md"
                    >
                        <a
                            href="pos"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                        >
                            POS
                        </a>
                        <a
                            href="orders"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-200"
                        >
                            Orders
                        </a>
                        <a
                            href="/home"
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
