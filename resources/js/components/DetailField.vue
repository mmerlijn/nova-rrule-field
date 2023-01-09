<template>
    <PanelItem :index="index" :field="field">
        <template #value>
            <RruleHumans v-model="field.value" :locale="field.locale"/>
        </template>
    </PanelItem>
</template>

<script>
import RruleHumans from "./tools/RruleHumans.vue";

export default {
    components: {RruleHumans},
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
}
</script>
