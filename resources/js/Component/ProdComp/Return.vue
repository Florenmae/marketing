<template>
    <Layout>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Product Name</th>
                        <th scope="col" class="px-6 py-3">Item Code</th>
                        <th scope="col" class="px-6 py-3">Product Supplier</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Remarks</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="returnedProduct in returnedProducts"
                        :key="returnedProduct.id"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ returnedProduct.name }}
                        </th>
                        <td class="px-6 py-4">{{ returnedProduct.item_code }}</td>
                        <td class="px-6 py-4">{{ returnedProduct.supplier }}</td>
                        <td class="px-6 py-4">{{ returnedProduct.qty }}</td>
                        <td class="px-6 py-4">{{ returnedProduct.description }}</td>
                        <td class="px-6 py-4">{{ returnedProduct.status }}</td>
                        <td>
                            <editReturn :returnedProduct="returnedProduct" />
                        </td>
                        <td class="py-4">
                            <button
                                class="bg-red-500 py-2 px-4 rounded text-white"
                                @click="deleteReturn(returnedProduct.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editReturn from "@/Component/ProdComp/editReturn.vue";

export default {
    components: {
        Modal,
        editReturn,
    },
    data() {
        return {
            editReturnedProduct: {
                item_code: "",
                ret_name: "",
                supplier: "",
                qty: "",
                remarks: "",
                status: "",
            },
            returnedProducts: [],
            editingReturnedProductId: null,
            modalStatus: false,
        };
    },
    methods: {
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },

        getReturnedProducts() {
            axios.get("/get-returns").then(({ data }) => {
                this.returnedProducts = data;
            });
        },

        editReturnedProduct(returnedProduct) {
            this.editReturnedProduct = { ...returnedProduct };
            this.editingReturnedProductId = returnedProduct.id;
            this.modalContent.title = "Edit Product";
            this.modalStatus = true;
            this.getReturnedProducts;
        },
        updateReturnedProduct(data) {
            const { editReturnedProduct, editingReturnedProductId } = this;
            const retPayload = { ...editReturnedProduct };

            axios
                .post("/update-returnedProduct", { retPayload, editingReturnedProductId })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },

        fetchReturnedProducts() {
        axios.get("/returned-products")
            .then(response => {
            this.returnedProducts = response.data;
            })
            .catch(error => {
            console.error('Error fetching returned products', error);
            });
        },

    },
    mounted() {
        this.getReturnedProducts();
        this.fetchReturnedProducts();
    },
};
</script>
