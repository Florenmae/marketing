<template>
    <Modal1
        :modalContent="{
            title: 'Approve product',
            content: 'Please edit the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Approve'"
        :cancelLabel="'Close'"
        :saveLabel="'Approve'"
        @save="approveProduct"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-4">
                <label
                    for="type"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Transaction Type:</label
                >
                <select
                    v-model="editProduct.type"
                    id="type"
                    name="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                >
                    <option value="">Select a Transaction Type</option>
                    <option value="1">Beginning Inventory</option>
                    <option value="2">Sales</option>
                    <option value="3">Delivery</option>
                    <option value="4">Return</option>
                </select>
            </div>
            <div class="col-span-4">
                <label
                    for="actualQty"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Actual Quantity:</label
                >
                <input
                    v-model="editProduct.actualQty"
                    type="number"
                    name="actualQty"
                    id="actualQty"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-4">
                <label
                    for="approved_by"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Approved By:</label
                >
                <input
                    v-model="editProduct.approved_by"
                    type="text"
                    name="approved_by"
                    id="approved_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
    </Modal1>
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
                type: "",
                actualQty: "",
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
        approveProduct() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct, status: 3 };

            axios
                .post("/approve-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    prodPayload.type = this.type;
                    prodPayload.actualQty = this.actualQty;
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
