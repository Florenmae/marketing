<template>
    <Layout :authenticated="this.authenticated">
        <User :users="users" @success="getUsers" :key="index" />
        <Category :category="category" />
        <Product :products="products" />
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
import User from "./User.vue";
import Category from "../Component/Category.vue";
import Product from "../Component/Product.vue";

export default {
    props: ["products"],
    components: {
        Layout,
        User,
        Category,
        Product,
    },
    data() {
        return {
            authenticated: 0,
            users: [],
            category: [],
            products: [],
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
        //get User
        getUsers() {
            axios.get("/get-users").then(({ data }) => {
                console.log(data);
                this.users = data;
            });
        },

        // getter() {
        //     axios.get("/get-products").then(({ data }) => {
        //         console.log(data);
        //         this.products = data;
        //     });
        // },

        editSuccess() {
            this.getUsers();
        },
    },
    mounted() {
        this.getUsers();
        this.checkAuth();
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
