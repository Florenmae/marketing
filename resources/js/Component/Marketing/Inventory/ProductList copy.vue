<template>
    <Layout>
        <div class="mt-6 justify-center w-full">
            <div class="flex justify-between items-center mt-6 mb-6">
                <div class="flex items-center space-x-4">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
                    >
                </div>
                <div class="flex items-center space-x-6">
                    <!-- <form class="max-w-md mx-auto">
                        <label
                            for="default-search"
                            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                            >Search</label
                        >
                        <div class="relative">
                            <input
                                type="search"
                                id="default-search"
                                v-model="searchQuery"
                                @input="performSearch"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search Products..."
                                required
                            />
                            <button
                                type="button"
                                class="absolute top-0 end-0 p-2 text-sm font-medium h-full text-white bg-blue-600 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                <i
                                    class="pi pi-search"
                                    style="font-size: 1rem"
                                ></i>
                            </button>
                        </div>
                    </form> -->
                    <SearchBar @search="performSearch" />
                    <addProductList></addProductList>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto border border-gray-300">
                <div
                    v-if="productlists.length === 0"
                    class="text-center border border-yellow-300 p-4 text-gray-700 dark:text-gray-400"
                >
                    No products matched your search.
                </div>
                <table
                    v-else
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
                        <!-- <tr v-if="productlists.length === 0">
                            <td
                                colspan="7"
                                class="px-6 py-4 text-center text-gray-700 dark:text-gray-300"
                            >
                                No products matched your search.
                            </td>
                        </tr> -->
                        <tr
                            v-for="productlist in productlists"
                            :key="productlist.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <td class="px-6 py-2">
                                <img
                                    :src="productlist.image"
                                    alt="Product Image"
                                    class="w-20 h-auto rounded-lg"
                                />
                            </td>
                            <th
                                scope="row"
                                class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ productlist.name }}
                            </th>
                            <td class="px-6 py-2">
                                <p>
                                    {{
                                        getCategoryName(productlist.categoryId)
                                    }}
                                </p>
                            </td>
                            <td class="px-6 py-2">
                                {{ productlist.item_code }}
                            </td>
                            <td class="px-6 py-2">{{ productlist.price }}</td>
                            <td class="px-6 py-2">
                                {{ productlist.description }}
                            </td>
                            <td
                                class="px-6 py-4 flex justify-center items-center space-x-3"
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
            <div
                class="flex justify-end mt-4 mr-4"
                v-if="pagination.totalItems > 0"
            >
                <div
                    class="fixed bottom-6 right-4 w-full bg-white p-4 flex justify-end"
                >
                    <Pagination
                        :current_page="pagination.currentPage"
                        :last_page="pagination.lastPage"
                        @next="nextPage"
                        @back="prevPage"
                    />
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editProductList from "@/Component/Marketing/inventory/editProductList.vue";
import addProductList from "@/Component/Marketing/inventory/addProductList.vue";
import Pagination from "@/Component/Tools/Pagination.vue";
import SearchBar from "@/Component/Tools/SearchBar.vue";
import axios from "axios";
import _ from "lodash";

export default {
    components: {
        Modal,
        editProductList,
        addProductList,
        Pagination,
        SearchBar,
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
            searchQuery: "",
            pagination: {
                currentPage: 1,
                lastPage: 1,
                totalItems: 0,
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

        performSearch: _.debounce(function () {
            this.getProductlists(1);
        }, 100),

        getProductlists(page = 1) {
            axios
                .get(`/get-product-lists`, {
                    params: {
                        page: page,
                        search: this.searchQuery,
                    },
                })
                .then(({ data }) => {
                    this.productlists = data.data;
                    this.pagination.currentPage = data.pagination.currentPage;
                    this.pagination.lastPage = data.pagination.lastPage;
                    this.pagination.totalItems = data.pagination.totalItems;
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
