<template>
    <Layout>
        <addUser class="justify self-end"></addUser>
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-2">Name</th>
                    <th scope="col" class="px-6 py-2">Role</th>
                    <th scope="col" class="px-6 py-2">Email</th>
                    <th scope="col" class="px-6 py-2">Action</th>
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
                    <td class="flex space-x-4 >">
                        <EditUser :user="user" />
                        <button
                            class="bg-red-500 px-4 py-2 rounded-md text-white my-4 text-sm hover:bg-green-600"
                            @click="deleteUser(user.id)"
                        >
                            Delete
                        </button>
                    </td>
                    <!-- <td class="">
                        <button
                            class="bg-red-500 py-2 px-4 rounded text-white"
                            @click="deleteUser(user.id)"
                        >
                            Delete
                        </button>
                    </td> -->
                </tr>
            </tbody>
        </table>
    </Layout>
</template>

<script>
import axios from "axios";
import Modal from "@/Component/Modal.vue";
import EditUser from "@/Component/UserComp/EditUser.vue";
import addUser from "@/Component/UserComp/addUser.vue";

export default {
    components: {
        Modal,
        EditUser,
        addUser,
    },
    data() {
        return {
            modalStatus: false,
            users: [],
            editedUser: {
                name: "",
                email: "",
                role: "",
                password: "",
            },
            editingUserId: null,
            modalContent: {
                title: "Create New User",
                content: "Please fill in the user details",
                disablebtn: false,
            },
        };
    },

    methods: {
        submitUser() {
            const { editedUser } = this;

            const userPayload = {
                ...editedUser,
            };

            axios
                .post("/submit-user", userPayload)
                .then(({ data }) => {
                    this.getUsers();
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error submitting user:", error);
                });
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },
        getUsers() {
            axios
                .get("/get-users")
                .then(({ data }) => {
                    this.users = data;
                    console.log(data);
                })
                .catch((error) => {
                    console.error("Error fetching users:", error);
                });
        },
        updateExistingUser(data) {
            const { editedUser, editingUserId } = this;
            const userPayload = { ...editedUser };
            delete userPayload.password;

            axios
                .post("/update-user", { userPayload, editingUserId })
                .then(({ data }) => {
                    this.getUsers();
                    this.changeModalStatus();
                })
                .catch((error) => {
                    console.error("Error updating user:", error);
                });
        },

        editUser(user) {
            this.editedUser = { ...user };
            this.editingUserId = user.id;
            this.modalContent.title = "Edit User";
            this.modalStatus = true;
        },

        deleteUser(id) {
            axios
                .post("/delete-user", { id })
                .then(({ data }) => {
                    this.getUsers();
                })
                .catch((error) => {
                    console.error("Error deleting user:", error);
                });
        },
        clearForm() {
            this.editedUser = {
                name: "",
                email: "",
                role: "",
                password: "",
            };
            this.changeModalStatus();
            this.editingUserId = null;
        },
    },
    mounted() {
        this.getUsers();
    },
};
</script>
