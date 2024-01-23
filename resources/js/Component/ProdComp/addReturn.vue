<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add Product'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitReturn"
        :save-option="true"
    >
        <form
            @submit.prevent="submitReturn"
            class="mx-auto max-w-md p-4 md:p-6 bg-white shadow-md rounded-md"
        >
            <div class="mb-4">
                <label
                    for="item_code"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                >
                    Item Code
                </label>
                <input
                    v-model="editReturn.item_code"
                    type="text"
                    name="item_code"
                    id="item_code"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                    placeholder="Type the item code"
                    required
                />
            </div>
            <div class="mb-4">
                <label
                    for="ret_name"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                >
                    Product Name
                </label>
                <input
                    v-model="editReturn.ret_name"
                    type="text"
                    name="ret_name"
                    id="ret_name"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                    placeholder="Type product name"
                    required
                />
            </div>
            <div class="mb-4">
                <label
                    for="supplier"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                >
                    Product Supplier
                </label>
                <select
                    v-model="editReturn.supplier"
                    name="supplier"
                    id="supplier"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                    required
                >
                    <option value="IGP">IGP</option>
                    <option value="Project">Project</option>
                </select>
            </div>
            <div class="mb-4">
                <label
                    for="qty"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                >
                    Quantity
                </label>
                <input
                    v-model="editReturn.qty"
                    type="text"
                    name="qty"
                    id="qty"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                    placeholder="Product Quantity"
                    required
                />
            </div>
            <div class="mb-4">
                <label
                    for="description"
                    class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                >
                    Description
                </label>
                <textarea
                    v-model="editReturn.description"
                    name="description"
                    id="description"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                    placeholder="Product Details"
                    required
                ></textarea>
            </div>
            <div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300"
                >
                    Add Product
                </button>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";

export default {
    props: ["return"],
    components: {
        Modal,
    },
    data() {
        return {
            returnedProducts: [],
            editingReturnId: null,
            editReturn: {
                item_code: "",
                ret_name: "",
                supplier: "",
                qty: "",
                description: "",
            },
            modalContent: {
                title: "Return Product",
                content: "Please fill in the product details",
                disablebtn: false,
            },
        };
    },
    methods: {
        getReturnedProducts() {
            axios.get("/get-returns").then(({ data }) => {
                this.returnedProducts = data;
            });
        },
        submitReturn() {
            const { editReturn } = this;
            const retPayload = { ...editReturn };

            axios.post("/submit-returns", retPayload).then(({ data }) => {
                this.getReturnedProducts();
            });
        },
    },
    mounted() {
        this.getReturnedProducts();
    },
};
</script>
