<template>
    <div>
        <EveryXSelector period="years" v-model="everyYearString" :locale="locale"/>
        <WeekSelector v-model="weekString" :locale="locale"/>
        <DaySelector v-model="dayString" :locale="locale"/>
    </div>
</template>
<script setup>

import DaySelector from "./DaySelector.vue";
import WeekSelector from "./WeekSelector.vue";
import EveryXSelector from "./EveryXSelector.vue";
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'FREQ=YEARLY;BYWEEKNO=;BYDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})

//refs
const everyYearString = ref('')
const weekString = ref("BYWEEKNO=")
const dayString = ref('BYDAY=')
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
        value.value = 'FREQ=YEARLY;BYWEEKNO=;BYDAY='
    }
    setForm()
})
watch(everyYearString, () => {
    setValue()
})
watch(weekString, () => {
    setValue()
})
watch(dayString, () => {
    setValue()
})
onMounted(() => {
    if (!value.value) {
        value.value = 'FREQ=YEARLY;BYWEEKNO=;BYDAY='
    }
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale]
}

const setForm = () => {
    everyYearString.value = value.value.split(';').find(x => x.includes('INTERVAL')) || ''
    weekString.value = value.value.split(';').find(x => x.includes('BYWEEKNO')) || 'BYWEEKNO='
    dayString.value = value.value.split(';').find(x => x.includes('BYDAY')) || 'BYDAY='
}
const setValue = () => {
    value.value =
        ('FREQ=YEARLY;' +
            (everyYearString.value.length ? everyYearString.value + ';' : '') +
            weekString.value + ';' +
            dayString.value
        ).replace(/;+$/g, '')
}
</script>
