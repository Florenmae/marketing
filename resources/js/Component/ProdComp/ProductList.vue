<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="justify self-start mt-10 mb-4">
                <span class="text-xl font-bold text-gray-700 dark:text-gray-300"
                    >Product List</span
                >
            </div>
            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Image</th>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Item Code</th>
                            <th scope="col" class="px-6 py-3">
                                Product Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">Price</th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="product in products"
                            :key="product.id"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <img
                                :src="product.image"
                                alt="Product Image"
                                class="w-36 h-auto mb-2 rounded-lg"
                            />
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
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "@/Layout/Layout.vue";
import Modal from "@/Component/Modal.vue";
import editProduct from "@/Component/ProdComp/editProduct.vue";
import addProduct from "@/Component/ProdComp/addProduct.vue";
import addReturn from "@/Component/ProdComp/addReturn.vue";
import axios from "axios";

export default {
    components: {
        Layout,
        Modal,
        addProduct,
        editProduct,
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
    },
    mounted() {
        this.getProducts();
    },
};
</script>
