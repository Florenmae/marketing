<template>
    <div class="flex items-center gap-1 px-2 rounded-md w-fit m-1">
        <div v-if="current_page > 0">
            <button
                @click="back"
                :disabled="current_page === 1"
                class="border border-green-500 rounded-md px-2 py-1 text-green-600 font-small"
                :class="{ hidden: current_page === 1 }"
            >
                Prev
            </button>
        </div>
        <h1 class="border px-3 py-1 rounded-md border-gray-200 text-gray-500">
            {{ current_page ? current_page : 1 }}
        </h1>
        <div v-if="current_page > 0">
            <button
                @click="next"
                :disabled="current_page === last_page"
                class="bg-green-500 rounded-md px-2 py-1 text-white font-small"
                :class="{ hidden: current_page === last_page }"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        current_page: Number,
        last_page: Number,
        total: Number,
    },
    methods: {
        next() {
            this.$emit("next");
        },
        back() {
            this.$emit("back");
        },
    },
};
</script>
