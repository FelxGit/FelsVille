<template>
    <div>
        <main class="py-4">
            <router-view></router-view>   
        </main>
    </div>
</template>

<script>
import Vue from 'vue'

Vue.component('HeaderTitle', require('../components/TemplateParts/HeaderTitle.vue').default)
Vue.component('ContentSpinner', require('../components/LoadingAnimation/ContentSpinner.vue').default)
Vue.component('QuantityOptionUI', require('../components/TemplateParts/QuantityOptionUI.vue').default)

export default {
    data() {
        return {
            name: null,
        }
    },
}
</script>