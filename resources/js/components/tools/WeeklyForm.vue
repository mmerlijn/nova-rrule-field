<template>
    <div>
        <day-selector :value.sync="dayString" :locale="locale"></day-selector>
        <every-week-selector :value.sync="everyWeekString" :locale="locale"></every-week-selector>
    </div>
</template>

<script>
    import DaySelector from "./DaySelector";
    import EveryWeekSelector from "./EveryWeekSelector";
    export default {
        name: "WeekyForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=WEEKLY;INTERVAL=1;BYDAY=MO,TU,WE,TH,FR';
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
                dayString: 'BYDAY=MO,TU,WE,TH,FR',
                everyWeekString: "INTERVAL=1",
            }

        },
        components: {
            'every-week-selector': EveryWeekSelector,
            'day-selector': DaySelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            dayString: function () {
                this.setValue();
            },
            everyWeekString: function(){
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
                params.forEach(function(val){

                    switch(val.split('=')[0]){
                        case 'INTERVAL':
                            self.everyWeekString= val;
                            break;
                        case 'BYDAY':
                            self.dayString = val;
                            break;
                    }
                });
            },
            setValue() {
                this.value = ('FREQ=WEEKLY;'+this.everyWeekString+';'+this.dayString).replace(/;+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>