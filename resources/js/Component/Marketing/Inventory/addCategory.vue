<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add Category'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitCategory"
        :save-option="true"
    >
        <form @submit.prevent="submitCategory" class="">
            <div class="justify justify-end gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Category Name</label
                    >
                    <input
                        v-model="editCategory.name"
                        type="text"
                        name="name"
                        id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the Category Name"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="cat_code"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Category Code</label
                    >
                    <input
                        v-model="editCategory.cat_code"
                        type="text"
                        name="cat_code"
                        id="cat_code"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the Category code"
                        required=""
                    />
                </div>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
export default {
    props: ["category"],
    components: {
        Modal,
    },
    data() {
        return {
            categories: [],
            editCategory: {
                cat_code: "",
                name: "",
                product_count: "",
            },
            editingCategoryId: null,
            modalContent: {
                title: "Create New Category",
                content: "Please fill in the category details",
                disablebtn: false,
            },
        };
    },
    methods: {
        submitCategory() {
            const { editCategory } = this;
            const catPayload = {
                ...editCategory,
            };

            axios.post("/submit-category", catPayload).then(({ data }) => {
                this.categories.push(data);
                this.$forceUpdate();
                this.getCategories();
                window.location.reload("Reloading");
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
    },
    mounted() {
        this.getCategories();
    },
};
</script>
