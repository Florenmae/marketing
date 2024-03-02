<template>
    <button
        class="bg-blue-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-blue-600"
        @click="updateProduct"
    >
        Receive
    </button>
</template>

<script>
import Modal1 from "@/Component/Modal1.vue";
export default {
    props: ["product"],
    components: {
        Modal1,
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
                approved_by: "",
            },
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
        updateProduct() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct, status: 5 };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    prodPayload.approved_by = this.approved_by;
                    window.location.reload("Reloading");
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },
        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },
    },
    mounted() {
        this.getProducts();
    },
};
</script>
