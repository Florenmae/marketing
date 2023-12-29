<template>
    <Layout>
        <button
            v-if="modalStatus"
            data-modal-target="crud-modal"
            data-modal-toggle="crud-modal"
            class="fixed top-20 right-10 block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button"
            @click="changeModalStatus"
        >
            Add Product
        </button>
        <!-- Main modal -->
        <div
            v-else
            id="crud-modal"
            tabindex="-1"
            aria-hidden="true"
            class="flex items-center justify-center h-screen w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        >
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            Create Product
                        </h3>
                        <button
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal"
                            @click="changeModalStatus"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="submitProduct" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 border-red-500">
                                <label
                                    for="product_code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Product Code</label
                                >
                                <input
                                    v-model="product_code"
                                    type="text"
                                    name="product_code"
                                    id="product_code"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Product Code"
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
                                    v-model="name"
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Product Name"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2">
                                <label
                                    for="item_code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Item Code</label
                                >
                                <input
                                    v-model="item_code"
                                    type="text"
                                    name="item_code"
                                    id="item_code"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Item Code"
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
                                    v-model="price"
                                    type="text"
                                    name="price"
                                    id="price"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Price"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2">
                                <label
                                    for="qty"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Quantity</label
                                >
                                <input
                                    v-model="qty"
                                    type="text"
                                    name="qty"
                                    id="qty"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Quantity"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2">
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Description</label
                                >
                                <input
                                    v-model="description"
                                    type="text"
                                    name="description"
                                    id="description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Description"
                                    required=""
                                />
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            <svg
                                class="me-1 -ms-1 w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            Add Product
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="product in products"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ product.name }}
                        </th>
                        <td class="px-6 py-4">{{ product.product_code }}</td>
                        <td class="px-6 py-4">{{ product.item_code }}</td>
                        <td class="px-6 py-4">{{ product.price }}</td>
                        <td class="px-6 py-4">{{ product.qty }}</td>
                        <td class="px-6 py-4">{{ product.description }}</td>
                        <td class="px-6 py-4">
                            <a
                                href="#"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                >Edit</a
                            >
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
    </Layout>
</template>

<script>
export default {
    data() {
        return {
            name: "",
            product_code: "",
            item_code: "",
            price: "",
            qty: "",
            description: "",
            modalStatus: true,
            products: [],
            id: "",
        };
    },
    methods: {
        submitProduct() {
            const { product_code, item_code, name, price, qty, description } =
                this;
            axios
                .post("/submit-product", {
                    name,
                    product_code,
                    item_code,
                    price,
                    qty,
                    description,
                })
                .then(({ data }) => {
                    this.name = "";
                    this.product_code = "";
                    this.item_code = " ";
                    this.price = " ";
                    this.qty = " ";
                    this.description = "";
                    this.getProducts();
                    this.$emit("success");
                });
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },
        getProducts() {
            axios.get("/get-products").then(({ data }) => {
                console.log(data);
                this.products = data;
            });
        },
        deleteProduct(id) {
            axios.post("/delete-product", { id }).then(({ data }) => {
                this.getProducts();
            });
        },
    },
    mounted() {
        this.getProducts();
    },
};
</script>
