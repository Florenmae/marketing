<template>
    <Modal
        :modalContent="{
            title: 'Edit User',
            content: 'Please edit the user details',
            disablebtn: false,
        }"
        :buttonLabel="'Edit'"
        :cancelLabel="'Close'"
        :saveLabel="'Update'"
        @save="updateExistingUser"
        :save-option="true"
    >
        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2 border-red-500">
                <label
                    for="name"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Name</label
                >
                <input
                    v-model="user.name"
                    type="text"
                    name="name"
                    id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Name"
                />
            </div>
            <div class="col-span-2 border-red-500">
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Email</label
                >
                <input
                    v-model="user.email"
                    type="text"
                    name="email"
                    id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Email"
                />
            </div>
            <div class="col-span-2">
                <label
                    for="role"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Select a Role</label
                >
                <select
                    v-model="user.role"
                    name="role"
                    id="role"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Select a role"
                >
                    <option selected>Choose a role</option>
                    <option value="admin">admin</option>
                    <option value="IGP">IGP</option>
                    <option value="Project">Project</option>
                    <option value="Employee">Employee</option>
                </select>
            </div>
        </div>
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
            editingUserId: this.user.id,
            editedUser: {
                name: "",
                email: "",
                role: "",
            },
        };
    },
    watch: {
        user: {
            handler(newVal) {
                this.editedUser = { ...newVal };
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        updateExistingUser() {
            const { editedUser, editingUserId } = this;
            const userPayload = { ...editedUser };
            console.log(userPayload);
            delete userPayload.password;

            axios
                .post("/update-user", { userPayload, editingUserId })
                .then(({ data }) => {})
                .catch((error) => {
                    console.error("Error updating user:", error);
                });
        },
    },
    mounted() {
        // console.log(this.user.id);
    },
};
</script>
