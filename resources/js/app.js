import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import App from "@/Component/App.vue";
import Modal from "@/Component/Modal.vue";
import Modal1 from "@/Component/Modal1.vue";

import User from "@/Component/Marketing/UserAdmin/User.vue";
import addUser from "@/Component/Marketing/UserAdmin/addUser.vue";
import EditUser from "@/Component/Marketing/UserAdmin/EditUser.vue";

import Product from "@/Component/Marketing/Inventory/Product.vue";
import ProductList from "@/Component/Marketing/Inventory/ProductList.vue";
import editProduct from "@/Component/Marketing/Inventory/editProduct.vue";


import Transaction from "@/Component/Marketing/Inventory/Transaction.vue";
import OrderList from "@/Component/Marketing/Inventory/OrderList.vue";

import Category from "@/Component/Marketing/Inventory/Category.vue";
import editCategory from "@/Component/Marketing/Inventory/editCategory.vue";
import addCategory from "@/Component/Marketing/Inventory/addCategory.vue";

import Pos from "@/Component/PosComp/Pos.vue";
import Orders from "@/Component/PosComp/Orders.vue";
//import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
// import View from "@/Component/PosComp/View.vue";

import userHome from "@/Component/userHome.vue";
import userProduct from "@/Component/User/UserInventory/userProduct.vue";
import addProduct from "@/Component/User/UserInventory/addProduct.vue";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout from "@/Layout/Layout.vue";
import userLayout from "@/Layout/userLayout.vue";
import PosLayout from "@/Layout/PosLayout.vue";

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const app = createApp({});

app.use(router);

app.component("app", App);

app.component("User", User);
app.component("EditUser", EditUser);
app.component("addUser", addUser);

app.component("product", Product);
app.component("productlist", ProductList);
app.component("editproduct", editProduct);

app.component("transaction", Transaction);
app.component("orderlist", OrderList);

app.component("category", Category);
app.component("editcategory", editCategory);
app.component("addcategory", addCategory);

// app.component("return", Return);
// app.component("editreturn", editReturn);
// app.component("addreturn", addReturn);
// app.component("returnForm", returnForm);

app.component("modal", Modal);
app.component("modal1", Modal1);

app.component("pos", Pos);
app.component("orders", Orders);
// app.component("viewOrder", ViewOrder);
// app.component("view", View);

app.component("userHome", userHome);
app.component("userProduct", userProduct);
app.component("addProduct", addProduct);

app.component("Layout", Layout);
app.component("userLayout", userLayout);
app.component("posLayout", PosLayout);

app.mount("#app");
