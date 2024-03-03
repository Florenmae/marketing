<template>
    <Modal1
        :modalContent="{
            title: 'Deliver product',
            content: 'Please edit the product details',
            disablebtn: false,
        }"
        :buttonLabel="'Deliver'"
        :cancelLabel="'Close'"
        :saveLabel="'Deliver'"
        @save="Deliver"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-4">
            <div class="col-span-4">
                <label
                    for="remarks"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Remarks:</label
                >
                <input
                    v-model="editProduct.remarks"
                    type="text"
                    name="remarks"
                    id="remarks"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                />
            </div>
        </div>
    </Modal1>
</template>

<script>
import Modal1 from "@/Component/Modal1.vue";
export default {
    props: ["product"],
    components: {
        Modal1,
    },
    data() {
        return {
            editingProductId: this.product.id,
            editProduct: {
                userId: "",
                remarks: "",
                deliverTo: "",
                status: 0,
                transactionId: null,
            },
            categories: [],
            submittedProducts: [],
        };
    },
    watch: {
        product: {
            handler(newVal) {
                this.editProduct = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        // Deliver() {
        //     const { editProduct, editingProductId } = this;
        //     const prodPayload = { ...editProduct, status: 4 };

        //     axios
        //         .post("/deliver", { prodPayload, editingProductId })
        //         .then(({ data }) => {
        //             //prodPayload.deliverTo = this.deliverTo;
        //             prodPayload.remarks = this.remarks;
        //             window.location.reload("Reloading");
        //         });
        // },
        Deliver() {
            const { editProduct, editingProductId } = this;
            const prodPayload = { ...editProduct, status: 4 };

            axios
                .get(`/get-transaction-id/${editingProductId}`)
                .then(({ data }) => {
                    const transactionId = data;
                    prodPayload.transactionId = transactionId;

                    // Send the payload to the backend
                    axios
                        .post("/deliver", { prodPayload, editingProductId })
                        .then(({ data }) => {
                            //prodPayload.deliverTo = this.deliverTo;
                            prodPayload.remarks = this.remarks;
                            window.location.reload("Reloading");
                        });
                });
        },

        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                this.products = data;
            });
        },

        getCategories() {
            axios.get("/get-categories").then(({ data }) => {
                this.categories = data;
            });
        },
    },
    mounted() {
        this.getProducts();
        this.getCategories();
    },
};
</script>
