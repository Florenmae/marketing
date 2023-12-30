import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import App from "@/Component/App.vue";
import User from "@/Component/User.vue";
import UserEdit from "@/Component/UserEdit.vue";
import Category from "@/Component/Category.vue";
import Product from "@/Component/Product.vue";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout from "@/Layout/Layout.vue";
import LayoutUser from "@/Layout/LayoutUser.vue";
// import LayoutAdmin from "@/layout/LayoutAdmin.vue";
// import LayoutProducts from "@/layout/LayoutProducts.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);

app.component("app", App);
app.component("user", User);
app.component("userEdit", UserEdit);
app.component("product", Product);
app.component("category", Category);
app.component("Layout", Layout);
app.component("LayoutUser", LayoutUser);
// app.component("LayoutAdmin", LayoutAdmin);
// app.component("LayoutProducts", LayoutProducts);

app.mount("#app");
