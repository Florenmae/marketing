<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Return'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Return'"
        @save="returnProduct"
        :save-option="true"
    >
        <form @submit.prevent="returnProduct" class="p-4 md:p-5">
            <div class="grid gap-4 mb-4 grid-cols-4">
                <div class="mb-4">
                    <label
                        for="item_code"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                    >
                        Item Code
                    </label>
                    <input
                        v-model="product.item_code"
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
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-700 dark:text-white"
                    >
                        Product Name
                    </label>
                    <input
                        v-model="product.name"
                        type="text"
                        name="name"
                        id="name"
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
                        v-model="product.supplier"
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
                        v-model="product.qty"
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
                        v-model="product.description"
                        name="description"
                        id="description"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-primary-600 focus:border-primary-600"
                        placeholder="Product Details"
                        required
                    ></textarea>
                </div>
                <!-- <div>
                <button
                    type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring focus:border-blue-300"
                >
                    Add Product
                </button>
            </div> -->
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";

export default {
    props: ["product"],
    components: {
        Modal,
    },
    data() {
        return {
            editingProductId: this.product.id,
            editReturnedProduct: {
                item_code: "",
                name: "",
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
        returnProduct() {
            const { editReturnedProduct, editingProductId } = this;
            const retPayload = {
                ...editReturnedProduct,
            };

            axios
                .post("/submit-return", retPayload, editingProductId)
                .then(({ data }) => {
                    this.getReturnedProducts();
                });
        },
        // returnProduct(productId) {
        //     const { item_code, name, supplier, qty, description } =
        //         this.products;
        //     axios
        //         .post("/return-product", {
        //             item_code,
        //             name,
        //             supplier,
        //             qty,
        //             description,
        //         })
        //         .then(({ data }) => {
        //             this.item_code;
        //             this.name;
        //             this.supplier;
        //             this.qty;
        //             this.description;
        //             console.log("Returned product data:", data);
        //         })
        //         .catch((error) => {
        //             console.error("Error returning product:", error);
        //         });
        // },
    },
};
</script>
