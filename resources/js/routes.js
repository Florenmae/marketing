import App from "@/Component/App.vue";
import MainUser from "@/Component/UserComp/MainUser.vue";
import Category from "@/Component/ProdComp/Category.vue";
import Product from "@/Component/ProdComp/Product.vue";
import Return from "@/Component/ProdComp/Return.vue";
import returnForm from "@/Component/ProdComp/returnForm.vue";
import addReturn from "@/Component/ProdComp/addReturn.vue";
import userProduct from "@/Component/UserDashboard/userProduct.vue";
import Pos from "@/Component/PosComp/Pos.vue";

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
        path: "/MainUser",
        name: "MainUser",
        component: MainUser,
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
        path: "/userProduct",
        name: "userProduct",
        component: userProduct,
    },
    {
        path: "/returnForm",
        name: "returnForm",
        component: returnForm,
    },
    {
        path: "/return",
        name: "return",
        component: Return,
    },
    {
        path: "/addReturn",
        name: "addReturn",
        component: addReturn,
    },
    {
        path: "/pos",
        name: "pos",
        component: Pos,
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
];
