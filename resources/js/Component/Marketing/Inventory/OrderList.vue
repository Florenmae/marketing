<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex mt-8 mb-2 items-center">
                <span
                    class="text-xl font-bold text-gray-700 dark:text-gray-300"
                >
                    Order List
                </span>
                <select
                    id="monthFilter"
                    class="mt-4 ml-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="selectedMonth"
                    @change="filterOrders"
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
                v-if="filteredOrders.length === 0"
                class="text-center border w-full border-gray-200 p-4 text-red-700 dark:text-red-400"
            >
                No transaction recorded for this month.
            </div>
            <div v-else class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full justify-center items-center text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order ID
                            </th>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order Date
                            </th>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Quantity
                            </th>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Total
                            </th>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Balance
                            </th>
                            <th
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        class="justify justify-center items-center bg-white divide-y divide-gray-200"
                    >
                        <tr v-for="order in paginatedOrders" :key="order.id">
                            <td
                                class="justify text-center py-3 whitespace-nowrap"
                            >
                                <div class="text-sm text-gray-900">
                                    {{ order.id }}
                                </div>
                            </td>
                            <td
                                class="justify text-center py-3 whitespace-nowrap"
                            >
                                <div class="text-sm text-gray-900">
                                    {{ order.created_at }}
                                </div>
                            </td>
                            <td
                                class="justify text-center py-3 whitespace-nowrap"
                            >
                                <div class="text-sm text-gray-900">
                                    {{ order.qty }}
                                </div>
                            </td>
                            <td
                                class="justify text-center py-3 whitespace-nowrap"
                            >
                                <div class="text-sm text-gray-900">
                                    Php {{ order.total.toFixed(2) }}
                                </div>
                            </td>
                            <td
                                class="justify text-center py-3 whitespace-nowrap"
                            >
                                <div class="text-sm text-gray-900">
                                    <span
                                        class="bg-green-500 px-2 py-1 rounded-md text-white my-1 text-sm hover:bg-green-600"
                                        v-if="order.balance === 0"
                                    >
                                        Paid
                                    </span>
                                    <span v-else>
                                        Php {{ order.balance }}.00
                                    </span>
                                </div>
                            </td>
                            <td
                                class="justify text-center py-2 whitespace-nowrap text-sm font-medium"
                            >
                                <viewOrder :order="order"></viewOrder>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="orders.length === 0"
                class="text-center text-yellow-600 mt-4"
            >
                No orders available.
            </div>
            <div class="fixed bottom-5 right-4 w-full p-3 flex justify-end">
                <Pagination
                    :current_page="pagination.currentPage"
                    :last_page="pagination.lastPage"
                    @next="nextPage"
                    @back="prevPage"
                />
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
import View from "@/Component/PosComp/View.vue";
import Pagination from "@/Component/Tools/Pagination.vue";

export default {
    props: ["order"],
    components: {
        Modal,
        ViewOrder,
        View,
        Pagination,
    },
    data() {
        return {
            showViewOrder: false,
            orders: [],
            filteredOrders: [], // Add filteredOrders data property
            loading: false,
            error: null,
            orderDetails: this.order,
            order: {
                id: "",
                name: "",
                description: "",
                price: "",
                quantity: "",
                total: "",
                paymentMethod: "",
                balance: "",
            },
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 6,
            selectedMonth: "", // Add selectedMonth data property
        };
    },
    methods: {
        fetchOrders() {
            axios.get("/fetch-orders").then(({ data }) => {
                this.orders = data;
                this.filteredOrders = data; // Initialize filteredOrders
                this.pagination.lastPage = Math.ceil(
                    this.filteredOrders.length / this.itemsPerPage
                );
            });
        },
        filterOrders() {
            if (this.selectedMonth) {
                this.filteredOrders = this.orders.filter((order) => {
                    const orderDate = new Date(order.created_at);
                    const month = orderDate.getMonth() + 1;
                    return month === parseInt(this.selectedMonth);
                });
            } else {
                this.filteredOrders = this.orders;
            }
            this.pagination.lastPage = Math.ceil(
                this.filteredOrders.length / this.itemsPerPage
            );
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
    computed: {
        paginatedOrders() {
            const startIndex =
                (this.pagination.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.filteredOrders.slice(startIndex, endIndex);
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
    mounted() {
        this.fetchOrders();
    },
};
</script>
