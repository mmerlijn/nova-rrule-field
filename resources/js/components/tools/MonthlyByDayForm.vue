<template>
    <div>
        <every-month-selector :value.sync="everyMonthString" :locale="locale"></every-month-selector>
        <by-day-selector :value.sync="byDayString" :locale="locale"></by-day-selector>
    </div>
</template>

<script>
    import EveryMonthSelector from "./EveryMonthSelector";
    import ByDaySelector from "./ByDaySelector";
    import EndSelector from "./EndSelector";

    export default {
        name: "MonthlyByDayForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=MONTHLY;INTERVAL=1;BYDAY=1MO';
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
                byDayString: "BYDAY=1MO",
                everyMonthString: "INTERVAL=1",
            }

        },
        components: {
            'by-day-selector': ByDaySelector,
            'every-month-selector': EveryMonthSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            byDayString: function () {
                this.setValue();
            },
            everyMonthString: function () {
                this.setValue();
            },
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
                let params = this.value.split(';');
                params.forEach(function (val) {

                    switch (val.split('=')[0]) {
                        case 'INTERVAL':
                            self.everyMonthString = val;
                            break;
                        case 'BYDAY':
                            self.byDayString = val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('FREQ=MONTHLY;' + this.everyMonthString + ';' + this.byDayString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>