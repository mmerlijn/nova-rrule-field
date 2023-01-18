<template>
    <div :class="['m-2 p-2 border border-1 rounded',error?'border-red-600  bg-red-50':'border-gray-300']">
        <strong>{{ translate('day') }}</strong><br>
        <table>
            <tr>
                <td>
                    <label for="MO1"><input id="MO1" type="checkbox" v-model="byday.MO1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1MO') }}</span></label><br>
                    <label for="TU1"><input id="TU1" type="checkbox" v-model="byday.TU1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1TU') }}</span></label><br>
                    <label for="WE1"><input id="WE1" type="checkbox" v-model="byday.WE1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1WE') }}</span></label><br>
                    <label for="TH1"><input id="TH1" type="checkbox" v-model="byday.TH1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1TH') }}</span></label><br>
                    <label for="FR1"><input id="FR1" type="checkbox" v-model="byday.FR1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1FR') }}</span></label><br>
                    <label for="SA1"><input id="SA1" type="checkbox" v-model="byday.SA1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1SA') }}</span></label><br>
                    <label for="SU1"><input id="SU1" type="checkbox" v-model="byday.SU1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('1SU') }}</span></label>
                </td>
                <td>
                    <label for="MO2"><input id="MO2" type="checkbox" v-model="byday.MO2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2MO') }}</span></label><br>
                    <label for="TU2"><input id="TU2" type="checkbox" v-model="byday.TU2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2TU') }}</span></label><br>
                    <label for="WE2"><input id="WE2" type="checkbox" v-model="byday.WE2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2WE') }}</span></label><br>
                    <label for="TH2"><input id="TH2" type="checkbox" v-model="byday.TH2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2TH') }}</span></label><br>
                    <label for="FR2"><input id="FR2" type="checkbox" v-model="byday.FR2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2FR') }}</span></label><br>
                    <label for="SA2"><input id="SA2" type="checkbox" v-model="byday.SA2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2SA') }}</span></label><br>
                    <label for="SU2"><input id="SU2" type="checkbox" v-model="byday.SU2" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('2SU') }}</span></label>
                </td>
                <td>
                    <label for="MO3"><input id="MO3" type="checkbox" v-model="byday.MO3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3MO') }}</span></label><br>
                    <label for="TU3"><input id="TU3" type="checkbox" v-model="byday.TU3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3TU') }}</span></label><br>
                    <label for="WE3"><input id="WE3" type="checkbox" v-model="byday.WE3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3WE') }}</span></label><br>
                    <label for="TH3"><input id="TH3" type="checkbox" v-model="byday.TH3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3TH') }}</span></label><br>
                    <label for="FR3"><input id="FR3" type="checkbox" v-model="byday.FR3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3FR') }}</span></label><br>
                    <label for="SA3"><input id="SA3" type="checkbox" v-model="byday.SA3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3SA') }}</span></label><br>
                    <label for="SU3"><input id="SU3" type="checkbox" v-model="byday.SU3" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('3SU') }}</span></label>
                </td>
                <td>
                    <label for="MO4"><input id="MO4" type="checkbox" v-model="byday.MO4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4MO') }}</span></label><br>
                    <label for="TU4"><input id="TU4" type="checkbox" v-model="byday.TU4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4TU') }}</span></label><br>
                    <label for="WE4"><input id="WE4" type="checkbox" v-model="byday.WE4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4WE') }}</span></label><br>
                    <label for="TH4"><input id="TH4" type="checkbox" v-model="byday.TH4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4TH') }}</span></label><br>
                    <label for="FR4"><input id="FR4" type="checkbox" v-model="byday.FR4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4FR') }}</span></label><br>
                    <label for="SA4"><input id="SA4" type="checkbox" v-model="byday.SA4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4SA') }}</span></label><br>
                    <label for="SU4"><input id="SU4" type="checkbox" v-model="byday.SU4" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('4SU') }}</span></label>
                </td>
                <td>
                    <label for="MO5"><input id="MO5" type="checkbox" v-model="byday.MO5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5MO') }}</span></label><br>
                    <label for="TU5"><input id="TU5" type="checkbox" v-model="byday.TU5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5TU') }}</span></label><br>
                    <label for="WE5"><input id="WE5" type="checkbox" v-model="byday.WE5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5WE') }}</span></label><br>
                    <label for="TH5"><input id="TH5" type="checkbox" v-model="byday.TH5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5TH') }}</span></label><br>
                    <label for="FR5"><input id="FR5" type="checkbox" v-model="byday.FR5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5FR') }}</span></label><br>
                    <label for="SA5"><input id="SA5" type="checkbox" v-model="byday.SA5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5SA') }}</span></label><br>
                    <label for="SU5"><input id="SU5" type="checkbox" v-model="byday.SU5" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('5SU') }}</span></label>
                </td>
                <td>
                    <label for="MO_1"><input id="MO_1" type="checkbox" v-model="byday.MO_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1MO') }}</span></label><br>
                    <label for="TU_1"><input id="TU_1" type="checkbox" v-model="byday.TU_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1TU') }}</span></label><br>
                    <label for="WE_1"><input id="WE_1" type="checkbox" v-model="byday.WE_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1WE') }}</span></label><br>
                    <label for="TH_1"><input id="TH_1" type="checkbox" v-model="byday.TH_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1TH') }}</span></label><br>
                    <label for="FR_1"><input id="FR_1" type="checkbox" v-model="byday.FR_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1FR') }}</span></label><br>
                    <label for="SA_1"><input id="SA_1" type="checkbox" v-model="byday.SA_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1SA') }}</span></label><br>
                    <label for="SU_1"><input id="SU_1" type="checkbox" v-model="byday.SU_1" @change="setValue" class="checkbox"><span
                        class="text-sm ml-2 mr-6">{{ translate('-1SU') }}</span></label>
                </td>
            </tr>
        </table>
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

//refs
const error = ref(false)
const byday = ref({
    SU1: false, MO1: false, TU1: false, WE1: false, TH1: false, FR1: false, SA1: false,
    SU2: false, MO2: false, TU2: false, WE2: false, TH2: false, FR2: false, SA2: false,
    SU3: false, MO3: false, TU3: false, WE3: false, TH3: false, FR3: false, SA3: false,
    SU4: false, MO4: false, TU4: false, WE4: false, TH4: false, FR4: false, SA4: false,
    SU5: false, MO5: false, TU5: false, WE5: false, TH5: false, FR5: false, SA5: false,
    SU_1: false, MO_1: false, TU_1: false, WE_1: false, TH_1: false, FR_1: false, SA_1: false
})

const dict = [{key: 'SU1', value: '1SU', nl: '1e Zo', en: '1st Su'},
    {key: 'MO1', value: '1MO', nl: '1e Ma', en: '1st Mo'},
    {key: 'TU1', value: '1TU', nl: '1e Di', en: '1st Tu'},
    {key: 'WE1', value: '1WE', nl: '1e Wo', en: '1st We'},
    {key: 'TH1', value: '1TH', nl: '1e Do', en: '1st Th'},
    {key: 'FR1', value: '1FR', nl: '1e Vr', en: '1st Fr'},
    {key: 'SA1', value: '1SA', nl: '1e Za', en: '1st Sa'},
    {key: 'SU2', value: '2SU', nl: '2e Zo', en: '2nd Su'},
    {key: 'MO2', value: '2MO', nl: '2e Ma', en: '2nd Mo'},
    {key: 'TU2', value: '2TU', nl: '2e Di', en: '2nd Tu'},
    {key: 'WE2', value: '2WE', nl: '2e Wo', en: '2nd We'},
    {key: 'TH2', value: '2TH', nl: '2e Do', en: '2nd Th'},
    {key: 'FR2', value: '2FR', nl: '2e Vr', en: '2nd Fr'},
    {key: 'SA2', value: '2SA', nl: '2e Za', en: '2nd Sa'},
    {key: 'SU3', value: '3SU', nl: '3e Zo', en: '3rd Su'},
    {key: 'MO3', value: '3MO', nl: '3e Ma', en: '3rd Mo'},
    {key: 'TU3', value: '3TU', nl: '3e Di', en: '3rd Tu'},
    {key: 'WE3', value: '3WE', nl: '3e Wo', en: '3rd We'},
    {key: 'TH3', value: '3TH', nl: '3e Do', en: '3rd Th'},
    {key: 'FR3', value: '3FR', nl: '3e Vr', en: '3rd Fr'},
    {key: 'SA3', value: '3SA', nl: '3e Za', en: '3rd Sa'},
    {key: 'SU4', value: '4SU', nl: '4e Zo', en: '4th Su'},
    {key: 'MO4', value: '4MO', nl: '4e Ma', en: '4th Mo'},
    {key: 'TU4', value: '4TU', nl: '4e Di', en: '4th Tu'},
    {key: 'WE4', value: '4WE', nl: '4e Wo', en: '4th We'},
    {key: 'TH4', value: '4TH', nl: '4e Do', en: '4th Th'},
    {key: 'FR4', value: '4FR', nl: '4e Vr', en: '4th Fr'},
    {key: 'SA4', value: '4SA', nl: '4e Za', en: '4th Sa'},
    {key: 'SU5', value: '5SU', nl: '5e Zo', en: '5th Su'},
    {key: 'MO5', value: '5MO', nl: '5e Ma', en: '5th Mo'},
    {key: 'TU5', value: '5TU', nl: '5e Di', en: '5th Tu'},
    {key: 'WE5', value: '5WE', nl: '5e Wo', en: '5th We'},
    {key: 'TH5', value: '5TH', nl: '5e Do', en: '5th Th'},
    {key: 'FR5', value: '5FR', nl: '5e Vr', en: '5th Fr'},
    {key: 'SA5', value: '5SA', nl: '5e Za', en: '5th Sa'},
    {key: 'SU_1', value: '-1SU', nl: 'laatste Zo', en: 'Last Su'},
    {key: 'MO_1', value: '-1MO', nl: 'laatste Ma', en: 'Last Mo'},
    {key: 'TU_1', value: '-1TU', nl: 'laatste Di', en: 'Last Tu'},
    {key: 'WE_1', value: '-1WE', nl: 'laatste Wo', en: 'Last We'},
    {key: 'TH_1', value: '-1TH', nl: 'laatste Do', en: 'Last Th'},
    {key: 'FR_1', value: '-1FR', nl: 'laatste Vr', en: 'Last Fr'},
    {key: 'SA_1', value: '-1SA', nl: 'laatste Za', en: 'Last Sa'},
    {value: 'day', nl: "Op deze dagen van de maand", en: 'On these days of the month'},
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
const testError = () => {
    error.value = !value.value.split('=')[1]?.length
}
onMounted(() => {
    value.value = value.value || 'BYDAY='
    setForm()
})
const translate = (field) => {
    return dict.find(x => x.value === field)[props.locale];
}

const setForm = () => {
    testError()
    Object.keys(byday.value).forEach(val => {
        byday.value[val] = false;
    })
    if (value.value.length) {
        value.value.split('=')[1].split(',').forEach(value => {
            byday.value[value.substring(value.length - 2) + value.substring(0, value.length - 2).replace(/-/g, '_')] = true;
        })
    }
}
const setValue = () => {
    let daysString = 'BYDAY='
    Object.keys(byday.value).forEach(val => {
        if (byday.value[val]) {
            daysString += val.substring(2).replace(/_/g, '-') + val.substring(0, 2) + ","
        }
    })
    value.value = daysString.replace(/,+$/g, '')
}

</script>
