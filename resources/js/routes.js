import App from "@/Component/App.vue";

import User from "@/Component/Marketing/UserAdmin/User.vue";

import Category from "@/Component/Marketing/Inventory/Category.vue";

import Product from "@/Component/Marketing/Inventory/Product.vue";
// import ProductList from "@/Component/ProdComp/ProductList.vue";
// import OrderList from "@/Component/ProdComp/OrderList.vue";

// import Transaction from "@/Component/ProdComp/Transaction.vue";

// import Return from "@/Component/ProdComp/Return.vue";
// import returnForm from "@/Component/ProdComp/returnForm.vue";
// import addReturn from "@/Component/ProdComp/addReturn.vue";

import userProduct from "@/Component/User/UserInventory/userProduct.vue";
// import addProductUser from "@/Component/UserDashboard/addProductUser.vue";

// import Pos from "@/Component/PosComp/Pos.vue";
// import Orders from "@/Component/PosComp/Orders.vue";
// import ViewOrder from "@/Component/PosComp/ViewOrder.vue";
// import View from "@/Component/PosComp/View.vue";

import userHome from "@/Component/userHome.vue";
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
    // {
    //     path: "/transaction",
    //     name: "transaction",
    //     component: Transaction,
    // },
    // {
    //     path: "/productlist",
    //     name: "productlist",
    //     component: ProductList,
    // },
    // {
    //     path: "/orderlist",
    //     name: "orderlist",
    //     component: OrderList,
    // },
    {
        path: "/userProduct",
        name: "userProduct",
        component: userProduct,
    },

    // {
    //     path: "/returnForm",
    //     name: "returnForm",
    //     component: returnForm,
    // },
    // {
    //     path: "/return",
    //     name: "return",
    //     component: Return,
    // },
    // {
    //     path: "/addReturn",
    //     name: "addReturn",
    //     component: addReturn,
    // },
    // {
    //     path: "/pos",
    //     name: "pos",
    //     component: Pos,
    // },
    // {
    //     path: "/orders",
    //     name: "orders",
    //     component: Orders,
    // },
    // {
    //     path: "/view",
    //     name: "view",
    //     component: View,
    // },
    // {
    //     path: "/vieworder",
    //     name: "vieworder",
    //     component: ViewOrder,
    // },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
];
