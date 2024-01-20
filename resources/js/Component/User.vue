<template>
    <Layout>
        <!-- Add User button -->
        <button
            v-if="modalStatus"
            data-modal-target="crud-modal"
            data-modal-toggle="crud-modal"
            class="fixed top-20 right-10 block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button"
            @click="addUser"
        >
            Add User
        </button>

        <!-- Main modal -->
        <div
            v-else
            id="crud-modal"
            tabindex="-1"
            aria-hidden="true"
            class="flex items-center justify-center h-screen w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
        >
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            {{
                                editingUserId ? "Edit User" : "Create New User"
                            }}
                        </h3>
                        <button
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal"
                            @click="changeModalStatus"
                        >
                            <svg
                                class="w-3 h-3"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 14 14"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                                />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="submitUser" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 border-red-500">
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Name</label
                                >
                                <input
                                    v-model="editedUser.name"
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Name"
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
                                    v-model="editedUser.email"
                                    type="text"
                                    name="email"
                                    id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Email"
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
                                    v-model="editedUser.role"
                                    name="role"
                                    id="role"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Select a role"
                                    required
                                >
                                    <option selected>Choose a role</option>
                                    <option value="admin">admin</option>
                                    <option value="IGP">IGP</option>
                                    <option value="Project">Project</option>
                                    <option value="Employee">Employee</option>
                                </select>
                            </div>
                            <div
                                v-if="isNewUser"
                                class="col-span-2 border-red-500"
                            >
                                <label
                                    for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Temporary Password</label
                                >
                                <input
                                    v-model="password"
                                    type="text"
                                    name="password"
                                    id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type Temporary Password"
                                    required=""
                                />
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            <svg
                                class="me-1 -ms-1 w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            {{ isNewUser ? "Add new user" : "Update User" }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="user in users"
                        :key="user.id"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ user.name }}
                        </th>
                        <td class="px-6 py-4">{{ user.role }}</td>
                        <td class="px-6 py-4">{{ user.email }}</td>
                        <td>
                            <a
                                @click="editUser(user)"
                                href="#"
                                class="bg-green-700 py-2 px-4 rounded text-white"
                                >Edit</a
                            >
                        </td>
                        <td class="py-4">
                            <button
                                class="bg-red-500 py-2 px-4 rounded text-white"
                                @click="deleteUser(user.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Layout>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            name: "",
            email: "",
            role: "",
            password: "",
            modalStatus: true,
            users: [],
            userData: [],
            editingUserId: null,
            editedUser: {
                id: null,
                name: "",
                email: "",
                role: "",
                password: "",
            },
        };
    },
    computed: {
        isNewUser() {
            return !this.editingUserId;
        },
    },
    methods: {
        submitUser() {
            const { editedUser, editingUserId, isNewUser, password } = this;
            const userPayload = {
                ...editedUser,
                ...(isNewUser ? { password } : {}),
            };

            if (editingUserId) {
                delete userPayload.password;
                axios
                    .post(`/update-user/${editingUserId}`, userPayload)
                    .then(({ data }) => {
                        this.clearForm();
                        this.changeModalStatus();
                        this.getUsers();
                    });
            } else {
                // Add new user
                axios.post("/submit-user", userPayload).then(({ data }) => {
                    this.clearForm();
                    this.changeModalStatus();
                    this.getUsers();
                    this.users.push(data);
                });
            }
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },
        getUsers() {
            axios.get("/get-users").then(({ data }) => {
                console.log(data);
                this.users = data;
            });
        },
        editUser(user) {
            this.editedUser = { ...user }; // Copy the user object to avoid modifying the original
            this.editingUserId = user.id;
            this.changeModalStatus();
        },
        deleteUser(id) {
            axios.post("/delete-user", { id }).then(({ data }) => {
                this.getUsers();
            });
        },
        addUser() {
            this.clearForm();
            this.changeModalStatus();
        },
        clearForm() {
            this.editedUser = {
                id: null,
                name: "",
                email: "",
                role: "",
                password: "",
            };
            this.editingUserId = null;
        },
    },
    mounted() {
        this.getUsers();
        // const userData = {  };
        // this.$emit("userData", userData);
    },
};
</script>
