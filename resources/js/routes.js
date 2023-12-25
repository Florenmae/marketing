import App from "@/Component/App.vue";
import User from "@/Component/User.vue";
import Product from "@/Component/Product.vue";

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
        path: "/user",
        name: "user",
        component: User,
    },
    {
        path: "/product",
        name: "product",
        component: Product,
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
    },
];
