<template>
    <userLayout>
        <div class="flex justify-between w-full">
            <div class="flex-3 p-4 relative">
                <h2 class="text-2xl font-semibold mb-4">Categories</h2>
                <div class="absolute top-10 right-3 mt-2 mr-2">
                    <button @click="prevPage" class="text-gray-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                        >
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <polyline points="15 6 9 12 15 18"></polyline>
                        </svg>
                    </button>
                    <button @click="nextPage" class="text-gray-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="h-6 w-6"
                        >
                            <path
                                stroke="none"
                                d="M0 0h24v24H0z"
                                fill="none"
                            ></path>
                            <polyline points="15 6 9 12 15 18"></polyline>
                        </svg>
                    </button>
                </div>
                <div class="flex flex-wrap">
                    <div
                        v-for="category in visibleCategories"
                        :key="category.id"
                        class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-2"
                    >
                        <div
                            class="bg-white shadow-md mb-4 category-item hover:bg-gray-100 cursor-pointer p-2 rounded-md"
                        >
                            <p class="">{{ category.name }}</p>
                        </div>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2"
                >
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="p-2 border rounded-md text-center"
                    >
                        <img
                            :src="product.image"
                            alt="Product Image"
                            class="w-full h-32 object-cover mb-2 rounded-md"
                        />
                        <h2 class="text-lg font-semibold">
                            {{ getProductName(product.productlistId) }}
                            <span class="text-lg font-bold text-green-500"
                                >Php {{ product.price }}.00</span
                            >
                        </h2>
                        <div class="mt-2">
                            <button
                                @click="addToCart(product)"
                                class="ml-2 bg-green-500 text-white px-5 py-1 rounded-md"
                            >
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-4">
                <h2 class="text-2xl font-semibold mb-4">Delivery Cart</h2>
                <div v-if="deliverycarts.length === 0" class="text-gray-600">
                    Your cart is empty.
                </div>
                <div v-else>
                    <div
                        v-for="product in deliverycarts"
                        :key="product.id"
                        class="flex items-center justify-between p-2 border-b"
                    >
                        <div class="flex items-center space-x-4">
                            <span>
                                {{
                                    getProductName(product.productlistId)
                                }}</span
                            >
                        </div>

                        <div class="flex items-center space-x-0">
                            <button
                                @click="decrementQuantity(product)"
                                class="px-2 py-1 border rounded-none"
                            >
                                -
                            </button>
                            <span class="px-4 py-1 border-t border-b">{{
                                product.qty
                            }}</span>
                            <button
                                @click="incrementQuantity(product)"
                                class="px-2 py-1 border rounded-none"
                            >
                                +
                            </button>
                        </div>
                        <span class="font-semibold"
                            >Php {{ product.price.toFixed(2) }}</span
                        >
                        <!-- <span class="text-gray-600"
                            >Total: Php {{ product.total.toFixed(2) }}</span
                        > -->
                        <button @click="deleteItem(product.id)">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                class="bi bi-trash"
                                viewBox="0 0 16 16"
                            >
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"
                                />
                                <path
                                    fill-rule="evenodd"
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="font-semibold"
                            >Total: Php {{ calculateTotal().toFixed(2) }}</span
                        >
                        <button
                            @click="submitToAdmin"
                            class="bg-green-500 text-white px-4 py-1 rounded-md"
                        >
                            Deliver
                        </button>
                        <!-- <SendToAdmin :product="product" /> -->
                    </div>
                </div>
            </div>
        </div>
    </userLayout>
</template>

<script>
import Modal from "@/Component/Modal.vue";
import addProduct from "@/Component/User/UserInventory/addProduct.vue";
import SendToAdmin from "@/Component/User/UserInventory/SendToAdmin.vue";

export default {
    components: {
        Modal,
        addProduct,
        SendToAdmin,
    },
    data() {
        return {
            products: [],
            deliverycarts: [],
            cart: [],
            categories: [],
            currentPage: 0,
            itemsPerPage: 4,
            paymentMethod: "cash",
            amountGiven: 0,
            status: 0,
            productlists: [],
        };
    },
    methods: {
        addToCart(product) {
            console.log("Adding to Cart:", product);
            axios
                .post("/add-Cart", {
                    id: product.id,
                    productlistId: product.productlistId,
                    categoryId: product.categoryId,
                    userId: product.userId,
                    image: product.image,
                    price: product.price,
                    qty: 1,
                    description: product.description,
                    total: product.price * 1,
                })
                .then((data) => {
                    this.showCartItems();
                });
        },

        submitToAdmin() {
            axios
                .post("/submit-to-admin", {
                    products: this.deliverycarts,
                })
                .then((response) => {
                    console.log("Cart submitted to admin:", response.data);
                    this.deliverycarts = [];
                })
                .catch((error) => {
                    console.error("Error submitting cart to admin:", error);
                });
        },

        calculateTotal() {
            return this.deliverycarts.reduce((price, product) => {
                return price + product.price;
            }, 0);
        },
        incrementQuantity(product) {
            product.qty = Math.max(1, product.qty + 1);
        },

        decrementQuantity(product) {
            product.qty = Math.max(1, product.qty - 1);
        },

        showCartItems() {
            axios.get("/showCartItems").then(({ data }) => {
                this.deliverycarts = data;
            });
        },

        async fetchProducts() {
            try {
                const { data } = await axios.get("/get-productsUser");
                this.products = data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        },

        getProductlists() {
            axios.get("/getproductlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (b) => b.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },

        fetchCategories() {
            axios.get("/fetch-categories").then(({ data }) => {
                this.categories = data;
            });
        },
        nextPage() {
            this.currentPage += 1;
        },
        prevPage() {
            this.currentPage = Math.max(0, this.currentPage - 1);
        },

        deleteItem(id) {
            axios.post("/delete-item", { id }).then(({ data }) => {
                this.showCartItems();
            });
        },
    },
    computed: {
        visibleCategories() {
            const start = this.currentPage * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.categories.slice(start, end);
        },
        totalAmount() {
            return this.deliveryCart.reduce(
                (total, product) => total + product.total,
                0
            );
        },
        change() {
            return this.amountGiven - this.totalAmount;
        },
    },

    mounted() {
        this.fetchProducts();
        this.showCartItems();
        this.fetchCategories();
        this.getProductlists();
    },
};
</script>
