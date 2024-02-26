<template>
    <Modal
        :modalContent="{
            title: 'Order Details',
            disablebtn: true,
        }"
        :buttonLabel="'View '"
        :cancelLabel="'Close'"
        :saveLabel="'Print'"
        :save-option="false"
        @save="printReceipt"
    >
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
            <div class="col-span-2">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Name</label
                >
                <input
                    v-model="orderProduct.name"
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Description</label
                >
                <input
                    v-model="orderProduct.description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="price"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Price</label
                >
                <input
                    v-model="orderProduct.price"
                    type="text"
                    name="price"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="quantity"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Quantity</label
                >
                <input
                    v-model="orderProduct.quantity"
                    type="text"
                    name="quantity"
                    id="quantity"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="total"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Total</label
                >
                <input
                    v-model="orderProduct.total"
                    name="total"
                    id="total"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="paymentMethod"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Payment Method</label
                >
                <input
                    v-model="orderProduct.paymentMethod"
                    name="paymentMethod"
                    id="paymentMethod"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="balance"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                    >Balance</label
                >
                <input
                    v-model="orderProduct.balance"
                    name="balance"
                    id="balance"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <!-- <div class="col-span-2">
                <label
                    for="image"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white text-left"
                >
                    Image
                </label>
                <img
                    :src="orderProduct.image"
                    alt="Product Image"
                    class="w-full h-auto mb-2 rounded-lg"
                />
            </div> -->
        </div>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";

export default {
    props: ["order"],
    components: {
        Modal,
    },
    data() {
        return {
            orderProduct: this.order,
        };
    },
    methods: {
        printReceipt() {
            window.print();
        },
    },
};
</script>
