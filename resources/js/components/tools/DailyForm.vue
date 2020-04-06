<template>
    <div>
        <every-day-selector :value.sync="everyDayString" :locale="locale"></every-day-selector>
        <end-selector :value.sync="endString" :locale="locale"></end-selector>
    </div>
</template>

<script>
    import EveryDaySelector from "./EveryDaySelector";
    import EndSelector from "./EndSelector";
    export default {
        name: "DailyForm",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'FREQ=DAILY;INTERVAL=1;';
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
                everyDayString: "INTERVAL=2",
                endString: '',
            }

        },
        components: {
            'every-day-selector': EveryDaySelector,
            'end-selector': EndSelector,
        },
        watch: {
            value: function (newValue, oldValue) {
                this.setForm();
            },
            everyDayString: function () {
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
                            self.everyDayString= val;
                            break;
                        case 'UNTIL':
                            self.endString = val;
                            break;

                    }
                });
            },
            setValue() {
                this.value = 'FREQ=DAILY;'+this.everyDayString+';'+this.endString;
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>

</style>