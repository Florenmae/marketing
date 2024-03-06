<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
                    >
                </div>
                <div><addProduct></addProduct></div>
            </div>

            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Item Code</th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Unit</th>
                            <th scope="col" class="px-6 py-3">Stocks</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-20 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in products"
                            :key="product.productId"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-20 h-20 rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ product.name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ getCategoryName(product.categoryId) }}
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.unit }}</td>
                            <td class="px-6 py-4">{{ product.stocks }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">
                                <p
                                    v-if="product.status === 1"
                                    class="px-2 py-2 font-medium text-gray-500 my-2 text-sm"
                                >
                                    Unlisted
                                </p>
                                <p
                                    v-if="product.status === 2"
                                    class="px-2 py-2 font-medium text-blue-500 my-2 text-sm"
                                >
                                    Pending
                                </p>
                                <p
                                    v-if="product.status === 3"
                                    class="px-2 py-2 font-medium text-green-500 my-2 text-sm"
                                >
                                    Approved
                                </p>
                                <p
                                    v-if="product.status === 4"
                                    class="px-2 py-2 font-medium text-green-500 my-2 text-sm"
                                >
                                    Returned
                                </p>
                            </td>
                            <td
                                class="space-x-2 px-6 py-6 flex justify-center items-center"
                            >
                                <button
                                    v-if="
                                        product.status !== 2 &&
                                        product.status !== 3 &&
                                        product.status !== 4 &&
                                        product.status !== 5 &&
                                        product.status !== 6
                                    "
                                >
                                    <SendToAdmin
                                        :product="product"
                                        @productSubmitted="
                                            productSubmittedHandler
                                        "
                                    />
                                </button>
                                <!-- <button
                                    v-if="product.status === 3"
                                    class="bg-blue-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-blue-600"
                                    @click="deliverProduct(product)"
                                >
                                    Deliver
                                </button> -->
                                <button v-if="product.status === 3">
                                    <Deliver
                                        :product="product"
                                        @productSubmitted="
                                            productSubmittedHandler
                                        "
                                    ></Deliver>
                                </button>
                                <button
                                    class="bg-red-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-red-600"
                                    @click="promptDelete(product)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </userLayout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import addProduct from "@/Component/User/UserInventory/addProduct.vue";
import SendToAdmin from "@/Component/User/UserInventory/SendToAdmin.vue";
import Deliver from "@/Component/User/UserInventory/Deliver.vue";

import axios from "axios";
import UserLayout from "../../../Layout/userLayout.vue";
export default {
    components: {
        Modal,
        addProduct,
        UserLayout,
        SendToAdmin,
        Deliver,
    },
    data() {
        return {
            product: {
                categoryName: "",
                item_code: "",
                productId: "",
                name: "",
                supplier: "",
                price: "",
                qty: "",
                description: "",
                status: "",
            },
            products: [],
            inventories: [],
            categories: [],
            editingProductId: null,
            modalStatus: false,
        };
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getProducts() {
            axios.get("/get-productsUser").then(({ data }) => {
                this.products = data;
            });
        },
        getInventories() {
            axios.get("/get-inventory").then(({ data }) => {
                this.inventories = data;
            });
        },
        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
            this.getProducts;
        },

        updateProduct(data) {
            const { product, editingProductId } = this;
            const prodPayload = { ...product };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProducts;
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },

        promptDelete(product) {
            const confirmed = confirm(
                "Are you sure you want to delete this user?"
            );
            if (confirmed) {
                this.deleteProduct(product.productId);
            }
        },

        deliverProduct(product) {
            axios.post("/deliver", { id: product.id }).then(({ data }) => {
                this.getProducts();
            });
        },

        deleteProduct(productId) {
            axios.post("/delete-product", { productId }).then(({ data }) => {
                this.getProducts();
            });
        },
        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },
    },

    mounted() {
        this.getProducts();
        this.getCategories();
        this.getInventories();
    },
};
</script>
