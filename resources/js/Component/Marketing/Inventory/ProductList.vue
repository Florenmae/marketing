<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
                    >
                </div>
                <div><addProductList></addProductList></div>
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
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-20 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="productlist in productlists"
                            :key="productlist.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-4">
                                <img
                                    :src="productlist.image"
                                    alt="Product Image"
                                    class="w-34 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ productlist.name }}
                            </th>
                            <td class="px-6 py-4">
                                <p>
                                    {{
                                        getCategoryName(productlist.categoryId)
                                    }}
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                {{ productlist.item_code }}
                            </td>

                            <td class="px-6 py-4">{{ productlist.price }}</td>
                            <td class="px-6 py-4">
                                {{ productlist.description }}
                            </td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-2"
                            >
                                <!-- <editProduct :product="product" /> -->
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
import addProductList from "@/Component/Marketing/inventory/addProductList.vue";

import axios from "axios";

export default {
    props: ["productlist"],
    components: {
        Modal,
        editProduct,
        addProductList,
    },
    data() {
        return {
            editProduct: {
                item_code: "",
                categoryId: "",
                name: "",
                image: "",
                userId: "",
                price: "",
                description: "",
                status: 1,
            },
            categories: [],
            //users: [],
            productlists: [],
            editingProductListId: null,
            modalStatus: false,
        };
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getProductlists() {
            axios.get("/get-product-lists").then(({ data }) => {
                this.productlists = data;
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

        // editProduct(product) {
        //     this.editProduct = { ...product };
        //     this.editingProductId = product.id;
        //     this.modalContent.title = "Edit Product";
        //     this.modalStatus = true;
        // },

        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },

        // getSupplierName(userId) {
        //     userId = Number(userId);
        //     const user = this.users.find((user) => user.id === userId);
        //     return user ? user.name : "Unknown User";
        // },
    },
    // computed: {
    //     receivedProduct() {
    //         return this.products.filter((product) => product.status === 5);
    //     },
    // },
    mounted() {
        this.getProductlists();
        this.getCategories();
        //this.getUsers();
    },
};
</script>
