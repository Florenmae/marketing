<template>
    <Layout :authenticated="this.authenticated">
        <AdminDashboard />
        <User :users="users" @success="getter" />
        <Products :products="products" @success="getter" />
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
import User from "./User.vue";
import Product from "../Component/Product.vue";

export default {
    components: {
        Layout,
        User,
        Product,
    },
    data() {
        return {
            authenticated: 0,
            // is_admin: 1,
            user: [],
            product: [],
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
        getter() {
            axios.get("/get-users").then(({ data }) => {
                console.log(data);
                this.user = data;
            });
        },

        getter() {
            axios.get("/get-products").then(({ data }) => {
                console.log(data);
                this.product = data;
            });
        },

        editSuccess() {
            this.getter();
        },
    },
    mounted() {
        this.getter();
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
