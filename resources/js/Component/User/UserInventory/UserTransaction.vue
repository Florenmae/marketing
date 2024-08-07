<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="justify self-start mt-10 mb-4">
                <span
                    class="text-xl font-bold text-gray-700 dark:text-gray-300"
                >
                    Transaction List
                </span>
            </div>
            <div
                class="overflow-x-auto flex flex-col items-center border border-gray-300"
            >
                <table
                    class="w-full text-sm text-center text-gray-700 dark:text-gray-500"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Transaction No.
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
                                Received By
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
                            v-for="(transaction, id) in paginatedTransactions"
                            :key="id"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{
                                        getProductName(
                                            transaction.productlistId
                                        )
                                    }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ getUserRole(transaction.roleId) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{
                                        transaction.type === 2
                                            ? "Sales"
                                            : transaction.type
                                    }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.qty }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.created_at }}
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
                v-if="transactions && transactions.length === 0"
                class="text-center border border-t-0 w-full border-gray-200 p-4 text-gray-700 dark:text-gray-400"
            >
                No transaction recorded.
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
    props: ["transaction"],
    data() {
        return {
            transactions: [],
            productlists: [],
            loading: false,
            error: null,
            transactionDetails: this.transaction,
            transaction: {
                id: "",
                productlistId: "",
                supplierId: "",
                type: "",
                qty: "",
            },
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 10,
        };
    },
    methods: {
        fetchTransactions() {
            axios.get("/fetch-transactions").then(({ data }) => {
                this.transactions = data;
                this.pagination.lastPage = Math.ceil(
                    this.transactions.length / this.itemsPerPage
                );
            });
        },

        getUserRole(roleId) {
            switch (roleId) {
                case 1:
                    return "Admin";
                case 2:
                    return "IGP";
                case 3:
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
        this.fetchTransactions();
        this.getProductlists();
    },
    computed: {
        paginatedTransactions() {
            const startIndex =
                (this.pagination.currentPage - 1) * this.itemsPerPage;
            return this.transactions.slice(
                startIndex,
                startIndex + this.itemsPerPage
            );
        },
    },
};
</script>
