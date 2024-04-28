<template>
    <Modal
        :modalContent="{
            title: 'Edit product',
            content: 'Please check the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Edit'"
        :cancelLabel="'Close'"
        :saveLabel="'Save'"
        @save="updateProduct"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-2">
                <label
                    for="categoryId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Category</label
                >
                <select
                    v-model="editProduct.categoryId"
                    id="categoryId"
                    name="categoryId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                >
                    <option value="">Select a category</option>
                    <option
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
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
                    v-model="editProduct.item_code"
                    type="text"
                    name="item_code"
                    id="item_code"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the item code"
                    required=""
                />
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product Name</label
                >
                <input
                    v-model="editProduct.name"
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name"
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
                    v-model="editProduct.price"
                    type="number"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the product price"
                    name="price"
                    required=""
                />
            </div>

            <div class="col-span-4">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Description</label
                >
                <textarea
                    v-model="editProduct.description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Description"
                    required=""
                ></textarea>
            </div>
        </div>
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
            editingProductId: this.productlist.id,
            editProduct: {
                item_code: "",
                categoryId: "",
                name: "",
                userId: "",
                price: "",
                unit: "",
                stocks: "",
                description: "",
                status: 0,
            },
            categories: [],
            productlists: [],
        };
    },
    watch: {
        productlist: {
            handler(newVal) {
                this.editProduct = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        updateProduct() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/update-productlist", { prodPayload, editingProductId })
                .then(({ data }) => {
                    window.location.reload("Reloading");
                });
        },
        getProductlists() {
            axios.get("/get-productlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
    },
    mounted() {
        this.getProductlists();
        this.getCategories();
    },
};
</script>
