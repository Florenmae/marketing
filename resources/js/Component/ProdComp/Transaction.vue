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
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order ID
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Order Date
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
                                Total
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Balance
                            </th>
                            <th scope="col" class="relative px- py-2">
                                <span class="sr-only">View Details</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="order in orders" :key="order.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ order.id }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ order.created_at }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ order.quantity }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    Php {{ order.total.toFixed(2) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <span
                                        class="bg-green-500 px-2 py-1 rounded-md text-white my-1 text-sm hover:bg-green-600"
                                        v-if="order.balance === 0"
                                    >
                                        Paid
                                    </span>
                                    <span v-else>
                                        Php {{ order.balance.toFixed(2) }}
                                    </span>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                            >
                                <!-- <RouterLink to="/ViewOrder">
                                <button
                                    :order="order"
                                    class="bg-green-500 px-2 py-1 rounded-md text-white my-1 text-sm hover:bg-green-600"
                                >
                                    View Details
                                </button>
                            </RouterLink> -->

                                <viewOrder :order="order"></viewOrder>
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
                v-if="orders && orders.length === 0"
                class="text-gray-600 mt-4"
            >
                No orders available.
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
import View from "@/Component/PosComp/View.vue";

export default {
    props: ["order"],
    components: {
        Modal,
        ViewOrder,
        View,
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
        };
    },
    methods: {
        fetchOrders() {
            axios.get("/fetch-orders").then(({ data }) => {
                this.orders = data;
            });
        },
        toggleViewOrder() {
            this.showViewOrder = !this.showViewOrder; // Toggle the visibility of ViewOrder component
        },

        // viewOrder(order) {
        //     axios.get(`/view-order/${order.id}`).then((response) => {
        //         this.orderDetails = response.data;
        //     });
        // },
    },
    mounted() {
        this.fetchOrders();
        //this.viewOrder();
    },
};
</script>
