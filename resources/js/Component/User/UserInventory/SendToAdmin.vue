<template>
    <Modal
        :modalContent="{
            title: 'Deliver product',
            content: 'Please check the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Deliver'"
        :cancelLabel="'Close'"
        :saveLabel="'Deliver'"
        @save="submitToAdmin"
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
                    v-model="editInventory.categoryId"
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
                    v-model="editInventory.item_code"
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
                    v-model="editInventory.name"
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type product name"
                    required=""
                />
            </div>
            <!-- <div class="col-span-2 border-red-500">
                <label
                    for="userId"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Product supplier</label
                >
                <select
                    v-model="editInventory.userId"
                    type="text"
                    name="userId"
                    id="userId"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required=""
                >
                    <option selected>Choose a supplier</option>
                    <option value="2">IGP</option>
                    <option value="3">Project</option>
                </select>
            </div> -->
            <div class="col-span-2">
                <label
                    for="price"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Price</label
                >
                <input
                    v-model="editInventory.price"
                    type="number"
                    id="price"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Type the product price"
                    name="price"
                    required=""
                />
            </div>
            <div class="col-span-2">
                <label
                    for="unit"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >unit</label
                >
                <input
                    v-model="editInventory.unit"
                    type="text"
                    id="unit"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Select Product Unit"
                    name="unit"
                    required=""
                />
            </div>
            <div class="col-span-2">
                <label
                    for="stocks"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Quantity</label
                >
                <input
                    v-model="editInventory.stocks"
                    type="number"
                    name="qty"
                    id="qty"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Quantity"
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
                    v-model="editInventory.description"
                    type="text"
                    name="description"
                    id="description"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Product Description"
                    required=""
                ></textarea>
            </div>
            <div class="col-span-4">
                <label
                    for="remarks"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Remarks:</label
                >
                <textarea
                    v-model="editInventory.remarks"
                    type="text"
                    name="remarks"
                    id="remarks"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                ></textarea>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
export default {
    props: ["inventory"],
    components: {
        Modal,
    },
    data() {
        return {
            editingInventoryId: this.inventory.id,
            editInventory: {
                categoryId: "",
                item_code: "",
                productId: "",
                name: "",
                userId: "",
                price: "",
                stocks: "",
                description: "",
                approved_by: "",
                status: 0,
                remarks: "",
                transactionId: "",
            },
            categories: [],
            submittedProducts: [],
        };
    },
    watch: {
        inventory: {
            handler(newVal) {
                this.editInventory = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        submitToAdmin() {
            const { editInventory, editingInventoryId } = this;
            const prodPayload = { ...editInventory, status: 2 };

            axios
                .get(`/get-transaction-id/${editingInventoryId}`)
                .then(({ data }) => {
                    const transactionId = data;
                    prodPayload.transactionId = transactionId;

                    axios
                        .post("/submitToAdmin", {
                            prodPayload,
                            editingInventoryId,
                        })
                        .then(({ data }) => {
                            //prodPayload.deliverTo = this.deliverTo;
                            prodPayload.remarks = this.remarks;
                            window.location.reload("Reloading");
                        });
                });
        },
        // getProducts() {
        //     axios.get("/get-products").then(({ data }) => {
        //         this.products = data;
        //     });
        // },

        getInventories() {
            axios.get("/get-inventory").then(({ data }) => {
                this.inventories = data;
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
    },
    mounted() {
        //this.getProducts();
        this.getInventories();
        this.getCategories();
    },
};
</script>
