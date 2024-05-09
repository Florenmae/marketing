<template>
    <Layout>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-10 content-between w-full h-full"
        >
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg--50 w-full">
                        <div class="">
                            <label class="text-xl font-semibold"
                                >Cash On Hand</label
                            >
                        </div>
                    </div>
                    <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <div
                                class="justify-center items-center bg-white border border-green-400 sm:rounded-lg flex flex-col items-center w-full mt-4 mb-4"
                            >
                                <div
                                    class="p-6 flex flex-col items-center w-full"
                                >
                                    <div
                                        class="flex justify-between items-center w-full"
                                    >
                                        <div
                                            class="text-4xl leading-7 font-semibold"
                                        >
                                            <div class="pb-1">
                                                <div class="text-5xl font-bold">
                                                    {{ cashOnHand }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </table>

                        <div
                            class="flex flex-col items-center justify-center w-full"
                        >
                            <input
                                v-model="cashOnHand"
                                type="number"
                                class="border border-gray-300 rounded-md px-4 py-2 mb-2"
                                placeholder="Enter amount"
                                v-if="showInput"
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
            </div>
            <div
                class="border border-gray-300 text-black overflow-hidden flex flex-col items-center w-full h-full"
            >
                <div class="p-4 flex flex-col items-center w-full h-full">
                    <div class="bg--50 w-full">
                        <div class="">
                            <label class="text-xl font-semibold"
                                >Cash Flow Logs</label
                            >
                        </div>
                    </div>
                    <div class="mt-1 w-full">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50"></thead>
                            <tbody
                                class="bg-white divide-y divide-gray-200"
                            ></tbody>
                        </table>

                        <div class="mt-4"></div>
                    </div>
                </div>
            </div>
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
            showInput: true,
        };
    },
    methods: {
        getCash() {
            axios.get("/get-cash").then(({ data }) => {
                console.log(data);
                if (data) {
                    const lastSavedCash = data[data.length - 1];
                    this.cashOnHand = data.CashOnHand;
                }
            });
        },

        addCash() {
            const { cashOnHand } = this;
            axios
                .post("/add-cash", { cashOnHand })
                .then(({ data }) => {
                    this.cashregs.push(data);
                    this.showInput = false;
                })
                .catch((error) => {
                    console.error("Error adding cash:", error);
                    s;
                });
        },

        remitToAdmin() {
            const { cashOnHand } = this;
            axios.post("/save-to-admin", { cashOnHand }).then(() => {
                this.cashOnHand = 0;
                this.showInput = true;
            });
        },
    },

    mounted() {
        this.getCash();
    },
};
</script>
