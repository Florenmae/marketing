<template>
    <userLayout>
        <div
            class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-10 content-between w-full"
        >
            <div
                class="bg-red-400 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ salesCount }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Sales</label>
                            </div>
                        </div>
                        <img
                            src="../../../public/sales.png"
                            class="w-10 h-10 filter brightness-0 invert"
                        />
                    </div>
                </div>
            </div>
            <div
                class="bg-blue-300 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-3xl leading-7 font-semibold">
                            <span>{{ totalSoldAmount }}.00</span>
                            <div class="pb-1">
                                <label class="text-sm">Total Sales</label>
                            </div>
                        </div>
                        <i
                            class="pi pi-shopping-bag"
                            style="font-size: 2.5rem"
                        ></i>
                    </div>
                </div>
            </div>
            <div
                class="bg-blue-900 text-white overflow-hidden shadow-md sm:rounded-lg flex flex-col items-center w-full"
            >
                <div class="p-4 flex flex-col items-center w-full">
                    <div class="flex justify-between items-center w-full">
                        <div class="text-4xl leading-7 font-semibold">
                            <span>{{ productCount }}</span>
                            <div class="pb-1">
                                <label class="text-sm">Products</label>
                            </div>
                        </div>
                        <i
                            class="pi pi-objects-column"
                            style="font-size: 2.5rem"
                        ></i>
                    </div>
                </div>
            </div>
            <!-- <div
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
                        <i
                            class="pi pi-objects-column"
                            style="font-size: 2.5rem"
                        ></i>
                    </div>
                </div>
            </div> -->
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
                        <img
                            src="../../../public/return.png"
                            class="w-11 h-11 filter brightness-0 invert"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6 content-between w-full h-full"
        >
            <!-- <SalesReport></SalesReport> -->
            <div
                class="rounded-lg border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="border border-gray-200 bg-gray-50 w-full">
                        <label
                            class="px-4 text-left text-sm font-semibold text-black-500 uppercase tracking-wider"
                            >Sold Items</label
                        >
                    </div>
                    <div v-if="soldItems.length > 0" class="w-full">
                        <table
                            class="border border-t-0 border-gray-200 min-w-full divide-y divide-gray-200"
                        >
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
                                    v-for="(soldItem, id) in paginatedSoldItems"
                                    :key="id"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{
                                            getProductName(
                                                soldItem.productlistId
                                            )
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ soldItem.actualQty }}
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

                            <div class="flex justify-end">
                                <Pagination
                                    :current_page="
                                        solditemsPagination.currentPage
                                    "
                                    :last_page="solditemsPagination.lastPage"
                                    @next="nextPage"
                                    @back="prevPage"
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        v-else
                        class="text-center border border-t-0 w-full border-gray-200 p-4 text-gray-700 dark:text-gray-400"
                    >
                        No sold items to display.
                    </div>
                </div>
            </div>
            <div
                class="rounded-lg border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="border border-gray-200 bg-gray-50 w-full">
                        <label
                            class="px-4 text-left text-sm font-semibold text-black-500 uppercase tracking-wider"
                            >Returned Products</label
                        >
                    </div>
                    <div v-if="returnedProducts.length > 0" class="w-full">
                        <table
                            class="border border-t-0 border-gray-200 min-w-full divide-y divide-gray-200"
                        >
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
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr
                                    v-for="(
                                        returnedProduct, id
                                    ) in paginatedReturns"
                                    :key="id"
                                >
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{
                                            getProductName(
                                                returnedProduct.productlistId
                                            )
                                        }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ returnedProduct.qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{
                                            formatDate(
                                                returnedProduct.created_at
                                            )
                                        }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- <div
                            v-if="returnedProducts.length === 0"
                            class="text-center border border-gray-200 p-4 text-gray-700 dark:text-gray-400"
                        >
                            No Returned Products Recorded.
                        </div> -->
                        <div class="mt-6 flex justify-end">
                            <Pagination
                                :current_page="returnPagination.currentPage"
                                :last_page="returnPagination.lastPage"
                                @next="nextReturnPage"
                                @back="prevReturnPage"
                            />
                        </div>
                    </div>
                    <div
                        v-else
                        class="text-center border w-full border-t-0 border-gray-200 p-4 text-gray-700 dark:text-gray-400"
                    >
                        No Returned Products Recorded.
                    </div>
                </div>
            </div>
        </div>
    </userLayout>
</template>

<script>
import userLayout from "../Layout/userLayout.vue";
import Modal from "../Component/Modal.vue";
import moment from "moment";

export default {
    components: {
        userLayout,
        Modal,
        moment,
    },
    data() {
        return {
            authenticated: 0,
            userCounts: null,
            productCount: null,
            categoryCount: null,
            returnCount: null,
            salesCount: null,
            recentProducts: null,
            soldItems: [],
            productlists: [],
            totalSoldAmount: 0,
            returnedProducts: [],
            solditemsPagination: {
                currentPage: 1,
                lastPage: 1,
            },
            returnPagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 5,
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
                this.productCount = response.data.count;
            });
        },

        getCategoryCount() {
            axios.get("/get-category-count").then((response) => {
                this.categoryCount = response.data.count;
            });
        },

        getReturnCount() {
            axios.get("/get-return-count").then((response) => {
                this.returnCount = response.data.count;
            });
        },
        getSalesCount() {
            axios.get("/get-sales-count").then((response) => {
                this.salesCount = response.data.count;
            });
        },

        getRecentProducts() {
            axios.get("/recent-products").then((response) => {
                this.recentProducts = response.data.recentProducts;
            });
        },
        getSoldItems() {
            axios.get("/get-sold-items").then((data) => {
                this.soldItems = data.data.soldItems;
                this.totalSoldAmount = data.data.totalSoldAmount;
                this.solditemsPagination.lastPage = Math.ceil(
                    this.soldItems.length / this.itemsPerPage
                );
            });
        },

        prevPage() {
            if (this.solditemsPagination.currentPage > 1) {
                this.solditemsPagination.currentPage--;
            }
        },

        nextPage() {
            if (
                this.solditemsPagination.currentPage <
                this.solditemsPagination.lastPage
            ) {
                this.solditemsPagination.currentPage++;
            }
        },

        getReturnedProducts() {
            axios.get("/get-returns").then(({ data }) => {
                this.returnedProducts = data;
                this.returnPagination.lastPage = Math.ceil(
                    this.returnedProducts.length / this.itemsPerPage
                );
            });
        },

        prevReturnPage() {
            if (this.returnPagination.currentPage > 1) {
                this.returnPagination.currentPage--;
            }
        },

        nextReturnPage() {
            if (
                this.returnPagination.currentPage <
                this.returnPagination.lastPage
            ) {
                this.returnPagination.currentPage++;
            }
        },
        formatDate(date) {
            return moment(date).format("MMMM D, YYYY");
        },

        getProductlists() {
            axios.get("/get-productlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (b) => b.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },
    },
    mounted() {
        this.checkAuth();
        this.getUserCount();
        this.getProductCount();
        this.getCategoryCount();
        this.getReturnCount();
        this.getSalesCount();
        this.getRecentProducts();
        this.getSoldItems(1);
        this.getReturnedProducts(1);
        this.getProductlists();
    },

    computed: {
        paginatedSoldItems() {
            const startIndex =
                (this.solditemsPagination.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.soldItems.slice(startIndex, endIndex);
        },
        paginatedReturns() {
            const startIndex =
                (this.returnPagination.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.returnedProducts.slice(startIndex, endIndex);
        },
    },
};
</script>
