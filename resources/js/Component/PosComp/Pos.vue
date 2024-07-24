<template>
    <posLayout>
        <div class="flex justify-between w-full">
            <div class="flex-6 p-4 w-4/6 relative">
                <div class="flex items-center mb-4">
                    <h2 class="text-2xl font-semibold mb-2">Categories</h2>
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

                <div class="flex flex-wrap">
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
                            {{ getProductName(product.productlistId) }}
                        </h2>
                        <span class="text-lg font-bold text-green-500"
                            >Php {{ product.price }}.00</span
                        >
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
                <div class="bg-gray-100 p-4 mb-4 rounded-md">
                    <h2 class="text-xl font-semibold mb-2">
                        Welcome Customer!
                    </h2>
                    <p class="text-gray-600">MMSU POS</p>
                </div>

                <div class="mb-2 space-x-2 flex flex-col">
                    <label for="customerId" class="mb-1">Customer Type:</label>

                    <div class="flex items-center">
                        <select
                            v-model="selectedCustomerType"
                            id="customerId"
                            class="px-4 py-2 border border-gray-300 rounded-md w-full md:w-50"
                        >
                            <option value="1">Employee</option>
                            <option value="2">Walk-in Customer</option>
                        </select>
                    </div>
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
                        <Receipt
                            v-if="showReceiptModal"
                            :receipt="receipt"
                            ref="receiptModal"
                        />
                    </div>
                </div>
                <div class="mb-2 space-x-2 mt-4">
                    <div class="flex items-center">
                        <label for="amountGiven" class="mr-2"
                            >Amount Given:</label
                        >
                        <input
                            type="number"
                            v-model="amountGiven"
                            id="amountGiven"
                            class="px-4 py-2 border border-gray-300 rounded-md w-full md:w-40"
                        />
                        <div class="space-x-4">
                            <div v-if="amountGiven > totalAmount"></div>
                            <div v-if="change > 0" class="">
                                <span class="">Change:</span>
                                <span class="font-bold ml-2 text-green-500"
                                    >Php {{ change.toFixed(2) }}</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-6">
                    <label for="paymentMethod" class="mr-2"
                        >Payment Method:</label
                    >
                    <div
                        v-if="selectedCustomerType === '1'"
                        class="flex items-center space-x-4 mt-4"
                    >
                        <div
                            class="text-center payment-method-card border border-gray-300 rounded-md p-2 cursor-pointer"
                            @click="paymentMethod = '1'"
                            :class="{
                                'bg-green-100': paymentMethod === '1',
                            }"
                            style="width: 50%"
                        >
                            <span class="font-semibold">Cash</span>
                        </div>
                        <div
                            class="text-center payment-method-card border border-gray-300 rounded-md p-2 cursor-pointer"
                            @click="paymentMethod = '2'"
                            :class="{
                                'bg-green-100': paymentMethod === '2',
                            }"
                            style="width: 50%"
                        >
                            <span class="font-semibold">Credit</span>
                        </div>
                    </div>
                    <div
                        v-else-if="selectedCustomerType === '2'"
                        class="flex items-center space-x-4 mt-4"
                    >
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
                        @click="checkout"
                        class="bg-green-600 text-white px-4 py-2 rounded-md flex items-center justify-center w-full md:w-50"
                    >
                        Checkout
                    </button>
                </div>
                <Receipt
                    v-if="showReceiptModal"
                    :receipt="receipt"
                    @close="showReceiptModal = false"
                />
            </div>
        </div>
    </posLayout>
</template>

<script>
import Receipt from "@/Component/PosComp/Receipt.vue";
import Pagination from "@/Component/Tools/Pagination.vue";
import SearchBar from "@/Component/Tools/SearchBar.vue";
import moment from "moment";

export default {
    components: {
        Receipt,
        Pagination,
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
            selectedCustomerType: "",
            selectedCategory: null,
            showReceiptModal: false,
            orders: {},
            receipt: null,
            searchQuery: "",
            // pagination: {
            //     currentPage: 1,
            //     lastPage: 1,
            //     totalItems: 0,
            // },
        };
    },
    methods: {
        addToCart(product) {
            console.log("Adding to Cart:", product);
            axios
                .post("/addToCart", {
                    id: product.id,
                    productlistId: product.productlistId,
                    categoryId: product.categoryId,
                    customerId: this.selectedCustomerType,
                    userId: product.userId,
                    image: product.image,
                    price: product.price,
                    qty: 1,
                    description: product.description,
                    total: product.price * 1,
                })
                .then((data) => {
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

        checkout() {
            const originalCart = [...this.carts];
            const formattedDate = moment().format("MM-DD-YYYY");

            const orderPayload = {
                paymentMethod: this.paymentMethod,
                amountGiven: this.amountGiven,
                customerId: this.selectedCustomerType,
                created_at: formattedDate,
                items: this.carts.map((product) => ({
                    productId: product.productId,
                    productlistId: product.productlistId,
                    customerId: this.selectedCustomerType,
                    qty: product.qty,
                    price: product.price,
                    total: product.total,
                })),
            };

            axios
                .post("/checkout", orderPayload)
                .then((response) => {
                    const { status, remainingBalance, receipt } = response.data;
                    const change = this.amountGiven - this.calculateTotal();
                    this.carts = [];
                    this.amountGiven = 0;
                    this.receipt = {
                        paymentMethod: orderPayload.paymentMethod,
                        amountGiven: orderPayload.amountGiven,
                        totalAmount: this.calculateTotal(),
                        created_at: orderPayload.created_at,
                        customerId: orderPayload.customerId,
                        change: change,
                        items: orderPayload.items.map((item) => ({
                            productName: this.getProductName(
                                item.productlistId
                            ),
                            qty: item.qty,
                            total: item.total,
                            price: item.price,
                        })),
                    };
                    this.showReceiptModal = true;
                })
                .catch((error) => {
                    console.error("Error during checkout:", error);
                    this.carts = originalCart;
                });
        },

        fetchProducts() {
            axios
                .get("/getProducts", {
                    params: {
                        search: this.searchQuery,
                    },
                })
                .then(({ data }) => {
                    this.products = data;

                    console.log("Fetched products:", this.products); // Check if products are fetched
                })
                .catch((error) => {
                    console.error("Error fetching products:", error);
                });
        },

        fetchProductlists() {
            axios.get("/getproductlists").then(({ data }) => {
                this.productlists = data;
            });
        },

        getProductName(productlistId) {
            const productlist = this.productlists.find(
                (d) => d.id === productlistId
            );
            return productlist ? productlist.name : "Unknown product";
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
        handleSearch(query) {
            this.searchQuery = query;
            this.fetchProductlists();
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
        // filteredProducts() {
        //     if (!this.selectedCategory) {
        //         return this.products;
        //     }
        //     return this.products.filter(
        //         (product) => product.categoryId === this.selectedCategory
        //     );
        // },
        filteredProducts() {
            let filtered = this.products;

            if (this.selectedCategory !== null) {
                filtered = filtered.filter(
                    (product) => product.categoryId === this.selectedCategory
                );
            }

            if (this.searchQuery.trim() !== "") {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter((product) =>
                    this.getProductName(product.productlistId)
                        .toLowerCase()
                        .includes(query)
                );
            }

            return filtered.slice(
                this.currentPage * this.itemsPerPage,
                (this.currentPage + 1) * this.itemsPerPage
            );
        },
    },

    mounted() {
        this.fetchProducts();
        this.fetchProductlists();
        this.showCartItem();
        this.fetchCategories();
    },
};
</script>
