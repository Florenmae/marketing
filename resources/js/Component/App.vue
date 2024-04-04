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
        <!-- <BarGraph /> -->
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
            axios
                .get("/recent-products")
                .then((response) => {
                    this.recentProducts = response.data.recentProducts;
                })
                .catch((error) => {
                    console.error("Error fetching recent items:", error);
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
    },
};
</script>
