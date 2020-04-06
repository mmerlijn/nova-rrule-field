<template>
    <div>
        <every-year-selector :value.sync="everyYearString" :locale="locale"></every-year-selector>
        <month-selector :value.sync="monthString" :locale="locale"></month-selector>
        <day-of-the-month-selector  :value.sync="dayofthemonthString"
                                    :locale="locale"></day-of-the-month-selector>
        <end-selector :value.sync="endString" :locale="locale"></end-selector>
    </div>
</template>

<script>
    import EveryYearSelector from "./EveryYearSelector";
    import DayOfTheMonthSelector from "./DayOfTheMonthSelector";
    import MonthSelector from "./MonthSelector";
    import EndSelector from "./EndSelector";
    export default {
        name: "YearlyByDateForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYMONTHDAY=1';
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
                everyYearString: 'INTERVAL=1',
                monthString: "BYMONTH=1",
                dayofthemonthString: 'BYDAY=1MO',
                endString: '',
            }

        },
        components: {
            MonthSelector,
            DayOfTheMonthSelector,
            'every-year-selector': EveryYearSelector,
            'end-selector': EndSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            everyYearString: function () {
                this.setValue();
            },
            monthString: function(){
                this.setValue();
            },
            dayofthemonthString: function(){
                this.setValue();
            },
            endString: function(){
                this.setValue();
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
                let params = this.value.split(';');
                params.forEach(function(val){

                    switch(val.split('=')[0]){
                        case 'INTERVAL':
                            self.everyYearString = val;
                            break;
                        case 'BYMONTH':
                            self.monthString = val;
                            break;
                        case 'BYDAY':
                            self.dayofthemonthString = val;
                            break;
                        case 'UNTIL':
                            self.endString = val;
                            break;

                    }
                });
            },
            setValue() {
                this.value = ('FREQ=YEARLY;'+this.everyYearString+';'+this.monthString+';'+this.dayofthemonthString+';'+this.endString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>
