<template>
    <OrderLayout>
        <div class="h-screen flex">
            <div class="flex-1 p-4 relative">
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
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-wrap">
                    <div
                        v-for="category in visibleCategories"
                        :key="category.id"
                        class="space-x-2 p-2"
                    >
                        <div
                            class="bg-white shadow-md mb-3 category-item hover:bg-gray-100 cursor-pointer p-2 rounded-md"
                            @click="filterByCategory(category.id)"
                            style="width: 200px"
                        >
                            <p>{{ category.name }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-5 space-x-2 p-2">
                    <div
                        v-for="product in filteredProducts"
                        :key="product.productlistId"
                        class="p-4 border rounded-md text-center"
                    >
                        <img
                            :src="product.image"
                            alt="Product Image"
                            class="w-full h-32 object-cover mb-2 rounded-md"
                        />
                        <h2 class="text-lg font-semibold">
                            {{ getProductNames(product.productlistId) }}
                        </h2>

                        <div class="mt-2">
                            <span class="text-lg font-bold text-blue-500">{{
                                product.price
                            }}</span>
                            <button
                                @click="addCart(product)"
                                class="ml-2 bg-green-500 text-white px-3 py-1 rounded-md"
                            >
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-2 p-4">
                <div class="h-full overflow-auto">
                    <div class="bg-gray-100 p-4 mb-4 rounded-md">
                        <h2 class="text-xl font-semibold mb-2">
                            Welcome Customer!
                        </h2>
                        <p class="text-gray-600">MMSU POS</p>
                    </div>

                    <h2 class="text-2xl font-semibold mb-4">Shopping Cart</h2>
                    <div v-if="cart.length === 0" class="text-gray-600">
                        Your cart is empty.
                    </div>
                    <div v-else>
                        <div
                            v-for="product in cart"
                            :key="product.productlistId"
                            class="flex items-center justify-between p-2 border-b"
                        >
                            <div class="flex items-center space-x-4">
                                <img
                                    :src="product.image"
                                    alt="Product Image"
                                    class="w-10 h-10 object-cover rounded-md"
                                />
                                <span>{{ product.name }}</span>
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
                                >Php{{ product.price }}.00</span
                            >
                            <span class="text-gray-600"
                                >Total: Php{{ product.total }}.00</span
                            >
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
                                >Total: Php
                                {{ calculateTotal().toFixed(2) }}</span
                            >
                        </div>
                    </div>

                    <div class="mb-4 mt-4">
                        <div class="mt-4 flex justify-between items-center">
                            <button
                                @click="checkOutOrder"
                                class="bg-green-500 text-white w-full py-2 rounded-md"
                            >
                                Checkout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </OrderLayout>
</template>

<script>
import OrderLayout from "../../Layout/OrderLayout.vue";

export default {
    data() {
        return {
            products: [],
            productlists: [],
            cart: [],
            categories: [],
            currentPage: 0,
            itemsPerPage: 4,
            paymentMethod: "cash",
            amountGiven: 0,
            customerId: "",
            selectedCustomerType: "",
            selectedCategory: null,
            showReceiptModal: false,
            receipt: {},
        };
    },
    methods: {
        addCart(product) {
            console.log("Adding to Cart:", product);
            const cartItem = {
                productlistId: product.productlistId,
                image: product.image,
                price: product.price,
                qty: 1,
                description: product.description,
                total: product.price * 1,
            };

            axios.post("/add-cart", cartItem).then((data) => {
                this.showCartItem();
            });
        },

        calculateTotal() {
            return this.cart.reduce((total, product) => {
                return total + product.total;
            }, 0);
        },
        incrementQuantity(product) {
            product.qty = Math.max(1, product.qty + 1);
            product.total = product.price * product.qty;
        },

        decrementQuantity(product) {
            product.qty = Math.max(1, product.qty - 1);
            product.total = product.price * product.qty;
        },

        showCartItem() {
            axios.get("/showCartItem").then(({ data }) => {
                this.cart = data;
            });
        },

        checkOutOrder() {
            axios
                .post("/checkOutOrder", {
                    products: this.cart,
                })
                .then((response) => {
                    console.log("Cart submitted to admin:", response.data);
                    this.cart = [];
                });
        },

        getProd() {
            axios.get("/getProd").then(({ data }) => {
                this.products = data;
            });
        },

        getProdlist() {
            axios.get("/getProdlist").then(({ data }) => {
                this.productlists = data;
            });
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
                this.showCartItem();
            });
        },
        filterByCategory(id) {
            if (this.selectedCategory === id) {
                this.selectedCategory = null;
            } else {
                this.selectedCategory = id;
            }
        },

        getProductNames(productlistId) {
            const productlist = this.productlists.find(
                (b) => b.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
        },
    },
    computed: {
        visibleCategories() {
            const start = this.currentPage * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.categories.slice(start, end);
        },
        totalAmount() {
            return this.cart.reduce(
                (total, product) => total + product.total,
                0
            );
        },
        change() {
            return this.amountGiven - this.totalAmount;
        },
        filteredProducts() {
            if (!this.selectedCategory) {
                return this.products;
            }
            return this.products.filter(
                (product) => product.categoryId === this.selectedCategory
            );
        },
    },

    mounted() {
        this.getProd();
        this.getProdlist();
        this.showCartItem();
        this.fetchCategories();
    },
};
</script>
