<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex justify-between mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Category List</span
                    >
                </div>
                <div class="flex items-center space-x-6">
                    <SearchBar @search="performSearch" />
                    <addCategory />
                </div>
            </div>

            <div class="mt-2 overflow-x-auto border border-gray-300">
                <div
                    v-if="categories.length === 0"
                    class="text-center border border-yellow-300 p-4 text-gray-700 dark:text-gray-400"
                >
                    No categories redorded.
                </div>
                <table
                    v-else
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Category Name</th>
                            <th scope="col" class="px-6 py-3">Category Code</th>
                            <th scope="col" class="px-6 py-3">Product Count</th>
                            <th scope="col" class="px-12 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="category in categories"
                            :key="category.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ category.name }}
                            </th>
                            <td class="px-16 py-4">
                                {{ category.cat_code }}
                            </td>
                            <td class="px-16 py-4">
                                {{ category.product_count }}
                            </td>
                            <td class="flex space-x-4">
                                <editCategory :category="category" />
                                <button
                                    class="bg-red-500 px-2 py-2 rounded-md text-white my-2 text-sm hover:bg-red-600"
                                    @click="deleteCategory(category.id)"
                                >
                                    Delete
                                </button>
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
import editCategory from "@/Component/Marketing/Inventory/editCategory.vue";
import addCategory from "@/Component/Marketing/Inventory/addCategory.vue";
import SearchBar from "@/Component/Tools/SearchBar.vue";
import axios from "axios";

export default {
    components: {
        Modal,
        addCategory,
        editCategory,
        SearchBar,
    },
    data() {
        return {
            categories: [],
            editCategory: {
                id: "",
                categoryName: "",
                cat_code: " ",
                product_count: "",
            },
            editingCategoryId: null,
            modalStatus: false,
            searchQuery: "",
        };
    },
    methods: {
        submitCategory() {
            const { editCategory } = this;
            const catPayload = { ...editCategory };

            axios.post("/submit-category", catPayload).then(({ data }) => {
                this.categories.push(data);
                this.$forceUpdate();
                this.getCategories();
            });
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },
        performSearch(query) {
            this.searchQuery = query;
            this.getCategories();
        },

        getCategories() {
            axios
                .get("/get-categories", {
                    params: {
                        search: this.searchQuery,
                    },
                })
                .then(({ data }) => {
                    this.categories = data;
                });
        },
        editCategory(category) {
            this.editCategory = { ...category };
            this.editingCategoryId = category.id;
            this.modalContent.title = "Edit Category";
            this.modalStatus = true;
        },
        updateCategory(data) {
            const { editCategory, editingCategoryId } = this;
            const catPayload = { ...editCategory };

            axios
                .post("/update-category", { catPayload, editingCategoryId })
                .then(({ data }) => {
                    this.getCategories();
                });
        },
        deleteCategory(id) {
            axios.post("/delete-category", { id }).then(({ data }) => {
                this.getCategories();
            });
        },
    },
    mounted() {
        this.getCategories();
    },
};
</script>
