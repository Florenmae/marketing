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
                                    {{ getUserRole(inventory.roleId) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{
                                        inventory.type === 2
                                            ? "Sales"
                                            : inventory.type
                                    }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ inventory.stocks }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ inventory.created_at }}
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <!-- View Order button or link can go here -->
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
                class="fixed bottom-6 right-4 w-full bg-white p-4 flex justify-end"
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

export default {
    components: {
        Pagination,
    },
    props: ["inventory"],
    data() {
        return {
            inventories: [],
            loading: false,
            error: null,
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
                    return "IGP";
                case 2:
                    return "Project";
                default:
                    return "Unknown";
            }
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
    },
    mounted() {
        this.fetchInventories();
        this.getProductlists();
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
