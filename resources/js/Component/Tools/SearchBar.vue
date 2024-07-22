<template>
    <form class="max-w-md mx-auto" @submit.prevent="performSearch">
        <label
            for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
            >Search</label
        >
        <div class="relative">
            <input
                type="search"
                id="default-search"
                v-model="searchQuery"
                @input="performSearch"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search..."
                required
            />
            <button
                type="button"
                @click="performSearch"
                class="absolute top-0 end-0 p-2 text-sm font-medium h-full text-gray-500 rounded-e-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            >
                <i class="pi pi-search" style="font-size: 1rem"></i>
            </button>
        </div>
    </form>
</template>

<script>
export default {
    name: "SearchBar",
    props: {
        initialQuery: {
            type: String,
            default: "",
        },
    },
    data() {
        return {
            searchQuery: this.initialQuery,
        };
    },
    methods: {
        performSearch() {
            this.$emit("search", this.searchQuery);
        },
    },
};
</script>
