<template>
    <OrderLayout>
        <div class="flex justify-between w-full">
            <div class="flex-6 p-4 w-4/6 relative">
                <div class="flex items-center mb-4">
                    <h2 class="text-2xl font-semibold">Categories</h2>
                    <SearchBar class="flex-1 mr-4" @search="handleSearch" />

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
                            <path stroke="none" d="M0 0h24v24H0z"></path>
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
                            <path stroke="none" d="M0 0h24v24H0z"></path>
                            <polyline points="9 6 15 12 9 18"></polyline>
                        </svg>
                    </button>
                </div>

                <!-- <div class="flex flex-wrap">
                    <div
                        v-for="category in visibleCategories"
                        :key="category.id"
                        class="w-1/5 p-2"
                    >
                        <div
                            class="bg-white shadow-md mb-4 category-item hover:bg-gray-100 cursor-pointer p-2 rounded-md"
                            @click="filterByCategory(category.id)"
                        >
                            <p>{{ category.name }}</p>
                        </div>
                    </div>
                </div> -->
                <div class="flex flex-wrap">
                    <div
                        v-for="category in visibleCategories"
                        :key="category.id"
                        class="w-1/5 p-2"
                    >
                        <div
                            class="bg -white shadow-md mb-4 category-item hover:bg-gray-100 cursor-pointer p-2 rounded-md"
                            @click="filterByCategory(category.id)"
                        >
                            <p>{{ category.name }}</p>
                        </div>
                    </div>
                </div>
                <div
                    v-if="filteredProducts.length === 0"
                    class="text-center p-4 text-red-500 dark:text-red-400"
                >
                    No products match your search.
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 lg:grid-cols-5 gap-2"
                >
                    <div
                        v-for="product in filteredProducts"
                        :key="product.id"
                        class="p-2 border border-gray-300 rounded-md text-center"
                    >
                        <div class="relative h-30">
                            <img
                                :src="product.image"
                                alt="Product Image"
                                class="w-40 h-40 object-cover rounded-md"
                            />
                        </div>
                        <h2 class="text-lg font-semibold mt-2">
                            {{ getProductNames(product.productlistId) }}
                        </h2>
                        <span class="text-lg font-bold text-green-500"
                            >Php {{ product.price }}.00</span
                        >
                        <div class="mt-2">
                            <button
                                @click="addCart(product)"
                                class="ml-2 bg-green-500 text-white px-5 py-1 rounded-md"
                            >
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 p-4">
                <div class="bg-gray-100 p-4 mb-4 rounded-md">
                    <h2 class="text-xl font-semibold mb-2">
                        Welcome Customer!
                    </h2>
                    <p class="text-gray-600">MMSU POS</p>
                </div>

                <h2 class="text-2xl font-semibold mb-4">Shopping Cart</h2>
                <div v-if="carts.length === 0" class="text-gray-600">
                    Your cart is empty.
                </div>
                <div v-else>
                    <div
                        v-for="product in carts"
                        :key="product.id"
                        class="flex items-center justify-between p-2 border-b"
                    >
                        <div class="flex items-center space-x-2">
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
                            >₱{{ product.price }}.00</span
                        >
                        <span class="text-gray-600"
                            >Total: ₱{{ product.total }}.00</span
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
                            >Total: Php {{ calculateTotal() }}.00</span
                        >
                    </div>
                </div>

                <div class="mb-4 mt-6">
                    <label for="paymentMethod" class="mr-2"
                        >Payment Method:</label
                    >
                    <div class="flex items-center space-x-4 mt-4">
                        <div
                            class="text-center payment-method-card border border-gray-300 rounded-md p-2 cursor-pointer"
                            @click="paymentMethod = '1'"
                            :class="{
                                'bg-green-100': paymentMethod === '1',
                            }"
                            style="width: 100%"
                        >
                            <span class="font-semibold">Cash</span>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-6">
                    <button
                        @click="checkOutOrder"
                        class="bg-green-600 text-white px-4 py-2 rounded-md flex items-center justify-center w-full md:w-50"
                    >
                        Checkout
                    </button>
                </div>
            </div>
        </div>

        <Receipt
            v-if="showReceiptModal"
            :receipt="receipt"
            @close="showReceiptModal = false"
        />
        <Toast />
    </OrderLayout>
</template>

<script>
import OrderLayout from "../../Layout/OrderLayout.vue";
import Receipt from "@/Component/PosComp/Receipt.vue";
import moment from "moment";
import Toast from "primevue/toast";
import SearchBar from "@/Component/Tools/SearchBar.vue";

export default {
    components: {
        Receipt,
        Toast,
        moment,
        SearchBar,
    },

    data() {
        return {
            products: [],
            productlists: [],
            carts: [],
            categories: [],
            currentPage: 0,
            itemsPerPage: 5,
            paymentMethod: "cash",
            amountGiven: 0,
            customerId: "",
            selectedCategory: null,
            showReceiptModal: false,
            receipt: null,
            searchQuery: "",
        };
    },
    methods: {
        addCart(product) {
            console.log("Adding to Cart:", product);
            const cartItem = {
                id: product.id,
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
            return this.carts.reduce((total, product) => {
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
                this.carts = data;
            });
        },

        checkOutOrder() {
            axios
                .post("/checkOutOrder", {
                    products: this.carts,
                })
                .then((response) => {
                    console.log("Cart submitted to admin:", response.data);
                    this.carts = [];
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Checkout Order successfully",
                        life: 4000,
                    });
                })
                .catch((error) => {
                    console.error("Error submitting to admin:", error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to check out order",
                        life: 4000,
                    });
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
            const start = (this.currentPage + 1) * this.itemsPerPage;
            if (start < this.categories.length) {
                this.currentPage += 1;
            }
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
        handleSearch(query) {
            this.searchQuery = query.trim().toLowerCase();
        },

        matchesProductSearch(product) {
            const productName = this.getProductNames(product.productlistId);
            return productName.toLowerCase().includes(this.searchQuery);
        },
    },
    computed: {
        visibleCategories() {
            const start = this.currentPage * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.categories.slice(start, end);
        },
        totalAmount() {
            return this.carts.reduce(
                (total, product) => total + product.total,
                0
            );
        },
        change() {
            return this.amountGiven - this.totalAmount;
        },
        filteredProducts() {
            if (this.selectedCategory) {
                return this.products.filter(
                    (product) => product.categoryId === this.selectedCategory
                );
            }
            return this.products.filter((product) =>
                this.matchesProductSearch(product)
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

<!-- <script>
import OrderLayout from "../../Layout/OrderLayout.vue";
import Receipt from "@/Component/PosComp/Receipt.vue";
import moment from "moment";
import Toast from "primevue/toast";
import SearchBar from "@/Component/Tools/SearchBar.vue";

export default {
    components: {
        Receipt,
        Toast,
        moment,
        SearchBar,
    },

    data() {
        return {
            products: [],
            productlists: [],
            carts: [],
            categories: [],
            currentPage: 0,
            itemsPerPage: 5,
            paymentMethod: "cash",
            amountGiven: 0,
            customerId: "",
            selectedCategory: null,
            showReceiptModal: false,
            receipt: null,
            searchQuery: "",
        };
    },
    methods: {
        addCart(product) {
            console.log("Adding to Cart:", product);
            const cartItem = {
                id: product.id,
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
            return this.carts.reduce((total, product) => {
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
                this.carts = data;
            });
        },

        checkOutOrder() {
            axios
                .post("/checkOutOrder", {
                    products: this.carts,
                })
                .then((response) => {
                    console.log("Cart submitted to admin:", response.data);
                    this.carts = [];
                    this.$toast.add({
                        severity: "success",
                        summary: "Success",
                        detail: "Checkout Order successfully",
                        life: 4000,
                    });
                })
                .catch((error) => {
                    console.error("Error submitting to admin:", error);
                    this.$toast.add({
                        severity: "error",
                        summary: "Error",
                        detail: "Failed to check out order",
                        life: 4000,
                    });
                });
        },

        // checkOutOrder() {
        //     axios
        //         .post("/checkOutOrder", {
        //             products: this.carts,
        //             customerId: this.customerId, // Assuming you have this data availabl
        //             paymentMethod: this.paymentMethod, // Assuming you have this data available
        //         })
        //         .then((response) => {
        //             console.log("Cart submitted to admin:", response.data);
        //             this.receipt = {
        //                 products: this.carts,
        //                 total: this.calculateTotal(),
        //                 customerId: this.customerId,
        //                 date: new Date().toLocaleString(), // Get the current date and time
        //                 paymentMethod: this.paymentMethod, // Assuming you have this data available
        //             };
        //             this.carts = [];
        //             this.showReceiptModal = true;
        //         });
        // },

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
            const start = (this.currentPage + 1) * this.itemsPerPage;
            if (start < this.categories.length) {
                this.currentPage += 1;
            }
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
        handleSearch(query) {
            this.searchQuery = query.trim().toLowerCase();
        },

        matchesProductSearch(product) {
            const productName = this.getProductNames(product.productlistId);
            return productName.toLowerCase().includes(this.searchQuery);
        },
    },
    computed: {
        visibleCategories() {
            const start = this.currentPage * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.categories.slice(start, end);
        },
        totalAmount() {
            return this.carts.reduce(
                (total, product) => total + product.total,
                0
            );
        },
        change() {
            return this.amountGiven - this.totalAmount;
        },
        filteredProducts() {
            if (this.selectedCategoryId) {
                return this.products.filter(
                    (product) => product.categoryId === this.selectedCategoryId
                );
            }
            return this.products.filter((product) =>
                this.matchesProductSearch(product)
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
</script> -->
