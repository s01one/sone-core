<template>
    <div class="wrapper">
        <Header />
        <Main />
        <Footer />
    </div>
</template>

<script>
import Header from './layouts/inc/Header.vue';
import Footer from './layouts/inc/Footer.vue';
import Main from './layouts/inc/Main.vue';

export default {
    name: 'App',
    components: {
        Header,
        Footer,
        Main,
    },
    mounted() {
        // Скрываем preloader после загрузки приложения
        const preloader = document.getElementById("preloader");
        if (preloader) {
            preloader.style.opacity = "0";
            preloader.style.transition = "opacity 0.5s ease";

            // Удаляем элемент из DOM после завершения анимации
            setTimeout(() => {
                preloader.style.display = "none";
            }, 500);
        }
    },
};
</script>

<style>
.wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
</style>
