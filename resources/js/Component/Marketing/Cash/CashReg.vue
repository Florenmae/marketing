<template>
    <Layout>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10 content-between w-full h-full"
        >
            <!-- Left Side: Cash On Hand Section -->
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg--50 w-full">
                        <div class="">
                            <label class="text-xl font-semibold"
                                >Cash On Hand</label
                            >
                        </div>
                    </div>
                    <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <div
                                class="justify-center items-center bg-white border border-green-400 sm:rounded-lg flex flex-col items-center w-full mt-4 mb-4"
                            >
                                <div
                                    class="p-6 flex flex-col items-center w-full"
                                >
                                    <div
                                        class="flex justify-between items-center w-full"
                                    >
                                        <div
                                            class="text-4xl leading-7 font-semibold"
                                        >
                                            <div class="pb-1">
                                                <div class="text-5xl font-bold">
                                                    {{ amount }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </table>
                        <div
                            class="flex flex-row items-center justify-center w-full"
                        >
                            <input
                                v-if="showInput && !cashAdded"
                                v-model="amount"
                                type="number"
                                class="border border-gray-300 rounded-md px-4 py-2 mr-2"
                                placeholder="Enter amount"
                            />
                            <button
                                v-if="showInput && !cashAdded"
                                @click="addCash"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 w-full rounded-md mr-2"
                            >
                                Add Cash
                            </button>
                            <button
                                @click="remitToAdmin"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 w-full rounded-md"
                            >
                                Remit To Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Cash Flow Logs Section -->
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg--50 w-full">
                        <div class="">
                            <label class="text-xl font-semibold"
                                >Cash Flow Logs</label
                            >
                        </div>
                    </div>
                    <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Transaction Id
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Inflow
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Outflow
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                                    >
                                        Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(cashlog, id) in cashlogs" :key="id">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        {{ cashlog.transactionId }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        {{ cashlog.inflow }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        {{ cashlog.outflow }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-center"
                                    >
                                        {{ cashlog.created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4">
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
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../../../Layout/Layout.vue";

export default {
    components: {
        Layout,
    },
    data() {
        return {
            amount: 0,
            newCash: 0,
            cashregs: [],
            showInput: true,
            cashAdded: false,
            cashlogs: [],
            cashlog: {
                transactionId: "",
                inflow: "",
                outflow: " ",
                created_at: " ",
            },
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
        };
    },
    methods: {
        getCash() {
            axios.get("/get-cash").then(({ data }) => {
                this.amount = data.amount;
            });
        },

        addCash() {
            const { amount } = this;
            axios.post("/add-cash", { amount }).then(({ data }) => {
                this.cashregs.push(data);
                this.showInput = false;
                this.cashAdded = true;
            });
        },

        remitToAdmin() {
            const { amount } = this;
            axios.post("/save-to-admin", { amount }).then(() => {
                this.amount = 0;
                this.showInput = true;
                this.cashAdded = false;
            });
        },

        getCashLogs(page) {
            axios.post(`/get-cashlogs?page=${page}`).then(({ data }) => {
                this.cashlogs = data.data;
                this.pagination = data.pagination;
            });
        },

        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.getCashLogs(this.pagination.currentPage - 1);
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.getCashLogs(this.pagination.currentPage + 1);
            }
        },
    },

    mounted() {
        this.getCash();
        this.getCashLogs(1);
    },
};
</script>
