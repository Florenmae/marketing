<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="justify self-start mt-10 mb-4">
                <span class="text-xl font-bold text-gray-700 dark:text-gray-300"
                    >Order List</span
                >
            </div>
            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full justify-center items-center text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order ID
                            </th>
                            <th
                                scope="col"
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order Date
                            </th>
                            <th
                                scope="col"
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Quantity
                            </th>
                            <th
                                scope="col"
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Total
                            </th>
                            <th
                                scope="col"
                                class="justify text-center py-3 text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Balance
                            </th>
                            <th
                                scope="col"
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
                v-if="orders && orders.length === 0"
                class="text-gray-600 mt-4"
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
            itemsPerPage: 7,
        };
    },
    methods: {
        fetchOrders() {
            axios.get("/fetch-orders").then(({ data }) => {
                this.orders = data;
                this.pagination.lastPage = Math.ceil(
                    this.orders.length / this.itemsPerPage
                );
            });
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
            return this.orders.slice(startIndex, endIndex);
        },
    },
    mounted() {
        this.fetchOrders();
    },
};
</script>
