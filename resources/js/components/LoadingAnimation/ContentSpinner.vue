<template>
    <rise-loader style="margin: 100px auto" :color="color" :size="size"></rise-loader>
</template>
<script>
import RiseLoader from 'vue-spinner/src/RiseLoader.vue'
import store from '../../store'
export default {
    name: 'ContentSpinner',
    data() {
        return {
            color: '#ff6b6b',
            size: '50px'
        }
    },
    components: { RiseLoader }
}
</script>