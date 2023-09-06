<template>
    <div>

        <Head :title="title ? title : 'ProductManagement'">
            <link rel="icon" type="image/svg+xml" href="/img/logo/logo.jpeg" />
            <slot name="meta_head" />
        </Head>
        <SideBar />
        <div class="main-content" id="panel">
            <div class="ml--6 fixed-content">
                <NavBar />
            </div>
            <div class="fixed-content">
                <slot name="header" />
            </div>
            <div class="container-fluid mt--6 fixed-content">
                <slot name="content" />
            </div>
        </div>
        <slot name="modals" />
        <Footer />
    </div>
</template>


<script>
import { Head, Link } from '@inertiajs/vue3'
import SideBar from '@/Components/Main/SideBar.vue';
import NavBar from '@/Components/Main/NavBar.vue';

export default {
    components: {
        Head,
        Link,
        SideBar,
        NavBar,
    },
    props: {
        title: String,
    },
    data() {

    },
    mounted() {
        
    },
    methods: {

    },
}
</script>

<style lang="scss">
body {
    background-image: url('@/../src/img/banner/bg.png');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    height: 100vh;
}

.bg-header {
    background-color: #55699f;
}

.table-responsive {
    overflow: auto;
}

@media screen and (max-width: 1199px) {
    .fixed-content {
        margin-left: 15rem !important;
        width: auto;
    }
}
</style>
