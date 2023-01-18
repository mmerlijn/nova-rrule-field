<template>
    <div :class="['m-2 mb-4 p-2 border border-1 rounded',error?'border-red-600  bg-red-50':'border-gray-300']">
        <strong>{{ translate('day') }}</strong><br>

        <label for="MO"><input id="MO" type="checkbox" v-model="days.MO" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('MO') }}</span></label>
        <label for="TU"><input id="TU" type="checkbox" v-model="days.TU" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('TU') }}</span></label>
        <label for="WE"><input id="WE" type="checkbox" v-model="days.WE" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('WE') }}</span></label>
        <label for="TH"><input id="TH" type="checkbox" v-model="days.TH" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('TH') }}</span></label>
        <label for="FR"><input id="FR" type="checkbox" v-model="days.FR" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('FR') }}</span></label>
        <label for="SA"><input id="SA" type="checkbox" v-model="days.SA" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('SA') }}</span></label>
        <label for="SU"><input id="SU" type="checkbox" v-model="days.SU" @change="setValue" class="checkbox"><span
            class="text-sm ml-2 mr-6">{{ translate('SU') }}</span></label>
    </div>
</template>


<script setup>
import {computed, onMounted, ref, watch} from "vue";

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: {
        type: String,
        default: 'BYDAY='
    },
    locale: {
        type: String,
        default: 'en',
    }
})
const error = ref(false)
const days = ref({
    SU: false,
    MO: false,
    TU: false,
    WE: false,
    TH: false,
    FR: false,
    SA: false,
})

const dict = [{value: 'SU', nl: "Zo", en: 'Su'},
    {value: 'MO', nl: "Ma", en: 'Mo'},
    {value: 'TU', nl: "Di", en: 'Tu'},
    {value: 'WE', nl: "Wo", en: 'We'},
    {value: 'TH', nl: "Do", en: 'Th'},
    {value: 'FR', nl: "Vr", en: 'Fr'},
    {value: 'SA', nl: "Za", en: 'Sa'},
    {value: 'day', nl: "Op deze dagen van de week", en: 'On these days of the week'},
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
        value.value = 'BYDAY='
    }
    setForm()

})
onMounted(() => {
    value.value = value.value || 'BYDAY='
    setForm()
})
const testError = () => {
    error.value = !value.value.split('=')[1]?.length
}
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale];
}

const setForm = () => {
    testError()
    days.value.SU = value.value.includes('SU')
    days.value.MO = value.value.includes('MO')
    days.value.TU = value.value.includes('TU')
    days.value.WE = value.value.includes('WE')
    days.value.TH = value.value.includes('TH')
    days.value.FR = value.value.includes('FR')
    days.value.SA = value.value.includes('SA')
}
const setValue = () => {
    value.value = ('BYDAY=' +
        (days.value.SU ? 'SU,' : '') +
        (days.value.MO ? 'MO,' : '') +
        (days.value.TU ? 'TU,' : '') +
        (days.value.WE ? 'WE,' : '') +
        (days.value.TH ? 'TH,' : '') +
        (days.value.FR ? 'FR,' : '') +
        (days.value.SA ? 'SA,' : ''))
        .replace(/,+$/g, '')
}
</script>
