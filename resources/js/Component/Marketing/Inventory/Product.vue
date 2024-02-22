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
                            :key="product.productId"
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
                                {{ product.productName }}
                            </th>
                            <td class="px-6 py-4">
                                <p>{{ getCategoryName(product.categoryId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>

                            <td class="px-6 py-4">
                                <p>{{ product.supplierId }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.qty }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <editProduct :product="product" />
                                <ApprovedProd :approveProduct="product" />
                                <addReturn :product="product" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
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
                            v-for="product in approvedProducts"
                            :key="product.productId"
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
                                {{ product.productName }}
                            </th>
                            <td class="px-6 py-4">
                                <p>{{ getCategoryName(product.categoryId) }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.item_code }}</td>

                            <td class="px-6 py-4">
                                <p>{{ product.supplierId }}</p>
                            </td>
                            <td class="px-6 py-4">{{ product.price }}</td>
                            <td class="px-6 py-4">{{ product.qty }}</td>
                            <td class="px-6 py-4">{{ product.description }}</td>
                            <td class="px-6 py-4">{{ product.status }}</td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <editProduct :product="product" />
                                <button
                                    class="bg-red-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-green-600"
                                    @click="promptDelete(product)"
                                >
                                    Delete
                                </button>
                                <addReturn :product="product" />
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
import ApprovedProd from "@/Component/Marketing/inventory/ApprovedProd.vue";

// import addReturn from "@/Component/ProdComp/addReturn.vue";

import axios from "axios";
export default {
    props: ["approveProduct"],
    components: {
        Modal,
        editProduct,
        ApprovedProd,
    },
    data() {
        return {
            pendingProducts: [],
            approvedProducts: [],
            editProduct: {
                item_code: "",
                productId: "",
                name: "",
                supplierId: "",
                price: "",
                qty: "",
                description: "",
                status: 0,
            },
            suppliers: [],
            products: [],
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
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },

        getPendingProducts() {
            axios.get("/get-products?status=0").then(({ data }) => {
                this.pendingProducts = data;
            });
        },
        getApprovedProducts() {
            axios.get("/get-products?status=1").then(({ data }) => {
                this.approvedProducts = data;
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },

        getSuppliers() {
            axios.get("/get-suppliers").then(({ data }) => {
                this.suppliers = data;
            });
        },

        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
        },

        updateProduct() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    if (prodPayload.status === 1) {
                        this.getProducts();
                    }
                });
        },

        approveProduct(productId) {
            axios
                .get(`/get-product/${productId}`)
                .then(({ data }) => {
                    console.log("Product for approval:", data);
                    this.approveProduct = data;
                })
                .catch((error) => {
                    console.error(
                        "Error fetching product for approval:",
                        error
                    );
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

        deleteProduct(productId) {
            axios.post("/delete-product", { productId }).then(({ data }) => {
                this.getProducts();
            });
        },

        returnProduct(data) {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/return-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProducts();
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },
        getCategoryName(categoryId) {
            const category = this.categories.find(
                (c) => c.categoryId === categoryId
            );
            return category.categoryName;
        },

        // getSupplierName(supplierId) {
        //     const supplier = this.suppliers.find(
        //         (c) => c.supplierId === supplierId
        //     );
        //     return supplier.supplierName;
        // },
    },
    computed: {
        pendingProducts() {
            return this.products.filter((product) => product.status === 0);
        },
        approvedProducts() {
            return this.products.filter((product) => product.status === 1);
        },
    },
    mounted() {
        this.getProducts();
        this.getApprovedProducts();
        this.getPendingProducts();
        this.getCategories();
        this.getSuppliers();
    },
};
</script>
