<template>
    <userLayout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-center mt-8 mb-4">
                <div class="flex items-center space-x-4">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
                    >
                </div>
                <div class="flex items-center space-x-6">
                    <SearchBar @search="handleSearch" />
                    <addProduct></addProduct>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto border border-gray-300">
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
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(product, id) in paginatedProducts"
                            :key="product.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-16 h-16"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ getProductName(product.productlistId) }}
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
                                    class="px-2 py-1 font-medium text-green-500 my-2 text-sm"
                                >
                                    Returned
                                </p>
                            </td>
                            <td
                                class="space-x-2 px-6 py-4 flex justify-center items-center"
                            >
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
            <div class="fixed bottom-5 right-4 w-full p-4 flex justify-end">
                <Pagination
                    :current_page="pagination.currentPage"
                    :last_page="pagination.lastPage"
                    @next="nextPage"
                    @back="prevPage"
                />
            </div>
        </div>
        <Toast />
    </userLayout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import addProduct from "@/Component/User/UserInventory/addProduct.vue";
import SendToAdmin from "@/Component/User/UserInventory/SendToAdmin.vue";
import axios from "axios";
import UserLayout from "../../../Layout/userLayout.vue";
import Pagination from "@/Component/Tools/Pagination.vue";
import SearchBar from "@/Component/Tools/SearchBar.vue";
import _ from "lodash";
import Toast from "primevue/toast";

export default {
    components: {
        Modal,
        addProduct,
        UserLayout,
        SendToAdmin,
        Pagination,
        SearchBar,
        Toast,
    },
    data() {
        return {
            product: {
                item_code: "",
                productlistId: "",
                userId: "",
                price: "",
                stocks: "",
                description: "",
                status: "",
            },
            products: [],
            productlists: [],
            categories: [],
            editingProductId: null,
            modalStatus: false,
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 5,
            searchQuery: "",
        };
    },
    methods: {
        // getProductUsers() {
        //     axios.get("/get-productsUser").then(({ data }) => {
        //         this.products = data;
        //         this.pagination.lastPage = Math.ceil(
        //             this.products.length / this.itemsPerPage
        //         );
        //         console.log("Products:", this.products);
        //     });
        // },

        // getProductUsers(page = 1) {
        //     axios.get(`/get-productsUser?page=${page}`).then(({ data }) => {
        //         this.products = data;
        //         this.pagination.lastPage = Math.ceil(
        //             this.products.length / this.itemsPerPage
        //         );
        //         console.log("Products:", this.products);
        //     });
        // },

        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
            this.getProductUsers();
        },
        updateProduct(data) {
            const { product, editingProductId } = this;
            const prodPayload = { ...product };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProductUsers();
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
                this.deleteProduct(product.id);
            }
        },
        deleteProduct(id) {
            axios.post("/delete-product", { id }).then(({ data }) => {
                this.fetchProducts();
            });
        },
        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
        // getProductlists(page = 1) {
        //     axios
        //         .get(`/get-product-lists?page=${page}`)
        //         .then(({ data }) => {
        //             this.productlists = data.data;
        //             this.pagination.currentPage = data.pagination.currentPage;
        //             this.pagination.lastPage = data.pagination.lastPage;
        //             console.log("Product Lists:", this.productlists);
        //         })
        //         .catch((error) => {
        //             console.error("Error fetching product lists:", error);
        //         });
        // },
        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },
        submitProduct() {
            const { product } = this;
            axios
                .post("/submit-product", product)
                .then(({ data }) => {
                    this.fetchProducts();
                    window.location.relaod("Reloading");
                    this.products.push(data);
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Created product successfully",
                        life: 4000,
                    });
                })
                .catch((error) => {
                    console.error("Error submitting product:", error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to create product",
                        life: 4000,
                    });
                });
        },

        async fetchProducts() {
            try {
                const { data } = await axios.get("/get-productsUser", {
                    params: {
                        search: this.searchQuery,
                    },
                });
                this.products = data;
                this.pagination.lastPage = Math.ceil(
                    this.products.length / this.itemsPerPage
                );
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },

        handleSearch(query) {
            this.searchQuery = query;
            this.fetchProducts();
        },

        getProductlists() {
            axios.get("/getproductlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (b) => b.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },
        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.pagination.currentPage--;
                this.getProductlists(this.pagination.currentPage);
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.pagination.currentPage++;
                this.getProductlists(this.pagination.currentPage);
            }
        },
    },
    mounted() {
        // this.getProductUsers(1);
        this.fetchProducts(1);
        this.getCategories();
        this.getProductlists();
    },
    computed: {
        paginatedProducts() {
            const startIndex =
                (this.pagination.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            return this.products.slice(startIndex, endIndex);
        },
    },
};
</script>
