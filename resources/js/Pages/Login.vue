<template lang="">
    <section
        class="flex flex-col items-center justify-center h-screen dark:bg-gray-900"
    >
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:py-10 lg:py-12"
        >
            <a
                href="#"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
            >
                <img
                    class="w-8 h-8 mr-2"
                    src="../../../public/mmsu_logo.png"
                    alt="logo"
                />
                Marketing
            </a>
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                    >
                        Sign in to your account
                    </h1>

                    <div
                        v-if="errorMsg != ''"
                        class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                        role="alert"
                    >
                        <span class="font-medium">Log in failed!</span>
                        {{ errorMsg }}
                    </div>
                    <form
                        class="space-y-4 md:space-y-6"
                        action="#"
                        @submit.prevent="login"
                        @click="clearErrMsg"
                    >
                        <div>
                            <label
                                for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Your email</label
                            >
                            <input
                                v-model="email"
                                type="email"
                                name="email"
                                id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com"
                                required=""
                            />
                        </div>
                        <div>
                            <label
                                for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >Password</label
                            >
                            <input
                                v-model="password"
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required=""
                            />
                        </div>

                        <button
                            type="submit"
                            class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: "",
            message: this.$route.query.messageSent,
            errorMsg: "",
        };
    },
    methods: {
        login() {
            const { email, password } = this;
            axios
                .post("/login", { email, password })
                .then((res) => {
                    if (res.status === 200) {
                        console.log(res);
                        console.log("User Role:", res.data.roleId);
                        if (res.data.roleId === "1") {
                            this.$router.push("/home");
                        } else if (res.data.roleId === "2" && "3") {
                            this.$router.push("/userHome");
                        } else {
                            this.$router.push("/orderDashboard");
                        }
                    }
                })
                .catch((err) => {
                    this.errorMsg = err.response.data.message;
                });
        },
        clearErrMsg() {
            this.errorMsg = "";
        },
    },
};
</script>
