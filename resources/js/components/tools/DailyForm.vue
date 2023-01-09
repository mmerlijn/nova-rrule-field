<template>
    <div>
        <EveryXSelector period="days" v-model="everyDayString" :locale="locale"/>
    </div>
</template>
<script setup>

import EveryXSelector from "./EveryXSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=DAILY;'
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const everyDayString = ref('')
const dict = []

const value = computed({
    get() {
        return props.modelValue
    },
    set(value) {
        emit('update:modelValue', value)
    }
})
watch(value, () => {
    if (!value.value) {
        value.value = 'FREQ=DAILY;'
    }
    setForm()
})
watch(everyDayString, () => {
    setValue()
})
onMounted(() => {
    value.value = value.value || 'FREQ=DAILY;'
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}

const setForm = () => {
    everyDayString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
}
const setValue = () => {
    if (everyDayString.value.includes('INTERVAL')) {
        value.value = 'FREQ=DAILY;' + everyDayString.value
    } else {
        value.value = 'FREQ=DAILY;'
    }

}
</script>
