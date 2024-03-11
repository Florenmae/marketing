<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add Product'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitProduct"
        :save-option="true"
    >
        <form @submit.prevent="submitProduct" class="p-4 md:p-5">
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
                        v-model="product.item_code"
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
                        v-model="product.productId"
                        id="productId"
                        name="productId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required
                    >
                        <option value="">Select a product</option>
                        <option
                            v-for="productList in productLists"
                            :key="productList.id"
                            :value="productList.id"
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
                        v-model="product.userId"
                        type="text"
                        name="userId"
                        id="userId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Choose Supplier"
                    >
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
                        v-model="product.price"
                        type="number"
                        name="price"
                        id="price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the product price"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="unit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Unit</label
                    >
                    <input
                        v-model="product.unit"
                        type="text"
                        name="unit"
                        id="unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Select Product Unit"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="stocks"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Quantity</label
                    >
                    <input
                        v-model="product.stocks"
                        type="number"
                        name="stocks"
                        id="stocks"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Product Quantity"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="image"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Image</label
                    >
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        @change="handleImageUpload"
                        accept="image/*"
                        required
                    />
                </div>
                <div class="col-span-4">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <textarea
                        v-model="product.description"
                        type="text"
                        name="description"
                        id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Product Details"
                        required=""
                    />
                </div>
            </div>
        </form>
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
            editingProductId: null,
            product: {
                image: null,
                item_code: "",
                categoryId: "",
                productId: "",
                userId: "",
                price: "",
                unit: "",
                stocks: "",
                description: "",
            },
            productLists: [],
            categories: [],
            selectedCategoryId: null,
            modalContent: {
                title: "Create New Product",
                content: "Please fill in the product details",
                disablebtn: false,
            },
        };
    },
    methods: {
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

        getProductList() {
            axios.get("/get-product-lists").then(({ data }) => {
                this.productLists = data;
            });
        },

        submitProduct() {
            const { product } = this;
            const prodPayload = {
                ...product,
            };

            axios.post("/submit-product", prodPayload).then(({ data }) => {
                this.getProducts();
                window.location.reload("Reloading");
            });
        },

        handleImageUpload(event) {
            const formData = new FormData();
            formData.append("image", event.target.files[0]);

            axios
                .post("/upload-image", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.product.image = response.data.imagePath;
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
