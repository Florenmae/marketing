<template>
    <Modal
        :modalContent="{
            title: 'Submit product',
            content: 'Please check the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Submit'"
        :cancelLabel="'Close'"
        :saveLabel="'Submit'"
        @save="submitToAdmin"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-2">
                <label
                    for="categoryId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Category</label
                >
                <select
                    v-model="product.categoryId"
                    id="categoryId"
                    name="categoryId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                >
                    <option value="">Select a category</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <div class="col-span-2">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Item Code</label
                >
                <input
                    v-model="editProduct.item_code"
                    type="text"
                    name="item_code"
                    id="item_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the item code"
                    required=""
                />
            </div>
            <div class="col-span-2">
                <label
                    for="productId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product Name</label
                >
                <select
                    v-model="editProduct.productId"
                    id="productId"
                    name="productId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                >
                    <option value="">Select a product</option>
                    <option
                        v-for="productList in productLists"
                        :key="productList.productId"
                        :value="productList.productId"
                    >
                        {{ productList.name }}
                    </option>
                </select>
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="userId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product supplier</label
                >
                <select
                    v-model="editProduct.userId"
                    type="text"
                    name="userId"
                    id="userId"
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
                    v-model="editProduct.price"
                    type="number"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the product price"
                    name="price"
                    required=""
                />
            </div>
            <div class="col-span-2">
                <label
                    for="unit"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >unit</label
                >
                <input
                    v-model="editProduct.unit"
                    type="text"
                    id="unit"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Select Product Unit"
                    name="unit"
                    required=""
                />
            </div>
            <div class="col-span-4">
                <label
                    for="qty"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Quantity</label
                >
                <input
                    v-model="editProduct.stocks"
                    type="number"
                    name="qty"
                    id="qty"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Quantity"
                    required=""
                />
            </div>
            <div class="col-span-4">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Description</label
                >
                <textarea
                    v-model="editProduct.description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Description"
                    required=""
                ></textarea>
            </div>
        </div>
    </Modal>
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
        submitToAdmin() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct, status: 2 };

            axios
                .post("/submitToAdmin", { prodPayload, editingProductId })
                .then(({ data }) => {
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

        getProductList() {
            axios.get("/get-product-lists").then(({ data }) => {
                this.productLists = data;
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
        this.getProductList();
    },
};
</script>
