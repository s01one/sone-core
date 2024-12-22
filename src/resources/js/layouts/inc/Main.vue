<template>
    <main class="flex-grow-1 content">
        <div class="container">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
export default {
    name: 'Main',
};
</script>

<style scoped>
.content {
    flex: 1;
}
</style>
