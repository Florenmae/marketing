<template>
    <Modal>
        <div class="flex items-center justify-center">
            <div class="w-80 rounded bg-white px-6">
                <div class="flex flex-col justify-center items-center gap-2">
                    <h4 class="font-semibold">Marketing POS</h4>
                    <p class="text-xs">Mariano Marcos State Univerity</p>
                </div>
                <div class="flex flex-col gap-3 border-b py-6 text-xs">
                    <p class="flex justify-between">
                        <span class="text-gray-400">Receipt No.:</span>
                        <span>{{ orderProduct.id }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-400">Customer:</span>
                        <span>{{ orderProduct.customerId }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-400">Date:</span>
                        <span>{{ orderProduct.created_at }}</span>
                    </p>
                    <p class="flex justify-between">
                        <span class="text-gray-400">Payment:</span>
                        <span>{{ orderProduct.paymentMethod }}</span>
                    </p>
                </div>
                <div class="flex flex-col gap-3 pb-6 pt-2 text-xs">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="flex">
                                <th class="w-full py-2">Product</th>
                                <th class="min-w-[44px] py-2">QTY</th>
                                <th class="min-w-[44px] py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="flex">
                                <td class="flex-1 py-1">
                                    {{ orderProduct.productId }}
                                </td>
                                <td class="min-w-[44px]">
                                    {{ orderProduct.qty }}
                                </td>
                                <td class="min-w-[44px]">
                                    {{ orderProduct.price }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="border-b border border-dashed"></div>
                    <div class="flex flex-col gap-3 border-b py-6 text-xs">
                        <p class="flex justify-between">
                            <span class="text-gray-400">Total:</span>
                            <span>{{ orderProduct.total }}</span>
                        </p>
                        <p class="flex justify-between">
                            <span class="text-gray-400">Balance:</span>
                            <span>{{ orderProduct.balance }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import Receipt from "@/Component/PosComp/Receipt.vue";

export default {
    name: "ReceiptModal",
    props: {
        receipt: Object,
    },
    props: ["order"],
    components: {
        Modal,
        Receipt,
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
