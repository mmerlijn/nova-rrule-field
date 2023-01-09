<template>
    <RruleHumans v-model="field.value" :locale="field.locale"/>
</template>

<script>
import RruleHumans from "./tools/RruleHumans.vue";

export default {
    components: {RruleHumans},
    props: ['resourceName', 'field'],


}
</script>
