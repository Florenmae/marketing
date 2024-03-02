<template>
    <button
        class="bg-blue-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-blue-600"
        @click="Deliver"
    >
        Deliver
    </button>
</template>

<script>
import Modal from "@/Component/Modal.vue";
export default {
    props: ["product"],
    components: {
        Modal,
    },
    data() {
        return {
            editingProductId: this.product.id,
            editProduct: {
                item_code: "",
                categoryId: "",
                name: "",
                userId: "",
                price: "",
                unit: "",
                qty: "",
                description: "",
                status: 0,
            },
            categories: [],
            submittedProducts: [],
        };
    },
    watch: {
        product: {
            handler(newVal) {
                this.editProduct = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        Deliver() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct, status: 4 };

            axios
                .post("/deliver", { prodPayload, editingProductId })
                .then(({ data }) => {
                    window.location.reload("Reloading");
                });
        },
        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
    },
    mounted() {
        this.getProducts();
        this.getCategories();
    },
};
</script>
