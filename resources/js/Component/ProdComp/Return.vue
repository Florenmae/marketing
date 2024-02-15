<template>
    <Layout>
        <div class="justify-center w-full">
            <div class="flex justify-between items-end mt-6">
                <div class="mt-6 mb-6">
                    <span
                        class="text-xl font-bold text-gray-700 dark:text-gray-300"
                        >Product List</span
                    >
                </div>
                <div><returnForm /></div>
            </div>

            <div class="overflow-x-auto border border-gray-300">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Product Name</th>
                            <th scope="col" class="px-6 py-3">Item Code</th>
                            <th scope="col" class="px-6 py-3">
                                Product Supplier
                            </th>
                            <th scope="col" class="px-6 py-3">Quantity</th>
                            <th scope="col" class="px-6 py-3">Remarks</th>
                            <th scope="col" class="px-12 py-3">Action</th>
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
                            <td class="px-6 py-4">
                                {{ returnedProduct.item_code }}
                            </td>
                            <td class="px-6 py-4">
                                {{ returnedProduct.supplier }}
                            </td>
                            <td class="px-6 py-4">{{ returnedProduct.qty }}</td>
                            <td class="px-6 py-4">
                                {{ returnedProduct.description }}
                            </td>
                            <td class="flex space-x-4">
                                <editReturn
                                    :returnedProduct="returnedProduct"
                                />
                                <button
                                    class="bg-red-500 px-4 py-2 rounded-md text-white my-4 text-sm hover:bg-green-600"
                                    @click="deleteReturn(returnedProduct.id)"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Layout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import editReturn from "@/Component/ProdComp/editReturn.vue";
import returnForm from "@/Component/ProdComp/returnForm.vue";

export default {
    components: {
        Modal,
        editReturn,
        returnForm,
    },
    data() {
        return {
            editReturnedProduct: {
                item_code: "",
                name: "",
                supplier: "",
                qty: "",
                description: "",
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
                this.getReturnedProducts();
            });
        },

        // fetchReturnedProducts() {
        //     axios.get("/returned-products").then(({ data }) => {
        //         this.returnedProducts = data;
        //         this.fetchReturnedProducts();
        //     });
        // },

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
                .post("/update-returnedProduct", {
                    retPayload,
                    editingReturnedProductId,
                })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error updating product:", error);
                });
        },
        deleteReturn(id) {
            axios.post("/delete-returns", { id }).then(({ data }) => {
                this.getReturnedProducts();
            });
        },
    },
    mounted() {
        this.getReturnedProducts();
        // this.fetchReturnedProducts();
    },
};
</script>
