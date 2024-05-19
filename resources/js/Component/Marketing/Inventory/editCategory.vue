<template>
    <Modal
        :modalContent="{
            title: 'Edit category',
            content: 'Please edit the category details',
            disablebtn: false,
        }"
        :buttonLabel="'Edit'"
        :cancelLabel="'Close'"
        :saveLabel="'Update'"
        @save="updateCategory"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2 border-red-500">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Category Name</label
                >
                <input
                    v-model="category.name"
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Category Code</label
                >
                <input
                    v-model="category.cat_code"
                    type="text"
                    name="cat_code"
                    id="cat_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
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
            editingCategoryId: this.category.id,
            editCategory: {
                name: "",
                cat_code: " ",
                product_count: "",
            },
        };
    },
    watch: {
        category: {
            handler(newVal) {
                this.editCategory = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        updateCategory() {
            const { editCategory, editingCategoryId } = this;
            const catPayload = { ...editCategory };

            axios
                .post("/update-category", { catPayload, editingCategoryId })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error updating category:", error);
                });
        },
    },
    mounted() {
        // console.log(this.user.id);
    },
};
</script>
