<template>
    <posLayout>
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-2">
                <label
                    for="id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Order Id</label
                >
                <input
                    v-model="orderProduct.id"
                    type="text"
                    name="id"
                    id="id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
    </posLayout>
</template>

<script>
import PosLayout from "../../Layout/PosLayout.vue";
export default {
    props: ["order"],
    components: {
        PosLayout,
    },
    data() {
        return {
            orderProduct: {
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
        printReceipt() {
            window.print();
        },

        viewOrder(orderId) {
            axios.get("/view-order", { orderId }).then((data) => {
                this.orderProduct = this.orderProduct;
            });
        },
    },

    mounted() {
        this.viewOrder();
    },
};
</script>
