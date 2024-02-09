<template>
    <Modal
        :modalContent="{
            title: 'View Order Details',
            content: 'Please edit the product details',
            disablebtn: false,
        }"
        :buttonLabel="'View'"
        :cancelLabel="'Close'"
    >
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";

export default {
    components: {
        Modal,
    },
    props: ["orders"],
    data() {
        return {
            selectedOrder: null,
        };
    },
    methods: {
        viewOrder(order) {
            this.selectedOrder = order;
        },
    },
};
</script>
