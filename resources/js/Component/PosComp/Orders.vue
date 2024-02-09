<template>
    <posLayout>
        <div>
            <h2 class="text-lg font-semibold mb-4">Existing Orders</h2>
            <table class="min-w-full divide-y divide-gray-200">
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
                        <td
                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                            <!-- <button
                                @click="viewOrder(order)"
                                class="bg-green-500 px-2 py-1 rounded-md text-white my-1 text-sm hover:bg-green-600"
                            >
                                View Details
                            </button> -->
                            <ViewOrder :orders="ordes"></ViewOrder>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div
                v-if="orders && orders.length === 0"
                class="text-gray-600 mt-4"
            >
                No orders available.
            </div>
        </div>
    </posLayout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
export default {
    props: ["orders"],
    components: {
        Modal,
        ViewOrder,
    },
    data() {
        return {
            orders: [],
            loading: false,
            error: null,
        };
    },
    methods: {
        fetchOrders() {
            axios.get("/fetch-orders").then(({ data }) => {
                this.orders = data;
            });
        },

        viewOrder(order) {
            this.$emit("view-order-details", order);
        },
    },
    mounted() {
        this.fetchOrders();
    },
};
</script>
