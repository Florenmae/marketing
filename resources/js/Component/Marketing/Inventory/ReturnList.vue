<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Returned Product List</span
                    >
                </div>
                <div><returnForm /></div>
            </div>

            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3">Item Code</th>
                            <th scope="col" class="px-6 py-3">
                                Product Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Remarks</th>
                            <th scope="col" class="px-12 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="returnedProduct in paginatedReturnedProducts"
                            :key="returnedProduct.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{
                                    getProductName(
                                        returnedProduct.productlistId
                                    )
                                }}
                            </th>
                            <td class="px-6 py-4">
                                {{ returnedProduct.item_code }}
                            </td>
                            <td class="px-6 py-4">
                                {{ getSupplierName(returnedProduct.userId) }}
                            </td>
                            <td class="px-6 py-4">{{ returnedProduct.qty }}</td>
                            <td class="px-6 py-4">
                                {{ returnedProduct.description }}
                            </td>
                            <td class="flex justify-center space-x-4">
                                <editReturn
                                    :returnedProduct="returnedProduct"
                                />
                                <button
                                    class="bg-red-500 px-6 py-2 rounded-md text-white my-3 text-sm hover:bg-red-700"
                                    @click="deleteReturn(returnedProduct.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="returnedProducts && returnedProducts.length === 0"
                class="mt-4 text-center p-4 text-yellow-500"
            >
                ---------- No Returned Products Recorded. ----------
            </div>
            <div
                class="fixed bottom-6 right-4 w-full bg-white p-4 flex justify-end"
            >
                <Pagination
                    :current_page="currentPage"
                    :last_page="lastPage"
                    @next="nextPage"
                    @back="previousPage"
                />
            </div>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
import Modal from "@/Component/Modal.vue";
import Pagination from "@/Component/Tools/Pagination.vue";

export default {
    components: {
        Modal,
        Pagination,
    },
    data() {
        return {
            editReturnedProduct: {
                item_code: "",
                productlistId: "",
                userId: "",
                qty: "",
                description: "",
            },
            returnedProducts: [],
            productlists: [],
            users: [],
            editingReturnedProductId: null,
            modalStatus: false,
            currentPage: 1,
            perPage: 10,
        };
    },
    computed: {
        paginatedReturnedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.returnedProducts.slice(start, end);
        },
        lastPage() {
            return Math.ceil(this.returnedProducts.length / this.perPage);
        },
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getReturnedProducts() {
            axios.get("/get-returns").then(({ data }) => {
                this.returnedProducts = data;
            });
        },

        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (b) => b.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },

        deleteReturn(id) {
            axios.post("/delete-returns", { id }).then(({ data }) => {
                this.getReturnedProducts();
            });
        },

        getProductLists() {
            axios.get("/get-productlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getUsers() {
            axios.get("/get-users").then(({ data }) => {
                this.users = data;
            });
        },

        getSupplierName(userId) {
            userId = Number(userId);
            const user = this.users.find((user) => user.id === userId);
            return user ? user.name : "Unknown User";
        },

        nextPage() {
            if (this.currentPage < this.lastPage) {
                this.currentPage++;
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
    },
    mounted() {
        this.getReturnedProducts();
        this.getProductLists();
        this.getUsers();
    },
};
</script>
