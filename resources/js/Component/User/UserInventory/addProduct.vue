<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add Product'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitProduct"
        :save-option="true"
    >
        <form @submit.prevent="submitProduct" class="md:p-2">
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

                <!-- <div class="col-span-2">
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
                </div> -->
                <div class="col-span-2">
                    <label
                        for="productlistId"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Product Name</label
                    >
                    <select
                        v-model="product.productlistId"
                        id="productlistId"
                        name="productlistId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required
                    >
                        <option value="">Select a Product</option>
                        <option
                            v-for="productList in productLists"
                            :key="productList.id"
                            :value="productList.id"
                        >
                            {{ productList.name }}
                        </option>
                    </select>
                </div>

                <!-- <div class="col-span-2">
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
                </div> -->

                <div class="col-span-2">
                    <label
                        for="unit"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Unit</label
                    >
                    <select
                        v-model="product.unit"
                        type="text"
                        name="unit"
                        id="unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Choose Product Unit"
                    >
                        <option value="kl">kl</option>
                        <option value="pc">pc</option>
                        <option value="gram">gram</option>
                    </select>
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
                    ></textarea>
                </div>
            </div>
        </form>
        <Toast />
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import Toast from "primevue/toast";

export default {
    props: ["product"],
    components: {
        Modal,
        Toast,
    },
    data() {
        return {
            editingProductId: null,
            product: {
                image: null,
                item_code: "",
                categoryId: "",
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
            axios.get("/getproductlists").then(({ data }) => {
                this.productLists = data;
            });
        },

        submitProduct() {
            const { product } = this;
            const prodPayload = {
                ...product,
            };

            axios
                .post("/submit-product", prodPayload)
                .then(({ data }) => {
                    this.getProducts();
                    // window.location.reload("Reloading");
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Created product successfully",
                        life: 4000,
                    });
                })
                .catch((error) => {
                    console.error("Error submitting to admin:", error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to create product",
                        life: 4000,
                    });
                });
        },

        // handleImageUpload(event) {
        //     const formData = new FormData();
        //     formData.append("image", event.target.files[0]);

        //     axios
        //         .post("/upload-image", formData, {
        //             headers: {
        //                 "Content-Type": "multipart/form-data",
        //             },
        //         })
        //         .then((response) => {
        //             this.product.image = response.data.imagePath;
        //         });
        // },
    },
    mounted() {
        this.getProducts();
        this.getCategories();
        this.getProductList();
    },
};
</script>
