<template>
    <userLayout>
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
                            <th scope="col" class="px-6 py-3">Returned By</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Remarks</th>
                            <th scope="col" class="px-12 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(returnedProduct, id) in paginatedReturns"
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
                                {{ getUserRole(returnedProduct.returnedBy) }}
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
    </userLayout>
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
            returnedProducts: [],
            productlists: [],
            users: [],
            pagination: {
                currentPage: 1,
                lastPage: 1,
            },
            itemsPerPage: 8,
        };
    },
    methods: {
        getReturnedProducts() {
            axios.get("/get-returns").then(({ data }) => {
                this.returnedProducts = data;
                this.pagination.lastPage = Math.ceil(
                    data.length / this.itemsPerPage
                );
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
        getUserRole(returnedBy) {
            switch (returnedBy) {
                case 1:
                    return "Admin";
                case 2:
                    return "IGP";
                case 3:
                    return "Project";
                default:
                    return "Unknown";
            }
        },
        prevPage() {
            if (this.pagination.currentPage > 1) {
                this.pagination.currentPage--;
            }
        },
        nextPage() {
            if (this.pagination.currentPage < this.pagination.lastPage) {
                this.pagination.currentPage++;
            }
        },
    },
    mounted() {
        this.getReturnedProducts();
        this.getProductLists();
        this.getUsers();
    },
    computed: {
        paginatedReturns() {
            const startIndex =
                (this.pagination.currentPage - 1) * this.itemsPerPage;
            return this.returnedProducts.slice(
                startIndex,
                startIndex + this.itemsPerPage
            );
        },
    },
};
</script>
