<template>
    <default-field :field="field" :errors="errors" :full-width-content="true">
        <template slot="field">
            <div class="flex mx-auto px-2 flex-col">
                <select v-model="frequency"
                        class="form-control form-select form-input-bordered mb-3"
                        @change="changeFrequency"
                >
                    <option v-for="freq in dict" :value="freq.id">{{ translate(freq.id) }}</option>
                </select>
                <daily-form v-if="frequency==1" :value.sync="valString" :locale="field.locale"></daily-form>
                <weekly-form v-if="frequency==2" :value.sync="valString" :locale="field.locale"></weekly-form>
                <monthly-by-day-form v-if="frequency==3" :value.sync="valString"
                                     :locale="field.locale"></monthly-by-day-form>
                <monthly-by-date-form v-if="frequency==4" :value.sync="valString"
                                      :locale="field.locale"></monthly-by-date-form>
                <yearly-by-day-form v-if="frequency==5" :value.sync="valString"
                                    :locale="field.locale"></yearly-by-day-form>
                <yearly-by-date-form v-if="frequency==6" :value.sync="valString"
                                     :locale="field.locale"></yearly-by-date-form>
                <yearly-by-week-no-form v-if="frequency==7" :value.sync="valString"
                                        :locale="field.locale"></yearly-by-week-no-form>
                <end-selector :value.sync="endString" :locale="field.locale"></end-selector>
                <input v-show="!hide"
                       :id="field.name"
                       type="text"
                       class="w-full form-control form-input form-input-bordered"
                       :class="errorClasses"
                       :placeholder="field.name"
                       v-model="value"
                       readonly="readonly"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import DailyForm from "./tools/DailyForm";
import WeeklyForm from "./tools/WeeklyForm";
import MonthlyByDayForm from "./tools/MonthlyByDayForm";
import MonthlyByDateForm from "./tools/MonthlyByDateForm";
import YearlyByDateForm from "./tools/YearlyByDateForm";
import YearlyByDayForm from "./tools/YearlyByDayForm";
import YearlyByWeekNoForm from "./tools/YearlyByWeekNoForm";
import EndSelector from "./tools/EndSelector";

export default {
    mixins: [FormField, HandlesValidationErrors],
    props: ['resourceName', 'resourceId', 'field', 'errors'],
    data() {
        return {
            original: '',
            frequency: 1,
            valString: '',
            endString: '',

            dict:
                [
                    {id: 1, nl: 'Dagelijks', en: 'Daily', value: 'DAILY'},
                    {id: 2, nl: 'Wekelijks', en: 'Weekly', value: 'WEEKLY'},
                    {id: 3, nl: 'Maandelijks bij dag', en: 'Monthly by day', value: 'MONTHLY'},
                    {id: 4, nl: 'Maandelijks bij datum', en: 'Monthly by date', value: 'MONTHLY'},
                    {id: 5, nl: 'Jaarlijks by dag', en: 'Yearly by day', value: 'YEARLY'},
                    {id: 6, nl: 'Jaarlijks bij datum', en: 'Yearly by date', value: 'YEARLY'},
                    {id: 7, nl: 'Jaarlijks bij weeknr', en: 'Yearly by week no', value: 'YEARLY'},
                ],
        }
    },
    components: {
        'weekly-form': WeeklyForm,
        'daily-form': DailyForm,
        'monthly-by-day-form': MonthlyByDayForm,
        'monthly-by-date-form': MonthlyByDateForm,
        'yearly-by-date-form': YearlyByDateForm,
        'yearly-by-day-form': YearlyByDayForm,
        'yearly-by-week-no-form': YearlyByWeekNoForm,
        'end-selector': EndSelector,
    },
    watch: {
        valString: function () {
            this.setValue();
        },
        endString: function () {
            this.setValue();
        }
    },
    methods: {
        translate: function (field_) {
            return this.dict.find(x => x.id == field_)[this.field.locale];
        },
        changeFrequency() {
            switch (this.frequency) {
                case 1:
                    this.value = 'FREQ=DAILY;INTERVAL=1;';
                    break;
                case 2:
                    this.value = 'FREQ=WEEKLY;INTERVAL=1;BYDAY=MO,TU,WE,TH,FR';
                    break;
                case 3:
                    this.value = 'FREQ=MONTHLY;INTERVAL=1;BYDAY=1MO';
                    break;
                case 4:
                    this.value = 'FREQ=MONTHLY;INTERVAL=1;BYMONTHDAY=1';
                    break;
                case 5:
                    this.value = 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYDAY=1MO';
                    break;
                case 6:
                    this.value = 'FREQ=YEARLY;INTERVAL=1;BYMONTH=1;BYMONTHDAY=1';
                    break;
                case 7:
                    this.value = 'FREQ=YEARLY;INTERVAL=1;BYWEEKNO=1;BYDAY=MO,TU,WE,TH,FR';
                    break;
            }
            this.setForm();
        },
        setForm() {
            switch (this.value.split(";")[0].split('=')[1]) {
                case 'DAILY':
                    this.frequency = 1;
                    break;
                case 'WEEKLY':
                    this.frequency = 2;
                    break;
                case 'MONTHLY':
                    if (this.value.match(/BYMONTHDAY/g)) {
                        this.frequency = 4;
                    } else {
                        this.frequency = 3;
                    }
                    break;
                case 'YEARLY':
                    if (this.value.match(/BYMONTHDAY/g)) {
                        this.frequency = 6;
                    } else if (this.value.match(/BYWEEKNO/g)) {
                        this.frequency = 7;
                    } else {
                        this.frequency = 5;
                    }
                    break;
            }
            let params = this.value.split(';');
            self = this;
            params.forEach(function (val) {

                switch (val.split('=')[0]) {
                    case 'UNTIL':
                        self.endString = val;
                        break;
                    case 'COUNT':
                        self.endString = val;
                        break;
                }
            });

            this.valString = this.value;

            //remove an ending string if it is defined
            let start_until = this.value.indexOf('UNTIL');
            if(start_until!==-1){
                this.valString = this.value.substr(0,start_until).replace(/;*$/,"");
            }
            let start_count = this.value.indexOf('COUNT');
            if(start_count!==-1){
                this.valString = this.value.substr(0,start_count).replace(/;*$/,"");
            }
        },
        setValue() {
            this.value = (this.valString.replace(/;*$/,"") + ';' + this.endString).replace(/;*$/,"");
        }
        ,
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || 'FREQ=WEEKLY;INTERVAL=1;BYDAY=MO,TU,WE,TH,FR';
            this.original = this.value;
            if (!this.field.locale) {
                this.field.locale = 'en';
            }
            if (this.field.hide) {
                this.hide = true;
            }
            this.setForm();
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        }
        ,

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        }
        ,
    }
    ,
}
</script>
