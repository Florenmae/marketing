<template>
    <Modal
        :modalContent="modalContent"
        :buttonLabel="'Add User'"
        :cancelLabel="'Cancel'"
        :saveLabel="'Save'"
        @save="submitUser"
        :save-option="true"
    >
        <form @submit.prevent="submitUser">
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
                        id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Email"
                        required
                    />
                </div>
                <div class="col-span-2">
                    <label
                        for="roleId"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Select a Role</label
                    >
                    <select
                        v-model="editedUser.roleId"
                        id="roleId"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Select a role"
                        required
                    >
                        <option selected>Choose a role</option>
                        <option value="1">admin</option>
                        <option value="2">IGP</option>
                        <option value="3">Project</option>
                        <option value="4">Employee</option>
                        <option value="5">Customer</option>
                    </select>
                </div>
                <div class="col-span-2 border-red-500">
                    <label
                        for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Temporary Password</label
                    >
                    <input
                        v-model="editedUser.password"
                        type="text"
                        id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Type Temporary Password"
                        required=""
                    />
                </div>
            </div>
        </form>
    </Modal>
</template>

<script>
import Modal from "@/Component/Modal.vue";
export default {
    props: ["user"],
    components: {
        Modal,
    },
    data() {
        return {
            editedUser: {
                name: "",
                email: "",
                roleId: "",
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

            const confirmed = window.confirm(
                "Are you sure you want to submit this user?"
            );

            if (confirmed) {
                axios.post("/submit-user", userPayload).then(({ data }) => {
                    this.$router.push("/user");
                    window.location.reload("Reloading");
                });
            }
        },
    },
};
</script>
