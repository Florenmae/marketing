import "./bootstrap";
import { createApp } from "vue/dist/vue.esm-bundler";
import "vue-toast-notification/dist/theme-default.css";

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

import userHome from "@/Component/userHome.vue";
import userProduct from "@/Component/User/UserInventory/userProduct.vue";
import addProduct from "@/Component/User/UserInventory/addProduct.vue";
import UserTransaction from "@/Component/User/UserInventory/UserTransaction.vue";

import Return from "@/Component/Marketing/Inventory/Return.vue";
import ReturnList from "@/Component/Marketing/Inventory/ReturnList.vue";
import userReturnlist from "@/Component/User/UserInventory/userReturnlist.vue";

import orderDashboard from "@/Component/OnlineOrder/orderDashboard.vue";

import pendingOrder from "@/Component/OnlineOrder/pendingOrder.vue";
import ApproveOrder from "@/Component/OnlineOrder/ApproveOrder.vue";

import Pagination from "@/Component/Tools/Pagination.vue";

import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

import Layout from "@/Layout/Layout.vue";
import userLayout from "@/Layout/userLayout.vue";
import PosLayout from "@/Layout/PosLayout.vue";
import OrderLayout from "@/Layout/OrderLayout.vue";

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
app.component("usertransaction", UserTransaction);
app.component("orderlist", OrderList);

app.component("category", Category);
app.component("editcategory", editCategory);
app.component("addcategory", addCategory);

app.component("return", Return);
app.component("returnlist", ReturnList);
app.component("userReturnlist", userReturnlist);

app.component("modal", Modal);
app.component("modal1", Modal1);

app.component("pos", Pos);
app.component("orders", Orders);

app.component("userHome", userHome);
app.component("userProduct", userProduct);
app.component("addProduct", addProduct);

app.component("orderDashboard", orderDashboard);

app.component("pendingOrder", pendingOrder);
app.component("ApproveOrder", ApproveOrder);

app.component("Layout", Layout);
app.component("userLayout", userLayout);
app.component("posLayout", PosLayout);
app.component("OrderLayout", OrderLayout);

app.component("Pagination", Pagination);

app.mount("#app");
