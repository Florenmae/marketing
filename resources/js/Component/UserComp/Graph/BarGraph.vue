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
    data() {
        return {    
            recentProducts: null,
        };
    },
    methods: {
        getRecentProducts() {
            axios.get("/recent-products").then((response) => {
                this.recentProducts = response.data.recentProducts;
            });
        },
        formatDate(date) {
            return date;
        },
    },
    mounted() {
        this.getRecentProducts();
    },
};
</script>
