<template>
    <div class="max-w-lg mx-auto relative">
        <form @submit.prevent="emitSearchQuery" class="flex">
            <button
                id="dropdown-button"
                @click="toggleDropdown"
                class="flex-shrink-0 z-10 inline-flex items-center py-2 px-2 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600"
                type="button"
            >
                {{ selectedCategory || "All categories" }}
                <svg
                    class="w-2 h-2 ms-2"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 10 6"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 1 4 4 4-4"
                    />
                </svg>
            </button>
            <div
                v-show="showDropdown"
                id="dropdown"
                class="absolute top-full left-0 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-50 dark:bg-gray-700"
            >
                <ul
                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="dropdown-button"
                >
                    <li
                        v-for="category in categories"
                        :key="category"
                        @click="selectCategory(category)"
                    >
                        <button
                            type="button"
                            class="inline-flex w-full px-2 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            {{ category }}
                        </button>
                    </li>
                </ul>
            </div>
            <div class="relative w-full">
                <input
                    v-model="searchQuery"
                    @input="fetchSuggestions"
                    type="search"
                    id="search-dropdown"
                    class="block p-2 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Search Mockups, Logos, Design Templates..."
                    required
                />
                <button
                    type="submit"
                    class="absolute top-0 end-0 p-2 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <svg
                        class="w-3 h-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            searchQuery: "",
            selectedCategory: "",
            showDropdown: false,
            categories: [],
            suggestions: [],
        };
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
        selectCategory(category) {
            this.selectedCategory = category;
            this.showDropdown = false;
        },
        emitSearchQuery() {
            this.$emit("search", {
                searchQuery: this.searchQuery,
                category: this.selectedCategory,
            });
        },
        fetchSuggestions() {
            if (this.searchQuery.length > 2) {
                axios
                    .get("/api/search-suggestions", {
                        params: {
                            query: this.searchQuery,
                            category: this.selectedCategory,
                        },
                    })
                    .then((response) => {
                        this.suggestions = response.data;
                    });
            } else {
                this.suggestions = [];
            }
        },
        selectSuggestion(suggestion) {
            this.searchQuery = suggestion.name;
            this.suggestions = [];
            this.emitSearchQuery();
        },
    },
};
</script>
