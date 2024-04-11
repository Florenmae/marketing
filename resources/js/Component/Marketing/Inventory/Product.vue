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
                            <th scope="col" class="px-6 py-3">Quantity</th>
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
                                    class="w-20 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ getProductName(product.productId) }}
                            </th>
                            <td class="px-6 py-4">
                                <p>{{ getCategoryName(product.categoryId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>

                            <td class="px-6 py-4">
                                <p>{{ getSupplierName(product.userId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">
                                {{ filteredDeliveries(product.id) }}
                            </td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <!-- <editProduct :product="product" /> -->
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
                        >Approved Products</span
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
                            v-for="product in approvedProducts"
                            :key="product.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-20 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                <p>{{ getProductName(product.productId) }}</p>
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
                            <td class="px-6 py-4">
                                <p
                                    v-if="product.status === 3"
                                    class="px-2 py-2 font-medium text-green-500 my-2 text-sm"
                                >
                                    Approve
                                </p>
                            </td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <!-- <Receive :product="product" /> -->
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

import axios from "axios";

export default {
    props: ["product"],
    components: {
        Modal,
        editProduct,
        Approve,
        Return,
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
            deliveries: [],
            productlists: [],
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

        getProductlists() {
            axios.get("/get-productlists").then(({ data }) => {
                this.productlists = data;
            });
        },

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

        fetchDeliveries() {
            axios
                .get("/get-deliveries")
                .then(({ data }) => {
                    this.deliveries = data;
                })
                .catch((error) => {
                    console.error("Error fetching deliveries:", error);
                });
        },

        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
        },

        returnAll(productId) {
            axios
                .post("/returnAll-product", { product: { productId } })
                .then(({ data }) => {
                    window.location.reload("Reloading");
                })
                .catch((error) => {
                    console.error("Error returning all products:", error);
                });
        },

        filteredDeliveries(productId) {
            const delivery = this.deliveries.find(
                (delivery) => delivery.productId === productId
            );
            if (!delivery) {
                return "No delivery information";
            }
            return delivery.qty;
        },

        getProductName(productId) {
            const productlist = this.productlists.find(
                (b) => b.id === productId
            );
            return productlist ? productlist.name : "Unknown product";
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
            return this.products.filter(
                (product) => product.status === 3 && product.userId === 1
            );
        },
    },
    mounted() {
        this.getProducts();
        this.getProductlists();
        this.getCategories();
        this.getUsers();
        this.fetchDeliveries();
    },
};
</script>
