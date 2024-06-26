<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="mt-4 flex items-center justify-center">
            <div class="w-80 rounded bg-white px-6">
                <img
                    src="../../../../public/mmsu_logo.png"
                    class="mt-4 mx-auto w-10"
                />
                <div
                    class="mt-2 flex flex-col justify-center items-center gap-2"
                >
                    <h4 class="font-semibold">Marketing POS</h4>
                    <p class="text-xs">Mariano Marcos State University</p>
                </div>
                <div class="flex flex-col gap-2 border-b py-6 text-xs">
                    <div v-if="receipt">
                        <p class="flex justify-between">
                            <span class="text-gray-400">Customer:</span>
                            <span>{{ receipt.customerId }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-400">Date:</span>
                            <span>{{ receipt.created_at }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-400">Payment:</span>
                            <span>{{ receipt.paymentMethod }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-400">Amount:</span>
                            <span>{{ receipt.amountGiven }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-400">Change:</span>
                            <span>{{ receipt.change }}</span>
                        </p>
                    </div>

                    <table class="w-full text-left mt-2">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">Product</th>
                                <th class="py-2">QTY</th>
                                <th class="py-2">Price</th>
                                <th class="py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(item, index) in receipt.items"
                                :key="index"
                            >
                                <td class="py-1">{{ item.productName }}</td>
                                <td class="py-1">{{ item.qty }}</td>
                                <td class="py-1">Php {{ item.price }}</td>
                                <td class="py-1">Php {{ item.total }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <div class="flex justify-between mt-4">
                        <div>
                            <p class="text-gray-400">Total:</p>
                            <p class="font-semibold">
                                Php {{ receipt.totalAmount }}
                            </p>
                        </div>
                    </div> -->
                </div>
                <div class="mt-4 flex items-center justify-center">
                    <button
                        @click="closeModal"
                        class="ml-2 px-4 py-1 bg-gray-300 text-gray-700 rounded-md mb-4"
                    >
                        Close
                    </button>
                    <button
                        @click="printReceipt"
                        class="ml-2 px-4 py-1 bg-green-500 text-white rounded-md mb-4"
                    >
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        receipt: {
            type: Object,
            required: true,
        },
    },
    methods: {
        closeModal() {
            this.$emit("close");
        },
        printReceipt() {
            window.print();
        },
    },
};
</script>
