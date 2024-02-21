<template>
    <Modal1
        :modalContent="{
            title: 'Approve Product',
            content: 'Please check the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Approve'"
        :cancelLabel="'Close'"
        :saveLabel="'Approve'"
        @save="approvedProduct"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-2 border-red-500">
                <label
                    for="productName"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product Name</label
                >
                <input
                    v-model="approveProduct.productName"
                    type="text"
                    name="productName"
                    id="productName"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name"
                    required=""
                />
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="supplierId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product supplier</label
                >
                <select
                    v-model="approveProduct.supplierId"
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
                    for="price"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Price</label
                >
                <input
                    v-model="approveProduct.price"
                    type="text"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the product price"
                    name="price"
                    required=""
                />
            </div>
            <div class="col-span-2">
                <label
                    for="qty"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Quantity</label
                >
                <input
                    v-model="approveProduct.qty"
                    type="text"
                    name="qty"
                    id="qty"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Quantity"
                    required=""
                />
            </div>

            <div class="col-span-4">
                <label
                    for="approved_by"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Approved By:</label
                >
                <input
                    v-model="approveProduct.approved_by"
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
                    v-model="description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
    </Modal1>
</template>

<script>
import Modal1 from "@/Component/Modal.vue";
export default {
    props: ["approvedProduct"],
    components: {
        Modal1,
    },
    data() {
        return {
            editingApprovedProduct: this.approvedProduct
                ? this.approvedProduct.productId
                : "",
            approveProduct: {
                productId: this.approvedProduct
                    ? this.approvedProduct.productId
                    : "",
                productName: "",
                supplierId: "",
                qty: "",
                description: "",
                approved_by: "",
            },
        };
    },

    methods: {
        approvedProduct() {
            const { approveProduct, editingApprovedProduct } = this;
            const prodPayload = { ...approveProduct };

            axios
                .post("/approved-product", {
                    prodPayload,
                    editingApprovedProduct: editingApprovedProduct.productId, // Include productId
                })
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
        // this.approveProduct();
    },
};
</script>
