<template>
    <div :class="['m-2 p-2 border border-1 rounded',error?'border-red-600':'border-gray-300']">
        <div class="flex gap-1 items-center mb-3">
            <span class="p-2">{{ translate('every') }}</span>
            <input type="number" min="1" v-model="every" class="form-control form-input form-input-bordered w-16 text-sm pl-3"
                   @input="setValue"><span class="p-2">{{ translate(props.period) }}</span>
        </div>
    </div>
</template>
<script setup>
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'INTERVAL='
    },
    locale: {
        type: String,
        default: 'en',
    },
    period: {
        type: String,
        required: true,
        validator: propValue => {
            return ['days', 'weeks', 'months', 'years'].includes(propValue)
        }
    }
})

//refs
const error = ref(false)
const every = ref(1)
const dict = [{value: 'every', nl: 'Om de', en: 'Every'},
    {value: 'weeks', nl: 'week/weken', en: 'week(s)'},
    {value: 'months', nl: 'maand(en)', en: 'month(s)'},
    {value: 'days', nl: 'dag(en)', en: 'day(s)'},
    {value: 'years', nl: 'jaar/jaren', en: 'year(s)'},
]
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
        value.value = ''
    }
    setForm()
})
onMounted(() => {
    setForm()
})
const testError = () => {
    error.value = every.value < 1
}
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale];
}

const setForm = () => {
    if (value.value.length) {
        every.value = value.value.split('=')[1] || 1
    } else {
        every.value = 1
    }
    testError()
}
const setValue = () => {
    if (every.value <= 1) {
        value.value = ''
    } else {
        value.value = 'INTERVAL=' + every.value
    }

}
</script>
