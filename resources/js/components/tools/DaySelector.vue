<template>
    <div class="mb-4">
        <strong>{{translate('day')}}</strong><br>

        <label for="MO"><input id="MO" type="checkbox" v-model="day_MO" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('MO')}}</span></label>
        <label for="TU"><input id="TU" type="checkbox" v-model="day_TU" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('TU')}}</span></label>
        <label for="WE"><input id="WE" type="checkbox" v-model="day_WE" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('WE')}}</span></label>
        <label for="TH"><input id="TH" type="checkbox" v-model="day_TH" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('TH')}}</span></label>
        <label for="FR"><input id="FR" type="checkbox" v-model="day_FR" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('FR')}}</span></label>
        <label for="SA"><input id="SA" type="checkbox" v-model="day_SA" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('SA')}}</span></label>
        <label for="SU"><input id="SU" type="checkbox" v-model="day_SU" @change="setValue"><span
                class="text-sm ml-2 mr-6">{{translate('SU')}}</span></label>
    </div>
</template>

<script>
    export default {
        name: "DaySelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'BYDAY=';
                }
            },
            locale: {
                type: String,
                default: () => {
                    return 'en';
                }
            }
        },
        data() {
            return {
                day_SU: false,
                day_MO: false,
                day_TU: false,
                day_WE: false,
                day_TH: false,
                day_FR: false,
                day_SA: false,
                dict: [{value: 'SU', nl: "Zo", en: 'Su'},
                    {value: 'MO', nl: "Ma", en: 'Mo'},
                    {value: 'TU', nl: "Di", en: 'Tu'},
                    {value: 'WE', nl: "Wo", en: 'We'},
                    {value: 'TH', nl: "Do", en: 'Th'},
                    {value: 'FR', nl: "Vr", en: 'Fr'},
                    {value: 'SA', nl: "Za", en: 'Sa'},
                    {value: 'day', nl: "Op deze dagen van de week", en: 'On these days of the week'},
                ]
            }
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            }
        },
        created: function () {
            this.setForm();
        },
        methods: {
            translate: function (field) {
                return this.dict.find(x => x.value == field)[this.locale];
            },
            setForm() {
                self = this;
                let params = this.value.split('=')[1].split(',');
                this.day_SU = false;
                this.day_MO = false;
                this.day_TU = false;
                this.day_WE = false;
                this.day_TH = false;
                this.day_FR = false;
                this.day_SA = false;
                params.forEach(function (value) {
                    switch (value) {
                        case 'SU':
                            self.day_SU = true;
                            break;
                        case 'MO':
                            self.day_MO = true;
                            break;
                        case 'TU':
                            self.day_TU = true;
                            break;
                        case 'WE':
                            self.day_WE = true;
                            break;
                        case 'TH':
                            self.day_TH = true;
                            break;
                        case 'FR':
                            self.day_FR = true;
                            break;
                        case 'SA':
                            self.day_SA = true;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('BYDAY=' + (this.day_SU ? 'SU,' : '') + (this.day_MO ? 'MO,' : '') + (this.day_TU ? 'TU,' : '') + (this.day_WE ? 'WE,' : '') + (this.day_TH ? 'TH,' : '') + (this.day_FR ? 'FR,' : '') + (this.day_SA ? 'SA,' : '')).replace(/,+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>