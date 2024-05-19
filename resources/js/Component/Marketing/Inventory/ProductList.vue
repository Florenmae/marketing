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
                <div>
                    <addProductList></addProductList>
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
                                    class="w-20 h-auto rounded-lg"
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
                                class="px-2 py-7 flex justify-center items-center space-x-3"
                            >
                                <editProductList :productlist="productlist" />
                                <button
                                    class="bg-red-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-red-600"
                                    @click="deleteProduct(productlist.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <div
                    class="px-4 text-right text-s font-medium text-gray-500 uppercase tracking-wider"
                >
                    <button
                        @click="prevPage"
                        :disabled="pagination.currentPage === 1"
                    >
                        Prev
                    </button>
                    <span> / </span>
                    <button
                        @click="nextPage"
                        :disabled="
                            pagination.currentPage === pagination.lastPage
                        "
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editProductList from "@/Component/Marketing/inventory/editProductList.vue";
import addProductList from "@/Component/Marketing/inventory/addProductList.vue";
import axios from "axios";

export default {
    props: ["productlist"],
    components: {
        Modal,
        editProductList,
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
            productlists: [],
            editingProductListId: null,
            modalStatus: false,
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
        };
    },
    methods: {
        submitProductlist() {
            const { editProductlist } = this;
            const prodlistPayload = {
                ...editProductlist,
            };

            axios
                .post("/submit-productList", prodlistPayload)
                .then(({ data }) => {
                    this.getProductlists();
                    window.location.reload("Reloading");
                });
        },

        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getProductlists(page = 1) {
            axios.get(`/get-product-lists?page=${page}`).then(({ data }) => {
                this.productlists = data.data;
                this.pagination.currentPage = data.pagination.currentPage;
                this.pagination.lastPage = data.pagination.lastPage;
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

        getCategoryName(categoryId) {
            const category = this.categories.find((c) => c.id === categoryId);
            return category ? category.name : "Unknown Category";
        },
        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.getProductlists(this.pagination.currentPage - 1);
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.getProductlists(this.pagination.currentPage + 1);
            }
        },
    },

    mounted() {
        this.getProductlists(1);
        this.getCategories();
    },
};
</script>
