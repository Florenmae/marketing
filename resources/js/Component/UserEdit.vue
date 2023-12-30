<template>
    <Layout>
        <div class="">
            <form @submit.prevent="updateUser" class="p-4 md:p-5">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2 border-red-500">
                        <label
                            for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Name</label
                        >
                        <input
                            v-model="data.name"
                            type="text"
                            id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required
                        />
                    </div>
                    <div class="col-span-2 border-red-500">
                        <label
                            for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Email</label
                        >
                        <input
                            v-model="data.email"
                            type="text"
                            id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required
                        />
                    </div>
                    <div class="col-span-2">
                        <label
                            for="role"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Select a Role</label
                        >
                        <select
                            v-model="data.role"
                            id="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="IGP">IGP</option>
                            <option value="Project">Project</option>
                            <option value="Empployee">Employee</option>
                        </select>
                    </div>
                </div>
                <button
                    type="submit"
                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <svg
                        class="me-0 -ms-1 w-2 h-5"
                        fill="currentColor"
                        viewBox="0 0 10 10"
                        xmlns="http://www.w3.org/2000/svg"
                    ></svg>
                    Update User
                </button>
            </form>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            id: 0,
            edit_id: 0,
            data: {
                name: "",
                email: "",
                role: "",
            },
        };
    },
    methods: {
        getUser() {
            const { edit_id } = this;
            axios.get("/get-user", { edit_id }).then(({ data }) => {
                this.data = data;
            });
        },
        updateUser() {
            const { data } = this;
            axios.post("/update-user", { data }).then(({ data }) => {
                this.data = {
                    name: "",
                    email: "",
                    role: "",
                };
                this.$router.push("/user");
            });
        },
    },
    mounted() {
        this.edit_id = this.id;
        this.getUser();
    },
};
</script>
