<template>
    <Layout>
        <div class="justify self-end"><addProduct /></div>
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">Product Name</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Item Code</th>
                    <th scope="col" class="px-6 py-3">Product Supplier</th>
                    <th scope="col" class="px-6 py-3">Price</th>
                    <th scope="col" class="px-6 py-3">Quantity</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-20 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="product in products"
                    :key="product.id"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                >
                    <th
                        scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                    >
                        {{ product.name }}
                    </th>
                    <td class="px-6 py-4">{{ product.cat_code }}</td>
                    <td class="px-6 py-4">{{ product.item_code }}</td>
                    <td class="px-6 py-4">{{ product.supplier }}</td>
                    <td class="px-6 py-4">{{ product.price }}</td>
                    <td class="px-6 py-4">{{ product.qty }}</td>
                    <td class="px-6 py-4">{{ product.description }}</td>
                    <td class="px-6 py-4">{{ product.status }}</td>
                    <td class="flex space-x-4 >">
                        <editProduct :product="product" />
                        <button
                            class="bg-red-500 px-4 py-2 rounded-md text-white my-4 text-sm hover:bg-green-600"
                            @click="deleteProduct(product.id)"
                        >
                            Delete
                        </button>

                        <addReturn :product="product" />
                    </td>
                </tr>
            </tbody>
        </table>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editProduct from "@/Component/ProdComp/editProduct.vue";
import addProduct from "@/Component/ProdComp/addProduct.vue";
import returnForm from "@/Component/ProdComp/returnForm.vue";
import addReturn from "@/Component/ProdComp/addReturn.vue";

import axios from "axios";
export default {
    components: {
        Modal,
        addProduct,
        editProduct,
        returnForm,
        addReturn,
    },
    data() {
        return {
            editProduct: {
                item_code: "",
                product_code: "",
                name: "",
                supplier: "",
                price: "",
                qty: "",
                description: "",
                status: "",
            },
            products: [],
            editingProductId: null,
            modalStatus: false,
        };
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },
        editProduct(product) {
            this.editProduct = { ...product };
            this.editingProductId = product.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
            this.getProducts;
        },

        updateProduct(data) {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProducts;
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },

        deleteProduct(id) {
            axios.post("/delete-product", { id }).then(({ data }) => {
                this.getProducts();
            });
        },

        returnProduct(data) {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/return-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProducts;
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },
    },
    mounted() {
        this.getProducts();
    },
};
</script>
