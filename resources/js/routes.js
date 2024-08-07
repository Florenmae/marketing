import App from "@/Component/App.vue";

import User from "@/Component/Marketing/UserAdmin/User.vue";

import Category from "@/Component/Marketing/Inventory/Category.vue";

import Product from "@/Component/Marketing/Inventory/Product.vue";
import ProductList from "@/Component/Marketing/Inventory/ProductList.vue";
import OrderList from "@/Component/Marketing/Inventory/OrderList.vue";
import SalesReport from "@/Component/Marketing/Inventory/SalesReport.vue";

import Transaction from "@/Component/Marketing/Inventory/Transaction.vue";
import UserTransaction from "@/Component/User/UserInventory/UserTransaction.vue";
import UserSalesReport from "@/Component/User/UserInventory/UserSalesReport.vue";

import CashReg from "@/Component/Marketing/Cash/CashReg.vue";

import Return from "@/Component/Marketing/Inventory/Return.vue";
import ReturnList from "@/Component/Marketing/Inventory/ReturnList.vue";
import userReturnlist from "@/Component/User/UserInventory/userReturnlist.vue";
import InventoryReport from "@/Component/User/UserInventory/InventoryReport.vue";

import userProduct from "@/Component/User/UserInventory/userProduct.vue";
import userProductList from "@/Component/User/UserInventory/userProductList.vue";
// import addProductUser from "@/Component/UserDashboard/addProductUser.vue";

import Pos from "@/Component/PosComp/Pos.vue";
import Orders from "@/Component/PosComp/Orders.vue";
// import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
// import View from "@/Component/PosComp/View.vue";

import pendingOrder from "@/Component/OnlineOrder/pendingOrder.vue";
import UserOrders from "@/Component/OnlineOrder/UserOrders.vue";

import userHome from "@/Component/userHome.vue";
import orderDashboard from "@/Component/OnlineOrder/orderDashboard.vue";
import Login from "@/Pages/Login.vue";
import Signup from "@/Pages/Signup.vue";

export const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },
    {
        path: "/home",
        name: "home",
        component: App,
    },
    {
        path: "/userHome",
        name: "userHome",
        component: userHome,
    },
    {
        path: "/orderDashboard",
        name: "orderDashboard",
        component: orderDashboard,
    },
    {
        path: "/user",
        name: "user",
        component: User,
    },
    {
        path: "/category",
        name: "category",
        component: Category,
    },
    {
        path: "/product",
        name: "product",
        component: Product,
    },

    {
        path: "/transaction",
        name: "transaction",
        component: Transaction,
    },
    {
        path: "/salesreport",
        name: "salesreport",
        component: SalesReport,
    },
    {
        path: "/usertransaction",
        name: "usertransaction",
        component: UserTransaction,
    },
    {
        path: "/usersalesreport",
        name: "usersalesreport",
        component: UserSalesReport,
    },

    {
        path: "/cashreg",
        name: "cashreg",
        component: CashReg,
    },
    {
        path: "/productlist",
        name: "productlist",
        component: ProductList,
    },
    {
        path: "/orderlist",
        name: "orderlist",
        component: OrderList,
    },
    {
        path: "/userProduct",
        name: "userProduct",
        component: userProduct,
    },
    {
        path: "/userProductList",
        name: "userProductList",
        component: userProductList,
    },
    {
        path: "/InventoryReport",
        name: "InventoryReport",
        component: InventoryReport,
    },
    {
        path: "/return",
        name: "return",
        component: Return,
    },
    {
        path: "/returnlist",
        name: "returnlist",
        component: ReturnList,
    },
    {
        path: "/userReturnlist",
        name: "userReturnlist",
        component: userReturnlist,
    },
    {
        path: "/pos",
        name: "pos",
        component: Pos,
    },
    {
        path: "/orders",
        name: "orders",
        component: Orders,
    },
    {
        path: "/UserOrders",
        name: "UserOrders",
        component: UserOrders,
    },
    {
        path: "/pendingOrder",
        name: "pendingOrder",
        component: pendingOrder,
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
];
