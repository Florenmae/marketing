<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Pending Products</span
                    >
                </div>
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
                            <th scope="col" class="px-6 py-3">
                                Product Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">
                                Stocks Available
                            </th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-20 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in pendingProducts"
                            :key="product.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-34 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ product.name }}
                            </th>
                            <td class="px-6 py-4">
                                <p>{{ getCategoryName(product.categoryId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>

                            <td class="px-6 py-4">
                                <p>{{ getSupplierName(product.userId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.stocks }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <editProduct :product="product" />
                                <Approve :product="product" />
                                <button
                                    class="bg-red-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-green-600"
                                    @click="returnAll(product)"
                                >
                                    Return
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Out For Delivery</span
                    >
                </div>
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
                            <th scope="col" class="px-6 py-3">
                                Product Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">
                                Stocks Availabel
                            </th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-20 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in outForDelivery"
                            :key="product.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-34 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ product.name }}
                            </th>
                            <td class="px-6 py-4">
                                <p>{{ getCategoryName(product.categoryId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>

                            <td class="px-6 py-4">
                                <p>{{ getSupplierName(product.userId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.stocks }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <!-- <editProduct :product="product" /> -->
                                <!-- <button
                                    class="bg-blue-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-blue-600"
                                    @click="updateProduct"
                                >
                                    Receive
                                </button> -->
                                <Receive :product="product" />
                                <Return :product="product" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editProduct from "@/Component/Marketing/inventory/editProduct.vue";
import Approve from "@/Component/Marketing/inventory/Approve.vue";
import Return from "@/Component/Marketing/inventory/Return.vue";
import Receive from "@/Component/Marketing/inventory/Receive.vue";

import axios from "axios";

export default {
    props: ["product"],
    components: {
        Modal,
        editProduct,
        Approve,
        Return,
        Receive,
    },
    data() {
        return {
            pendingProducts: [],
            approvedProducts: [],
            outForDelivery: [],
            editProduct: {
                item_code: "",
                name: "",
                userId: "",
                price: "",
                stocks: "",
                description: "",
                status: 0,
            },
            users: [],
            products: [],
            categories: [],
            editingProductId: null,
            modalStatus: false,
            roles: [],
        };
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },

        // getPendingProducts() {
        //     axios.get("/get-products?status=0").then(({ data }) => {
        //         this.pendingProducts = data;
        //     });
        // },
        // getApprovedProducts() {
        //     axios.get("/get-products?status=1").then(({ data }) => {
        //         this.approvedProducts = data;
        //     });
        // },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },

        getUsers() {
            axios.get("/get-users").then(({ data }) => {
                this.users = data;
            });
        },

        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
        },

        returnAll(product) {
            axios
                .post("/returnAll-product", { product })
                .then(({ data }) => {
                    window.location.reload("Reloading");
                })
                .catch((error) => {
                    console.error("Error returning all products:", error);
                });
        },

        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },

        getSupplierName(userId) {
            userId = Number(userId);
            const user = this.users.find((user) => user.id === userId);
            return user ? user.name : "Unknown User";
        },
    },
    computed: {
        pendingProducts() {
            return this.products.filter((product) => product.status === 2);
        },
        approvedProducts() {
            return this.products.filter((product) => product.status === 3);
        },
        outForDelivery() {
            return this.products.filter((product) => product.status === 4);
        },
        receivedProduct() {
            return this.products.filter((product) => product.status === 5);
        },
    },
    mounted() {
        this.getProducts();
        // this.getApprovedProducts();
        // this.getPendingProducts();
        this.getCategories();
        this.getUsers();
    },
};
</script>
