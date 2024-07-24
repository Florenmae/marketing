<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="flex mt-8 mb-2 items-center">
                <span
                    class="text-xl font-bold text-gray-700 dark:text-gray-300"
                >
                    Sales Report
                </span>
                <select
                    id="monthFilter"
                    class="mb-2 ml-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="selectedMonth"
                    @change="filterTransactions"
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
                v-if="filteredTransactions.length === 0"
                class="text-center border w-full border-gray-200 p-4 text-red-700 dark:text-red-400"
            >
                No transaction recorded for this month.
            </div>
            <div
                v-else
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
                                Total
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
                                    Php {{ transaction.totalprice }}.00
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
                v-if="selectedMonth"
                class="mt-2 mb-2 font-semibold text-gray-700 dark:text-gray-300"
            >
                Total Sales for the Month of {{ monthName }}: Php
                {{ totalSalesForMonth }}.00
            </div>
            <div
                class="mt-2 mb-2 font-semibold text-gray-700 dark:text-gray-300"
            >
                Overall Total Sales: Php {{ overallTotalSales }}.00
            </div>
            <div class="fixed bottom-4 right-4 w-full p-4 flex justify-end">
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
            filteredTransactions: [],
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
            itemsPerPage: 7,
            selectedMonth: "",
        };
    },
    methods: {
        fetchTransactions() {
            axios.get("/fetch-transactions").then(({ data }) => {
                this.transactions = data;
                this.filterTransactions();
            });
        },
        filterTransactions() {
            if (this.selectedMonth) {
                this.filteredTransactions = this.transactions.filter(
                    (transaction) => {
                        const month =
                            new Date(transaction.created_at).getMonth() + 1;
                        return month === parseInt(this.selectedMonth);
                    }
                );
            } else {
                this.filteredTransactions = this.transactions;
            }
            this.pagination.lastPage = Math.ceil(
                this.filteredTransactions.length / this.itemsPerPage
            );
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
            return this.filteredTransactions.slice(
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
        overallTotalSales() {
            return this.transactions.reduce(
                (total, transaction) => total + transaction.totalprice,
                0
            );
        },
        totalSalesForMonth() {
            return this.filteredTransactions.reduce(
                (total, transaction) => total + transaction.totalprice,
                0
            );
        },
    },
};
</script>
