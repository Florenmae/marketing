<template>
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="bg-white p-8 rounded-md max-w-lg w-full">
            <h2 class="text-2xl font-semibold mb-4">Receipt</h2>
            <div v-if="receipt">
                <p class="mb-2">Payment Method: {{ receipt.paymentMethod }}</p>
                <p class="mb-2">Amount Given: Php {{ receipt.amountGiven }}</p>
                <p class="mb-4">Total Amount: Php {{ receipt.totalAmount }}</p>
                <ul>
                    <li
                        v-for="(item, index) in receipt.items"
                        :key="index"
                        class="mb-2"
                    >
                        <p>
                            {{ item.productName }} - Qty: {{ item.qty }} -
                            Total: Php {{ item.total }}
                        </p>
                    </li>
                </ul>
            </div>
            <div class="mt-6">
                <button
                    @click="closeModal"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md"
                >
                    Close
                </button>
                <button
                    @click="printReceipt"
                    class="ml-2 px-4 py-2 bg-green-500 text-white rounded-md"
                >
                    Print
                </button>
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
            print();
        },
    },
};
</script>
