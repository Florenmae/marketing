<template>
    <Layout :authenticated="this.authenticated">
        <!-- <User :userData="userData"></User>
        <Category :categoryData="categoryData"></Category>
        <Product :productData="productData"></Product> -->
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
import User from "./User.vue";
import Category from "../Component/Category.vue";
import Product from "../Component/Product.vue";

export default {
    components: {
        Layout,
        User,
        Category,
        Product,
    },
    data() {
        return {
            authenticated: 0,
            userData: [],
            categoryData: [],
            productData: [],
        };
    },
    methods: {
        //check user if authenticated
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
        fetchData() {
            axios.get("/get-users").then(({ data }) => {
                this.userData = data;
            });

            axios.get("/get-categories").then(({ data }) => {
                this.categoryData = data;
            });

            axios.get("/get-products").then(({ data }) => {
                this.productData = data;
            });
        },
    },
    mounted() {
        this.checkAuth();
        this.fetchData();
    },

    watch: {
        authenticated(newValue) {
            if (!newValue) {
                this.$router.push("/");
            }
        },
    },
};
</script>
