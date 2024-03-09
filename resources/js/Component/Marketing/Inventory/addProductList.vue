<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add Product'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitProductlist"
        :save-option="true"
    >
        <form @submit.prevent="submitProductlist" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-4">
                <div class="col-span-2">
                    <label
                        for="categoryId"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Category</label
                    >
                    <select
                        v-model="editProductlist.categoryId"
                        id="categoryId"
                        name="categoryId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        required
                    >
                        <option value="">Select a category</option>
                        <option
                            v-for="category in categories"
                            :key="category.categoryId"
                            :value="category.categoryId"
                        >
                            {{ category.name }}
                        </option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Item Code</label
                    >
                    <input
                        v-model="editProductlist.item_code"
                        type="text"
                        name="item_code"
                        id="item_code"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the item code"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Product Name</label
                    >
                    <input
                        v-model="editProductlist.name"
                        type="text"
                        name="name"
                        id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the Product Name"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Price</label
                    >
                    <input
                        v-model="editProductlist.price"
                        type="number"
                        name="price"
                        id="price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type the product price"
                        required=""
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="image"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Image</label
                    >
                    <input
                        type="file"
                        name="image"
                        id="image"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        @change="handleImageUpload"
                        accept="image/*"
                        required
                    />
                </div>
                <div class="col-span-4">
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Description</label
                    >
                    <textarea
                        v-model="editProductlist.description"
                        type="text"
                        name="description"
                        id="description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Product Details"
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
    props: ["productlist"],
    components: {
        Modal,
    },
    data() {
        return {
            editProductlist: {
                productId: "",
                categoryId: "",
                name: "",
                image: "",
                item_code: "",
                price: "",
                description: "",
            },
            editingProductlist: null,
            modalContent: {
                title: "Create New Product",
                content: "Please fill in the product details",
                disablebtn: false,
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
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error submitting category:", error);
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
