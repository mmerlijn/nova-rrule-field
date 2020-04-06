<template>
    <div>
        <every-year-selector :value.sync="everyYearString" :locale="locale"></every-year-selector>
        <week-no-selector :value.sync="weeknoString" :locale="locale"></week-no-selector>
        <day-selector  :value.sync="dayString"
                                    :locale="locale"></day-selector>
        <end-selector :value.sync="endString" :locale="locale"></end-selector>
    </div>
</template>

<script>
    import EveryYearSelector from "./EveryYearSelector";
    import EndSelector from "./EndSelector";
    import WeekNoSelector from "./WeekNoSelector";
    import DaySelector from "./DaySelector";
    export default {
        name: "YearlyByWeekNoForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=YEARLY;INTERVAL=1;BYWEEKNO=1;BYDAY=MO,TU,WE,TH,FR';
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
                weeknoString: "BYWEEKNO=1",
                dayString: 'BYDAY=MO',
                endString: '',
            }

        },
        components: {
            WeekNoSelector,
            DaySelector,
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
            weeknoString: function(){
                this.setValue();
            },
            dayString: function(){
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
                        case 'BYWEEKNO':
                            self.weeknoString = val;
                            break;
                        case 'BYDAY':
                            self.dayString = val;
                            break;
                        case 'UNTIL':
                            self.endString = val;
                            break;

                    }
                });
            },
            setValue() {
                this.value = ('FREQ=YEARLY;'+this.everyYearString+';'+this.weeknoString+';'+this.dayString+';'+this.endString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>
