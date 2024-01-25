<template lang="">
    <div class="w-full flex items-center gap-5 my-5">
        <div class="bg-gray-400 w-full">Sales Report here</div>
        <div class="bg-gray-400 w-full">
            Recently Added Products here
            <ul>
                <li v-for="product in recentProducts" :key="product.id">
                    {{ product.name }} -
                    {{ formatDate(product.created_at) }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props: ["recentProducts"],

    methods: {
        getRecentProducts() {
            axios
                .get("/recent-products")
                .then((response) => {
                    this.recentProducts = response.data.recentProducts;
                })
                .catch((error) => {
                    console.error("Error fetching recent items:", error);
                });
        },
        // fetchRecentProducts() {
        //     // Dummy data for testing
        //     this.recentProducts = [
        //         { id: 1, name: "Product 1", created_at: "2024-01-25 12:00:00" },
        //         { id: 2, name: "Product 2", created_at: "2024-01-25 11:30:00" },
        //         // Add more dummy data as needed
        //     ];
        // },
        formatDate(date) {
            return date;
        },
    },
    mounted() {
        this.getRecentProducts();
        //this.fetchRecentProducts();
    },
};
</script>
