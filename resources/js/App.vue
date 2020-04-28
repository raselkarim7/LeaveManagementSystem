<template> 
    <div>
        <router-view> </router-view>
        <FlashMessage :position="'right top'"></FlashMessage>
    </div>
</template>

<script>
export default {
    name: 'App',
    components: {

    },
    data() {
        return {

        }
    }
}
</script>

