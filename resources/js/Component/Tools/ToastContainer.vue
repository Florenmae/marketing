<template>
    <div v-if="toast.visible" class="toast">
        <div class="toast-content">
            <p>{{ toast.message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            toast: {
                visible: false,
                message: "Successful!",
            },
        };
    },
    methods: {
        showNotification(message) {
            this.toast.message = message;
            this.toast.visible = true;
            setTimeout(() => {
                this.toast.visible = false;
            }, 5000);
        },
    },
};
</script>

<style scoped>
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border-radius: 4px;
}

.toast-content {
    max-width: 300px;
}
</style>
