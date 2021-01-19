<template>
    <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
        <h2 class="title">{{ title }}</h2>
    </div>
</template>
<script>
export default {
    name: 'HeaderTitle',
    props: ['title']
}
</script>
