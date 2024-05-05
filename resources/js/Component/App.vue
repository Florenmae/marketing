<template>
    <Layout>
        <!-- <div
            class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4 content-between w-full"
        >
            <div
                class="bg-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full border border-red-600"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ userCounts }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Users</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full border border-blue-600"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ userCounts }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Users</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full border border-blue-900"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ userCounts }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Users</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full border border-green-600"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ userCounts }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Users</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div> -->

        <div
            class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-12 content-between w-full"
        >
            <div
                class="bg-red-400 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ userCounts }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Users</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-blue-300 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ productCount }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Products</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-blue-900 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ categoryCount }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Category</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div
                class="bg-green-500 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ returnCount }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Returns</label>
                            </div>
                        </div>
                        <svg
                            class="w-12 h-12 ml-4"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8 content-between w-full h-full"
        >
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg-gray-50 w-full">
                        <label
                            class="px-6 py-3 text-left text-s font-medium text-black-500 uppercase tracking-wider"
                            >Sold Items</label
                        >
                    </div>
                    <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Product Id
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Quantity
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(soldItem, index) in soldItems"
                                    :key="index"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.productId }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.totalPrice }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <span
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >Total Sold Amount:</span
                            >
                            <span>Php {{ totalSoldAmount }}.00</span>
                            <div
                                class="px-4 text-right text-s font-medium text-gray-500 uppercase tracking-wider"
                            >
                                <button
                                    @click="prevPage"
                                    :disabled="pagination.currentPage === 1"
                                >
                                    Prev
                                </button>
                                <span> / </span>
                                <button
                                    @click="nextPage"
                                    :disabled="
                                        pagination.currentPage ===
                                        pagination.lastPage
                                    "
                                >
                                    Next
                                </button>
                                <!-- <span
                                >{{ pagination.currentPage }} /
                                {{ pagination.lastPage }}</span
                            > -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg-gray-50 w-full">
                        <label
                            class="px-6 py-3 text-left text-s font-medium text-black-500 uppercase tracking-wider"
                            >Recently Added</label
                        >
                    </div>
                    <!-- <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Product Id
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Quantity
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Total Price
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(soldItem, index) in soldItems"
                                    :key="index"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.productId }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.totalPrice }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
                            <span
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >Total Items:</span
                            >
                            <span>{{ totalSoldAmount }}</span>
                            <div
                                class="px-4 text-right text-s font-medium text-gray-500 uppercase tracking-wider"
                            >
                                <button
                                    @click="prevPage"
                                    :disabled="pagination.currentPage === 1"
                                >
                                    Prev
                                </button>
                                <span> / </span>
                                <button
                                    @click="nextPage"
                                    :disabled="
                                        pagination.currentPage ===
                                        pagination.lastPage
                                    "
                                >
                                    Next
                                </button>
                               
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-1 gap-4 mt-4 content-between w-full h-full"
        >
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg-gray-50 w-full">
                        <label
                            class="px-6 py-3 text-left text-s font-medium text-black-500 uppercase tracking-wider"
                            >Recently Added</label
                        >
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
import Modal from "../Component/Modal.vue";

// import { Bar } from "vue-chartjs";

// import BarGraph from "./UserComp/Graph/BarGraph.vue";

export default {
    components: {
        Layout,
        Modal,
    },
    data() {
        return {
            authenticated: 0,
            userCounts: null,
            productCount: null,
            categoryCount: null,
            returnCount: null,
            recentProducts: null,
            soldItems: [],
            totalSoldAmount: 0,
            returnedProducts: [],
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
        };
    },
    methods: {
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                this.authenticated = data;
                console.log(this.authenticated);
                if (this.authenticated == 0) {
                    this.$router.push("/");
                }
            });
        },
        editSuccess() {
            this.checkAuth();
        },

        getUserCount() {
            axios
                .get("/get-user-count")
                .then((response) => {
                    console.log("User count response:", response.data);
                    this.userCounts = response.data.count;
                })
                .catch((error) => {
                    console.error("Error fetching user count:", error);
                });
        },
        getProductCount() {
            axios.get("/get-product-count").then((response) => {
                console.log("Product count response:" + response.data);
                this.productCount = response.data.count;
            });
        },
        getCategoryCount() {
            axios.get("/get-category-count").then((response) => {
                console.log("Category count response:", response.data);
                this.categoryCount = response.data.count;
            });
        },
        getReturnCount() {
            axios.get("/get-return-count").then((response) => {
                console.log("Return count response:", response.data);
                this.returnCount = response.data.count;
            });
        },
        getRecentProducts() {
            axios.get("/recent-products").then((response) => {
                this.recentProducts = response.data.recentProducts;
            });
        },

        // getSoldItems() {
        //     axios.get("/get-sold-items").then((response) => {
        //         this.soldItems = response.data.soldItems;
        //         this.totalSoldAmount = response.data.totalSoldAmount;
        //     });
        // },
        getSoldItems(page) {
            axios
                .get(`/get-sold-items?page=${page}`)
                .then((response) => {
                    this.soldItems = response.data.soldItems;
                    this.totalSoldAmount = response.data.totalSoldAmount;
                    this.pagination = response.data.pagination;
                })
                .catch((error) => {
                    console.error("Error fetching sold items:", error);
                });
        },
        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.getSoldItems(this.pagination.currentPage - 1);
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.getSoldItems(this.pagination.currentPage + 1);
            }
        },

        getReturnedProducts() {
            axios.get("/get-returnedProd").then((response) => {
                this.returnedProducts = response.data.returnedProducts;
            });
        },
    },
    mounted() {
        this.checkAuth();
        this.getUserCount();
        this.getProductCount();
        this.getCategoryCount();
        this.getReturnCount();
        this.getRecentProducts();
        this.getSoldItems(1);
        this.getReturnedProducts();
    },
};
</script>
