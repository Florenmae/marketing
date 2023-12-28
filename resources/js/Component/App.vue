<template>
    <Layout :authenticated="this.authenticated">
        <User></User>
    </Layout>
</template>

<script>
import Layout from "../Layout/Layout.vue";
// import User from "./User.vue";
// import Category from "../Component/Category.vue";
// import Product from "../Component/Product.vue";

export default {
    components: {
        Layout,
    },
    data() {
        return {
            authenticated: 0,
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
    },
    mounted() {
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
