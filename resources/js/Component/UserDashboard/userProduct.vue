<template>
    <userLayout>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <addProduct class="fixed top-20 right-10"></addProduct>
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
                        <th scope="col" class="px-6 py-3">Action</th>
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
                        <td class="px-6 py-4">
                            {{ product.status }}
                        </td>
                        <td class="py-4">
                            <button
                                class="bg-red-500 py-2 px-4 rounded text-white"
                                @click="deleteProduct(product.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </userLayout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editProduct from "@/Component/ProdComp/editProduct.vue";
import addProduct from "@/Component/ProdComp/addProduct.vue";
export default {
    components: {
        Modal,
        addProduct,
        editProduct,
    },
    data() {
        return {
            selectedCategory: null,
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
        submitProduct() {
            const { editProduct } = this;
            const prodPayload = {
                ...editProduct,
            };

            axios.post("/submit-product", prodPayload).then(({ data }) => {
                this.getProducts();
                this.changeModalStatus();
            });
        },
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
        },

        updateProduct(data) {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct };

            axios
                .post("/update-product", { prodPayload, editingProductId })
                .then(({ data }) => {
                    this.getProducts();
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
        clearForm() {
            this.editProduct = {
                item_code: "",
                product_code: "",
                name: "",
                supplier: "",
                price: "",
                qty: "",
                description: "",
                status: "",
            };
            this.changeModalStatus();
            this.editingProductId = null;
        },
    },
    mounted() {
        this.getProducts();
    },
};
</script>
