<template>
    <Modal
        :modalContent="{
            title: 'Approve Product',
            content: 'Please check the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Approve'"
        :cancelLabel="'Close'"
        :saveLabel="'Approve'"
        @save="ApprovedProduct"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-2">
                <label
                    for="productId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product</label
                >
                <select
                    v-model="product.productId"
                    id="productId"
                    name="productId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                >
                    <option
                        v-for="product in products"
                        :key="product.productId"
                        :value="product.productId"
                    >
                        {{ product.productName }}
                    </option>
                </select>
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="supplierId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product supplier</label
                >
                <select
                    v-model="product.supplierId"
                    type="text"
                    name="supplierId"
                    id="supplierId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required=""
                >
                    <option selected>Choose a supplier</option>
                    <option value="2">IGP</option>
                    <option value="3">Project</option>
                </select>
            </div>
            <div class="col-span-2">
                <label
                    for="qty"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Quantity</label
                >
                <input
                    v-model="product.qty"
                    type="text"
                    name="qty"
                    id="qty"
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
                    v-model="product.approved_by"
                    type="text"
                    name="approved_by"
                    id="approved_by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-4">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Remarks</label
                >
                <textarea
                    v-model="product.description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
export default {
    props: ["approved_product"],
    components: {
        Modal,
    },
    data() {
        return {
            editingProductId: this.product.productId,
            product: {
                productId: "",
                supplierId: "",
                qty: "",
                description: "",
                status: 0,
                approved_by: "",
            },
        };
    },
    methods: {
        ApprovedProduct() {
            const { product, editingProductId } = this;
            const prodPayload = { ...product };

            axios
                .post("/approved-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    prodPayload.approved_by = this.approved_by;
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
