<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="justify self-start mt-10 mb-4">
                <span class="text-xl font-bold text-gray-700 dark:text-gray-300"
                    >Transaction List</span
                >
            </div>
            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Transaction No.
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Supplier
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Product
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Type
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
                            <th scope="col" class="relative px- py-2">
                                <span class="sr-only">View Details</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr
                            v-for="transaction in transactions"
                            :key="transaction.id"
                        >
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.userId }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.productId }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ transaction.type }}
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
                                <!-- <viewOrder :transaction="transaction"></viewOrder> -->
                                <!-- <router-link
                                :to="'/view'"
                                class="bg-green-500 px-2 py-1 rounded-md text-white my-1 text-sm hover:bg-green-600"
                            >
                                View Order
                            </router-link> -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="transactions && transactions.length === 0"
                class="text-gray-600 mt-4"
            >
                No transaction recorded.
            </div>
        </div>
    </Layout>
</template>

<script>
export default {
    props: ["transaction"],
    data() {
        return {
            transactions: [],
            loading: false,
            error: null,
            transactionDetails: this.transaction,
            transaction: {
                id: "",
                productId: "",
                supplierId: "",
                type: "",
                qty: "",
            },
        };
    },
    methods: {
        fetchTransactions() {
            axios.get("/fetch-transactions").then(({ data }) => {
                this.transactions = data;
            });
        },
    },
    mounted() {
        this.fetchTransactions();
    },
};
</script>
