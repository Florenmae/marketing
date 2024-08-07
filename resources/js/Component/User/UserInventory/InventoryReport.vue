<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="flex mt-8 mb-2 items-center">
                <span
                    class="text-xl font-bold text-gray-700 dark:text-gray-300"
                >
                    Inventory Report
                </span>
                <select
                    id="monthFilter"
                    class="mb-2 ml-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="selectedMonth"
                    @change="filterInventories"
                    required
                >
                    <option value="" selected>Choose a month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div
                v-if="selectedMonth"
                class="mb-2 text-gray-700 dark:text-gray-300"
            >
                Showing results for: {{ monthName }}
            </div>
            <div
                v-if="filteredInventories.length === 0"
                class="text-center border w-full border-gray-200 p-4 text-red-700 dark:text-red-400"
            >
                No transaction recorded for this month.
            </div>
            <div
                v-else
                class="overflow-x-auto flex flex-col items-center border border-gray-300"
            >
                <table
                    class="w-full text-sm text-center text-gray-500 dark:text-gray-400"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Inventory Id
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Product
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Category
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Item Code
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Type
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Quantity
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Date
                            </th>
                            <th scope="col" class="relative px- py-2">
                                <span class="sr-only">View Details</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="(inventory, id) in paginatedInventories"
                            :key="id"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ inventory.id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{
                                        getProductName(inventory.productlistId)
                                    }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ getCategory(inventory.categoryId) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ getUserRole(inventory.userId) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ inventory.item_code }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ inventory.stocks }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ formatCreatedAt(inventory.created_at) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="inventories && inventories.length === 0"
                class="text-gray-600 mt-4"
            >
                No Inventory recorded.
            </div>
            <div class="fixed bottom-4 right-4 p-4 flex justify-end">
                <Pagination
                    :current_page="pagination.currentPage"
                    :last_page="pagination.lastPage"
                    @next="nextPage"
                    @back="prevPage"
                />
            </div>
        </div>
    </userLayout>
</template>
<script>
import Pagination from "@/Component/Tools/Pagination.vue";
import moment from "moment";
import axios from "axios";

export default {
    components: {
        Pagination,
    },
    data() {
        return {
            inventories: [],
            filteredInventories: [],
            loading: false,
            error: null,
            productlists: [],
            categories: [],
            inventoryDetails: this.inventory,
            inventory: {
                id: "",
                productId: "",
                productlistId: "",
                categoryId: "",
                userId: "",
                item_Code: "",
                image: "",
                unit: "",
                stocks: "",
            },
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 7,
            selectedMonth: "",
        };
    },
    methods: {
        fetchInventories() {
            axios.get("/fetch-inventories").then(({ data }) => {
                this.inventories = data;
                this.filteredInventories = data;
                this.pagination.lastPage = Math.ceil(
                    this.filteredInventories.length / this.itemsPerPage
                );
            });
        },
        filterInventories() {
            if (this.selectedMonth) {
                this.filteredInventories = this.inventories.filter(
                    (inventory) => {
                        const month =
                            new Date(inventory.created_at).getMonth() + 1;
                        return month === parseInt(this.selectedMonth);
                    }
                );
            } else {
                this.filteredInventories = this.inventories;
            }
            this.pagination.lastPage = Math.ceil(
                this.filteredInventories.length / this.itemsPerPage
            );
        },
        getUserRole(userId) {
            switch (userId) {
                case 1:
                    return "admin";
                case 2:
                    return "IGP";
                case 3:
                    return "Project";
                default:
                    return "Unknown";
            }
        },
        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
        getCategory(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown category";
        },
        getProductlists() {
            axios.get("/get-productlists").then(({ data }) => {
                this.productlists = data;
            });
        },
        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (d) => d.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },
        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.pagination.currentPage--;
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.pagination.currentPage++;
            }
        },
        formatCreatedAt(date) {
            return moment(date).format("MMMM D, YYYY");
        },
    },
    mounted() {
        this.fetchInventories();
        this.getProductlists();
        this.getCategories();
    },
    computed: {
        paginatedInventories() {
            const startIndex =
                (this.pagination.currentPage - 1) * this.itemsPerPage;
            return this.filteredInventories.slice(
                startIndex,
                startIndex + this.itemsPerPage
            );
        },
        monthName() {
            const monthNames = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            return this.selectedMonth ? monthNames[this.selectedMonth - 1] : "";
        },
    },
    watch: {
        selectedMonth() {
            this.filterInventories();
        },
    },
};
</script>
