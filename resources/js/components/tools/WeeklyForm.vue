<template>
    <div>
        <EveryXSelector period="weeks" v-model="everyWeekString" :locale="locale"/>
        <DaySelector v-model="dayString" :locale="locale"/>
    </div>
</template>
<script setup>

import DaySelector from "./DaySelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=WEEKLY;BYDAY=',
    },
    locale: {
        type: String,
        default: 'en',
    }
})
const dayString = ref('BYDAY=')
const everyWeekString = ref('')
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
        value.value = 'FREQ=WEEKLY;BYDAY='
    }
    setForm()
})
watch(dayString, () => {
    setValue()
})
watch(everyWeekString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=WEEKLY;BYDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.value.find(x => x.value === field)[props.locale];
}
const setForm = () => {
    everyWeekString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    dayString.value = value.value.split(';').find(x => x.includes('BYDAY')) || 'BYDAY='
}
const setValue = () => {
    value.value =
        ('FREQ=WEEKLY;' +
            (everyWeekString.value.length ? everyWeekString.value + ';' : '') +
            dayString.value)
            .replace(/;+$/g, '')


}
</script>
