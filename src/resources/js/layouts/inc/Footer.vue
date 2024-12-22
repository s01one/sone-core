<template>
    <footer>
        <div class="container clearfix">
            <ul>
                <li>
                    <router-link
                        to="/datenschutz"
                        class="animated_link"
                        :class="{ active: isActive('/datenschutz') }"
                    >
                        {{ $t('general.data_protection') }}
                    </router-link>
                </li>
                <li>
                    <router-link
                        to="/impressum"
                        class="animated_link"
                        :class="{ active: isActive('/impressum') }"
                    >
                        {{ $t('general.imprint') }}
                    </router-link>
                </li>
            </ul>
            <p>© 2024 sOne v1.0.0</p>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer",
    methods: {
        isActive(path) {
            return this.$route.path === path;
        },
    },
};
</script>

<style scoped>

</style>
