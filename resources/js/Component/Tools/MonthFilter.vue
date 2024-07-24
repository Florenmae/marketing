<template>
    <div class="flex items-center">
        <select
            id="monthFilter"
            class="mb-2 ml-auto bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/6 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            v-model="selectedMonth"
            @change="emitSelectedMonth"
            required
        >
            <option value="" selected>Choose a month</option>
            <option
                v-for="(month, index) in monthOptions"
                :key="index"
                :value="index + 1"
            >
                {{ month }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        initialMonth: {
            type: Number,
            default: null,
        },
    },
    data() {
        return {
            selectedMonth: this.initialMonth || "",
        };
    },
    computed: {
        monthOptions() {
            return [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
        },
    },
    methods: {
        emitSelectedMonth() {
            this.$emit("month-selected", this.selectedMonth);
        },
    },
    watch: {
        initialMonth(newMonth) {
            this.selectedMonth = newMonth;
        },
    },
};
</script>
