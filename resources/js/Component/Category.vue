<template>
    <Layout>
        <button
            v-if="modalStatus"
            data-modal-target="crud-modal"
            data-modal-toggle="crud-modal"
            class="fixed top-20 right-10 block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button"
            @click="changeModalStatus"
        >
            Add Category
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
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
                    >
                        <h3
                            class="text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            Create Category
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
                    <form @submit.prevent="submitCategory" class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 border-red-500">
                                <label
                                    for="cat_code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Category Code</label
                                >
                                <input
                                    v-model="cat_code"
                                    type="text"
                                    name="cat_code"
                                    id="cat_code"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="cat_code"
                                    required=""
                                />
                            </div>
                            <div class="col-span-2 border-red-500">
                                <label
                                    for="categoryName"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Category Name</label
                                >
                                <input
                                    v-model="categoryName"
                                    type="text"
                                    name="categoryName"
                                    id="categoryName"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="categoryName"
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
                            Add Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Product Category</th>
                        <th scope="col" class="px-6 py-3">
                            Category <Code></Code>
                        </th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="cat in cats"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ cat.categoryName }}
                        </th>
                        <td class="px-6 py-4">{{ cat.cat_code }}</td>
                        <td class="px-6 py-4">
                            <a
                                href="#"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                >Edit</a
                            >
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Layout>
</template>

<script>
export default {
    data() {
        return {
            cat_code: "",
            categoryName: "",
            modalStatus: true,
            cats: [],
        };
    },
    methods: {
        submitCategory() {
            const { cat_code, categoryName } = this;
            axios
                .post("/submit-category", { cat_code, categoryName })
                .then(({ data }) => {
                    (this.cat_code = ""),
                        (this.categoryName = ""),
                        this.$emit("success");
                });
        },
        changeModalStatus() {
            this.modalStatus = !this.modalStatus;
        },
        getCats() {
            axios.get("/get-cats").then(({ data }) => {
                this.cats = data;
            });
        },
    },
    mounted() {
        this.getCats;
    },
};
</script>
