<template>
    <Layout>
        <div class="page-wrapper">
            <div class="lg:content">
                <div
                    class="fixed top-12 grid grid-cols-1 md:grid-cols-3 gap-4 mt-4"
                >
                    <div
                        class="bg-blue-500 text-white overflow-hidden shadow-md sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div
                                    class="ml-4 text-lg leading-7 font-semibold"
                                >
                                    <label>Total Users</label>
                                    <h1>{{ userCounts }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-green-500 text-white overflow-hidden shadow-md sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div
                                    class="ml-4 text-lg leading-7 font-semibold"
                                >
                                    Products
                                </div>
                            </div>
                            <div class="ml-12">
                                <div class="mt-2 text-sm">
                                    Total Products: {{ productCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-red-500 text-white overflow-hidden shadow-md sm:rounded-lg"
                    >
                        <div class="p-6">
                            <div class="flex items-center">
                                <div
                                    class="ml-4 text-lg leading-7 font-semibold"
                                >
                                    Categories
                                </div>
                            </div>
                            <div class="ml-12">
                                <div class="mt-2 text-sm">
                                    Total Categories: {{ categoryCount }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
import MainUser from "@/Component/UserComp/MainUser.vue";
import EditUser from "@/Component/UserComp/EditUser.vue";
import Product from "@/Component/ProdComp/Product.vue";
import Category from "@/Component/ProdComp/Category.vue";
import editProduct from "@/Component/ProdComp/editProduct.vue";
import editCategory from "@/Component/ProdComp/editCategory.vue";
import Modal from "../Component/Modal.vue";

export default {
    props: ["authenticated"],
    components: {
        Layout,
        MainUser,
        EditUser,
        Modal,
        Product,
        Category,
        editCategory,
        editProduct,
    },
    data() {
        return {
            authenticated: 0,
            userCounts: [],
            productCount: [],
            categoryCount: [],
        };
    },
    methods: {
        checkAuth() {
            axios.get("/checkUser").then(({ data }) => {
                console.log(data);
                this.authenticated = data;
                console.log(this.authenticated);
                if (this.authenticated == 0) {
                    this.$router.push("/");
                }
            });
        },
        editSuccess() {
            this.checkAuth();
        },

        getUserCount() {
            axios
                .get("/get-user-count")
                .then((response) => {
                    console.log("User count response:", response.data);
                    this.userCounts = response.data.count;
                })
                .catch((error) => {
                    console.error("Error fetching user count:", error);
                });
        },
        getProductCount() {
            axios.get("/get-product-count").then((response) => {
                console.log("Product count response:", response.data);
                this.productCount = response.data.count;
            });
        },
        getCategoryCount() {
            axios.get("/get-category-count").then((response) => {
                console.log("Category count response:", response.data);
                this.categoryCount = response.data.count;
            });
        },
    },
    mounted() {
        this.checkAuth();
        this.getUserCount();
        this.getProductCount();
        this.getCategoryCount();
    },
};
</script>
