<template>
    <Layout>
        <div class="h-screen flex">
            <div class="justify-center items-center">
                <div class="flex-1 py-10 items-center justify-center">
                    <div class="">
                        <label class="text-xl font-semibold"
                            >Cash On Hand:</label
                        >
                    </div>

                    <div
                        class="justify-center items-center bg-white border border-red-400 shadow-md sm:rounded-lg flex flex-col items-center w-full mt-4 mb-4"
                    >
                        <div class="p-6 flex flex-col items-center w-full">
                            <div
                                class="flex justify-between items-center w-full"
                            >
                                <div class="text-4xl leading-7 font-semibold">
                                    <div class="pb-1">
                                        <div class="text-5xl font-bold">
                                            {{ cashOnHand }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-center justify-center w-full"
                    >
                        <input
                            v-model="cashOnHand"
                            type="number"
                            class="border border-gray-300 rounded-md px-4 py-2 mb-2"
                            placeholder="Enter amount"
                        />
                        <div class="flex">
                            <button
                                @click="addCash"
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md mb-2 mr-2"
                            >
                                Add Cash
                            </button>
                            <button
                                @click="remitToAdmin"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md mb-2"
                            >
                                Remit To Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-l border-gray-300 mx-4"></div>
        </div>
    </Layout>
</template>

<script>
import Layout from "../../../Layout/Layout.vue";

export default {
    components: {
        Layout,
    },
    data() {
        return {
            cashOnHand: 0,
            newCash: 0,
            cashregs: [],
        };
    },
    methods: {
        getCash() {
            axios.get("/get-cash").then(({ data }) => {
                this.cashregs = data;
            });
        },

        addCash() {
            const { cashOnHand } = this;
            axios
                .post("/add-cash", { cashOnHand })
                .then(({ data }) => {
                    this.cashregs.push(data);
                    this.cashOnHand = 0;
                })
                .catch((error) => {
                    console.error("Error adding cash:", error);
                });
        },

        remitToAdmin() {
            this.cashOnHand = 0;
        },
    },

    mounted() {
        this.getCash();
    },
};
</script>

<style>
/* If you need custom styles, you can place them here */
</style>
