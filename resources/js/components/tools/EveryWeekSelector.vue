<template>
    <div>
        <select v-model="every" @change="setValue"
                class="form-control form-select form-input-bordered mb-3">
            <option v-for="weekly in dict" :value="weekly.value">{{translate(weekly.value)}}</option>
        </select> {{value}}
    </div>
</template>

<script>
    export default {
        name: "EveryWeekSelector",
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
                dict: [
                    {value: 1, nl: "Elke week", en: "Every week"},
                    {value: 2, nl: "Om de week", en: "Every other week"},
                    {value: 3, nl: "Elke 3e week", en: "Every 3rd week"},
                    {value: 4, nl: "Elke 4e week", en: "Every 4th week"},
                    {value: 5, nl: "Elke 5e week", en: "Every 5th week"},
                    {value: 6, nl: "Elke 6e week", en: "Every 6th week"},
                    {value: 7, nl: "Elke 7e week", en: "Every 7th week"},
                    {value: 8, nl: "Elke 8e week", en: "Every 8th week"},
                    {value: 9, nl: "Elke 9e week", en: "Every 9th week"},
                    {value: 10, nl: "Elke 10e week", en: "Every 10th week"},
                    {value: 11, nl: "Elke 11e week", en: "Every 11th week"},
                    {value: 12, nl: "Elke 12e week", en: "Every 12th week"},
                    {value: 13, nl: "Elke 13e week", en: "Every 13th week"},
                    {value: 14, nl: "Elke 14e week", en: "Every 14th week"},
                    {value: 15, nl: "Elke 15e week", en: "Every 15th week"},
                    {value: 16, nl: "Elke 16e week", en: "Every 16th week"},
                    {value: 17, nl: "Elke 17e week", en: "Every 17th week"},
                    {value: 18, nl: "Elke 18e week", en: "Every 18th week"},
                    {value: 19, nl: "Elke 19e week", en: "Every 19th week"},
                    {value: 20, nl: "Elke 20e week", en: "Every 20th week"},
                    {value: 21, nl: "Elke 21e week", en: "Every 21th week"},
                    {value: 22, nl: "Elke 22e week", en: "Every 22th week"},
                    {value: 23, nl: "Elke 23e week", en: "Every 23th week"},
                    {value: 24, nl: "Elke 24e week", en: "Every 24th week"},
                    {value: 25, nl: "Elke 25e week", en: "Every 25th week"},
                    {value: 26, nl: "Elke 26e week", en: "Every 26th week"},
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