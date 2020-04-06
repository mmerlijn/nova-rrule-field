<template>
    <div>
        <select v-model="every" @change="setValue"
                class="form-control form-select form-input-bordered mb-3">
            <option v-for="dayly in dict" :value="dayly.value">{{translate(dayly.value)}}</option>
        </select>
    </div>
</template>

<script>
    export default {
        name: "EveryDaySelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'INTERVAL=';
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
                every: 1,
                dict: [{value: 1, nl: "Elke dag", en: "Every day"},
                    {value: 2, nl: "Om de dag", en: "Every other day"},
                    {value: 3, nl: "Elke 3e dag", en: "Every 3rd day"},
                    {value: 4, nl: "Elke 4e dag", en: "Every 4th day"},
                    {value: 5, nl: "Elke 5e dag", en: "Every 5th day"},
                    {value: 6, nl: "Elke 6e dag", en: "Every 6th day"},
                    {value: 7, nl: "Elke 7e dag", en: "Every 7th day"},
                    {value: 8, nl: "Elke 8e dag", en: "Every 8th day"},
                    {value: 9, nl: "Elke 9e dag", en: "Every 9th day"},
                    {value: 10, nl: "Elke 10e dag", en: "Every 10th day"},
                    {value: 11, nl: "Elke 11e dag", en: "Every 11th day"},
                    {value: 12, nl: "Elke 12e dag", en: "Every 12th day"},
                    {value: 13, nl: "Elke 13e dag", en: "Every 13th day"},
                    {value: 14, nl: "Elke 14e dag", en: "Every 14th day"},
                    {value: 15, nl: "Elke 15e dag", en: "Every 15th day"},
                    {value: 16, nl: "Elke 16e dag", en: "Every 16th day"},
                    {value: 17, nl: "Elke 17e dag", en: "Every 17th day"},
                    {value: 18, nl: "Elke 18e dag", en: "Every 18th day"},
                    {value: 19, nl: "Elke 19e dag", en: "Every 19th day"},
                    {value: 20, nl: "Elke 20e dag", en: "Every 20th day"},
                    {value: 21, nl: "Elke 21e dag", en: "Every 21th day"},
                    {value: 22, nl: "Elke 22e dag", en: "Every 22th day"},
                    {value: 23, nl: "Elke 23e dag", en: "Every 23th day"},
                    {value: 24, nl: "Elke 24e dag", en: "Every 24th day"},
                    {value: 25, nl: "Elke 25e dag", en: "Every 25th day"},
                    {value: 26, nl: "Elke 26e dag", en: "Every 26th day"},
                    {value: 27, nl: "Elke 27e dag", en: "Every 27th day"},
                    {value: 28, nl: "Elke 28e dag", en: "Every 28th day"},
                    {value: 29, nl: "Elke 29e dag", en: "Every 29th day"},
                    {value: 30, nl: "Elke 30e dag", en: "Every 30th day"},
                    {value: 31, nl: "Elke 31e dag", en: "Every 31th day"},
                ],
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
                this.every = this.value.split('=')[1]
            },
            setValue() {
                this.value = 'INTERVAL='+this.every;
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>