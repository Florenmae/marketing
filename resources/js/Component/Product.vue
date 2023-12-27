<template>
    <Layout>
        <div class="fixed top-40 overflow-x-auto shadow-md sm:rounded-lg">
            <div class="pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div
                        class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                    >
                        <svg
                            class="w-6 h-6 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="table-search"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items"
                    />
                </div>
            </div>
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input
                                    id="checkbox-all-search"
                                    type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <label for="checkbox-all-search" class="sr-only"
                                    >checkbox</label
                                >
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col" class="px-6 py-3">Product Code</th>
                        <th scope="col" class="px-6 py-3">Product Name</th>
                        <th scope="col" class="px-6 py-3">Price</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(product, index) in products"
                        :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td>{{ product.item_code }}</td>
                        <td>{{ product.product_code }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}</td>
                        <td>{{ product.qty }}</td>
                        <td>{{ product.description }}</td>

                        <td>
                            <button
                                class="bg-blue-500 py-2 px-4 rounded text-white"
                                @click="$emit('editProduct', product.id)"
                            >
                                Edit
                            </button>
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
                            Create New Product
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
                            <div class="col-span-2">
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
                                    placeholder="Type the product code"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2">
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Item Code</label
                                >
                                <input
                                    v-model="item_code"
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
                                    v-model="name"
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type product name"
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
                                    placeholder="Type the product price"
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
                                    placeholder="Product Quantity"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2">
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Description</label
                                >
                                <textarea
                                    v-model="description"
                                    type="text"
                                    name="description"
                                    id="description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Product Details"
                                    required=""
                                />
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white inline-flex items-center bg-green-700 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
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
                            Add new Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import LayoutUser from "../Layout/LayoutUser.vue";

export default {
    props: ["products"],
    data() {
        return {
            item_code: "",
            product_code: "",
            name: "",
            price: "",
            qty: "",
            description: "",
            modalStatus: true,
        };
    },
    methods: {
        submitProduct() {
            const { item_code, product_code, name, price, qty, description } =
                this;
            axios
                .post("/submit-product", {
                    item_code,
                    product_code,
                    name,
                    price,
                    qty,
                    description,
                })
                .then(({ data }) => {
                    this.item_code = "";
                    this.product_code = "";
                    this.name = "";
                    this.price = "";
                    this.qty = "";
                    this.description = "";
                    this.$emit("success");
                });
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
            this.$router.push("/product");
        },
        deleteProduct(id) {
            axios.post("/delete-product", { id }).then(({ data }) => {
                this.emit("success");
            });
        },
    },
    components: { LayoutUser },
};
</script>
