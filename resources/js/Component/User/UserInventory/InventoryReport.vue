<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="justify self-start mt-10 mb-4">
                <span
                    class="text-xl font-bold text-gray-700 dark:text-gray-300"
                >
                    Inventory List
                </span>
            </div>
            <div
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
            <div
                class="fixed bottom-4 right-4 p-4 flex justify-end"
            >
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

export default {
    components: {
        Pagination,
    },

    data() {
        return {
            inventories: [],
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
            itemsPerPage: 10,
        };
    },
    methods: {
        fetchInventories() {
            axios.get("/fetch-inventories").then(({ data }) => {
                this.inventories = data;
                this.pagination.lastPage = Math.ceil(
                    this.inventories.length / this.itemsPerPage
                );
            });
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
            return this.inventories.slice(
                startIndex,
                startIndex + this.itemsPerPage
            );
        },
    },
};
</script>
