<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">

            <div class="flex mx-auto px-2 flex-col">
                <select v-model="frequency_"
                        class="form-control form-select form-input-bordered mb-3"
                        @change="makeRule"
                >
                    <option v-for="freq in freqs" :value="freq.id">{{translate(freq)}}</option>
                </select>
                <select v-model="interval_d" v-show="frequency_===1" @change="makeRule"
                        class="form-control form-select form-input-bordered mb-3">
                    <option v-for="daily in dailies" :value="daily.value">{{translate(daily)}}</option>
                </select>
                <tag-selector v-show="frequency_===2"
                              v-model="byday_w"
                              :existing-tags="translate(weekdays,true)"
                              :typeahead="true"
                              :only-existing-tags="true"
                              :placeholder="translate(commands.add_day)"
                              :typeahead-activation-threshold="0"
                              @tags-updated="makeRule"
                ></tag-selector>


                <select v-model="interval_w" v-show="frequency_===2" @change="makeRule"
                        class="form-control form-select form-input-bordered mb-3">
                    <option v-for="weekly in weeklies" :value="weekly.value">{{translate(weekly)}}</option>
                </select>
                <select v-model="interval_m" v-show="frequency_===3 || frequency_===4" @change="makeRule"
                        class="form-control form-select form-input-bordered mb-3">
                    <option v-for="monthly in weeklies" :value="monthly.value">{{translate(monthly)}}</option>
                </select>


                <select v-model="interval_y" v-show="frequency_===5||frequency_===6" @change="makeRule"
                        class="form-control form-select form-input-bordered mb-3">
                    <option v-for="yearly in yearlies" :value="yearly.value">{{translate(yearly)}}</option>
                </select>

                <tag-selector v-show="frequency_===5||frequency_===6"
                              v-model="bymonth_"
                              :existing-tags="translate(months,true)"
                              :typeahead="true"
                              :only-existing-tags="true"
                              :placeholder="translate(commands.add_month)"
                              :typeahead-activation-threshold="0"
                              @tags-updated="makeRule"
                ></tag-selector>

                <tag-selector v-show="frequency_===3||frequency_===5"
                              v-model="byday_m"
                              :existing-tags="translate(rankedWeekdays,true)"
                              :typeahead="true"
                              :only-existing-tags="true"
                              :placeholder="translate(commands.add_day)"
                              :typeahead-activation-threshold="0"
                              @tags-updated="makeRule"
                ></tag-selector>

                <tag-selector v-show="frequency_===4||frequency_===6"
                              v-model="bymonthday_"
                              :existing-tags="monthlydays"
                              :typeahead="true"
                              :only-existing-tags="true"
                              :placeholder="translate(commands.add_day)"
                              :typeahead-activation-threshold="0"
                              @tags-updated="makeRule"
                ></tag-selector>

                <div class="flex-row">
                    <button @click.prevent="stop_='repeat'" class="bg-primary m-3 p-2 rounded min-w-8">{{translate(commands.repeat)}}</button>
                    <button @click.prevent="stop_='until'" class="bg-primary m-3 p-2 rounded min-w-8">{{translate(commands.until)}}</button>
                    <button @click.prevent="stop_='occurrence'" class="bg-primary m-3 p-2 rounded min-w-8">
                        {{translate(commands.occurrence)}}
                    </button>
                </div>
                <input type="date" v-model="until_" class="form-control form-input-bordered form-input mb-3"
                       v-if="stop_==='until'" @change="makeRule">
                <input type="number" min="1" v-model="count_" class="form-control form-input form-input-bordered mb-3"
                       v-if="stop_==='occurrence'" @change="makeRule">
            </div>
            <input  v-show="!hide"
                    :id="field.name"
                    type="text"
                    class="w-full form-control form-input form-input-bordered"
                    :class="errorClasses"
                    :placeholder="field.name"
                    v-model="value"
                    readonly="readonly"
            />
        </template>
    </default-field>
</template>

<script>
    import TagSelector from './tools/TagSelector';
    import {FormField, HandlesValidationErrors} from 'laravel-nova'

    export default {
        mixins: [FormField, HandlesValidationErrors],
        props: ['resourceName', 'resourceId', 'field'],
        data() {
            return {
                commands:
                    {
                        add_month: {nl: "Maand toevoegen...", en: "Add a month..."},
                        add_day: {nl: "Dag toevoegen...", en: "Add a day..."},
                        repeat: {nl: "Herhaal",en:'repeat'},
                        until: {nl:'Tot',en:'Until'},
                        occurrence: {nl:'Aantal herhalingen',en:'Occurrence(s)'}
                    }
                ,
                freqs:
                    [{id: 1, nl: 'Dagelijks', en: 'Daily', value: 'DAILY'},
                        {id: 2, nl: 'Wekelijks', en: 'Weekly', value: 'WEEKLY'},
                        {id: 3, nl: 'Maandelijks bij dag', en: 'Monthly by day', value: 'MONTHLY'},
                        {id: 4, nl: 'Maandelijks bij datum', en: 'Monthly by date', value: 'MONTHLY'},
                        {id: 5, nl: 'Jaarlijks by dag', en: 'Yearly by day', value: 'YEARLY'},
                        {id: 6, nl: 'Jaarlijks bij datum', en: 'Yearly by date', value: 'YEARLY'}
                    ],

                dailies: [{value: 1, nl: "Elke dag", en: "Every day"},
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
                weeklies: [
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
                monthlies: [
                    {value: 1, nl: "Elke maand", en: "Every month"},
                    {value: 2, nl: "Om de maand", en: "Every other month"},
                    {value: 3, nl: "Elke 3e maand", en: "Every 3rd month"},
                    {value: 4, nl: "Elke 4e maand", en: "Every 4th month"},
                    {value: 5, nl: "Elke 5e maand", en: "Every 5th month"},
                    {value: 6, nl: "Elke 6e maand", en: "Every 6th month"},
                    {value: 7, nl: "Elke 7e maand", en: "Every 7th month"},
                    {value: 8, nl: "Elke 8e maand", en: "Every 8th month"},
                    {value: 9, nl: "Elke 9e maand", en: "Every 9th month"},
                    {value: 10, nl: "Elke 10e maand", en: "Every 10th month"},
                    {value: 11, nl: "Elke 11e maand", en: "Every 11th month"},
                    {value: 12, nl: "Elke 12e maand", en: "Every 12th month"},
                    {value: 18, nl: "Elke 18e maand", en: "Every 18th month"},
                    {value: 24, nl: "Elke 24e maand", en: "Every 24th month"},
                    {value: 36, nl: "Elke 36e maand", en: "Every 36th month"},
                    {value: 48, nl: "Elke 48e maand", en: "Every 48th month"},

                ],
                yearlies: [
                    {value: 1, nl: "Elk jaar", en: "Every year"},
                    {value: 2, nl: "Om het jaar", en: "Every other year"},
                    {value: 3, nl: "Elk 3e jaar", en: "Every 3rd year"},
                    {value: 4, nl: "Elk 4e jaar", en: "Every 4th year"},
                    {value: 5, nl: "Elk 5e jaar", en: "Every 5th year"},
                    {value: 6, nl: "Elk 6e jaar", en: "Every 6th year"},
                    {value: 7, nl: "Elk 7e jaar", en: "Every 7th year"},
                    {value: 8, nl: "Elk 8e jaar", en: "Every 8th year"},
                    {value: 9, nl: "Elk 9e jaar", en: "Every 9th year"},
                ],
                weekdays: [
                    {value: 'SU', nl: "Zondag", en: 'Sunday'},
                    {value: 'MO', nl: "Maandag", en: 'Monday'},
                    {value: 'TU', nl: "Dinsdag", en: 'Tuesday'},
                    {value: 'WE', nl: "Woensdag", en: 'Wednesday'},
                    {value: 'TH', nl: "Donderdag", en: 'Thursday'},
                    {value: 'FR', nl: "Vrijdag", en: 'Friday'},
                    {value: 'SA', nl: "Zaterdag", en: 'Saterday'},
                ],
                months: [
                    {value: "1", nl: "januari", en: "January"},
                    {value: "2", nl: "februari", en: "February"},
                    {value: "3", nl: "maart", en: "March"},
                    {value: "4", nl: "april", en: "April"},
                    {value: "5", nl: "mei", en: "May"},
                    {value: "6", nl: "juni", en: "June"},
                    {value: "7", nl: "juli", en: "July"},
                    {value: "8", nl: "augustus", en: "August"},
                    {value: "9", nl: "september", en: "September"},
                    {value: "10", nl: "oktober", en: "October"},
                    {value: "11", nl: "november", en: "November"},
                    {value: "12", nl: "december", en: "December"},
                ],
                rankedWeekdays: [
                    {value: '1SU', nl: 'eerste zondag', en: 'First Sunday'},
                    {value: '1MO', nl: 'eerste maandag', en: 'First Monday'},
                    {value: '1TU', nl: 'eerste dinsdag', en: 'First Tuesday'},
                    {value: '1WE', nl: 'eerste woensdag', en: 'First Wednesday'},
                    {value: '1TH', nl: 'eerste donderdag', en: 'First Thursday'},
                    {value: '1FR', nl: 'eerste vrijdag', en: 'First Friday'},
                    {value: '1SA', nl: 'eerste zaterdag', en: 'First Saterday'},
                    {value: '2SU', nl: 'tweede zondag', en: 'Second Sunday'},
                    {value: '2MO', nl: 'tweede maandag', en: 'Second Monday'},
                    {value: '2TU', nl: 'tweede dinsdag', en: 'Second Tuesday'},
                    {value: '2WE', nl: 'tweede woensdag', en: 'Second Wednesday'},
                    {value: '2TH', nl: 'tweede donderdag', en: 'Second Thursday'},
                    {value: '2FR', nl: 'tweede vrijdag', en: 'Second Friday'},
                    {value: '2SA', nl: 'tweede zaterdag', en: 'Second Saterday'},
                    {value: '3SU', nl: 'derde zondag', en: 'Third Sunday'},
                    {value: '3MO', nl: 'derde maandag', en: 'Third Monday'},
                    {value: '3TU', nl: 'derde dinsdag', en: 'Third Tuesday'},
                    {value: '3WE', nl: 'derde woensdag', en: 'Third Wednesday'},
                    {value: '3TH', nl: 'derde donderdag', en: 'Third Thursday'},
                    {value: '3FR', nl: 'derde vrijdag', en: 'Third Friday'},
                    {value: '3SA', nl: 'derde zaterdag', en: 'Third Saterday'},
                    {value: '4SU', nl: 'vierde zondag', en: 'Fourth Sunday'},
                    {value: '4MO', nl: 'vierde maandag', en: 'Fourth Monday'},
                    {value: '4TU', nl: 'vierde dinsdag', en: 'Fourth Tuesday'},
                    {value: '4WE', nl: 'vierde woensdag', en: 'Fourth Wednesday'},
                    {value: '4TH', nl: 'vierde donderdag', en: 'Fourth Thursday'},
                    {value: '4FR', nl: 'vierde vrijdag', en: 'Fourth Friday'},
                    {value: '4SA', nl: 'vierde zaterdag', en: 'Fourth Saterday'},
                    {value: '5SU', nl: 'vijfde zondag', en: 'Fifth Sunday'},
                    {value: '5MO', nl: 'vijfde maandag', en: 'Fifth Monday'},
                    {value: '5TU', nl: 'vijfde dinsdag', en: 'Fifth Tuesday'},
                    {value: '5WE', nl: 'vijfde woensdag', en: 'Fifth Wednesday'},
                    {value: '5TH', nl: 'vijfde donderdag', en: 'Fifth Thursday'},
                    {value: '5FR', nl: 'vijfde vrijdag', en: 'Fifth Friday'},
                    {value: '5SA', nl: 'vijfde zaterdag', en: 'Fifth Saterday'},
                    {value: '-1SU', nl: 'laatste zondag', en: 'Last Sunday'},
                    {value: '-1MO', nl: 'laatste maandag', en: 'Last Monday'},
                    {value: '-1TU', nl: 'laatste dinsdag', en: 'Last Tuesday'},
                    {value: '-1WE', nl: 'laatste woensdag', en: 'Last Wednesday'},
                    {value: '-1TH', nl: 'laatste donderdag', en: 'Last Thursday'},
                    {value: '-1FR', nl: 'laatste vrijdag', en: 'Last Friday'},
                    {value: '-1SA', nl: 'laatste zaterdag', en: 'Last Saterday'},
                ],
                frequency_: '2',
                interval_d: '',
                interval_w: '',
                interval_m: '',
                interval_y: '',
                until_: '',
                count_: 0,
                byday_w: [],
                byday_m: [],
                bymonthday_: [],
                bymonth_: [],
                stop_: '',
                hide:false,
            }
        },
        components: {
            'tag-selector':
            TagSelector,
        }
        ,
        computed: {
            monthlydays: function () {
                let a = {};
                for (let i = 1; i < 32; i++) {
                    if (this.field.locale == 'nl') {
                        a[i] = i + 'e dag';
                    } else {
                        a[i] = i + 'th day';
                    }

                }
                return a;
            }
        }
        ,
        methods: {
            translate: function (field, convert = false) {
                if (!convert) {
                    switch (this.field.locale) {
                        case "nl":
                            return field.nl;
                        default:
                            return field.en;
                    }
                } else {
                    var self = this;
                    let a = {};
                    field.forEach(function (el) {
                        if (self.field.locale == 'nl') {
                            a[el.value] = el.nl;
                        } else {
                            a[el.value] = el.en;
                        }
                    });
                    return a;
                }
            }
            ,

            makeRule: function () {
                let a = [];
                //Frequency
                a.push("FREQ=" + this.freqs.find(x => x.id == this.frequency_).value);
                switch (this.frequency_) {
                    case 1: //daily
                        //interval
                        if (!this.interval_d) {
                            this.interval_d = 1;
                        }
                        a.push("INTERVAL=" + this.interval_d);
                        break;
                    case 2: //weekly
                        //interval
                        if (!this.interval_w) {
                            this.interval_w = 1;
                        }
                        a.push("INTERVAL=" + this.interval_w);
                        if (!this.byday_w.length) {
                            this.byday_w.push('MO');
                        }
                        a.push('BYDAY=' + this.byday_w.join(","))

                        break;
                    case 3: //monthly by day
                        //interval
                        if (!this.interval_m) {
                            this.interval_m = 1;
                        }
                        a.push("INTERVAL=" + this.interval_m);
                        if (!this.byday_m.length) {
                            this.byday_m.push('1MO');
                        }
                        a.push('BYDAY=' + this.byday_m.join(","))
                        break;
                    case 4: //monthly by date
                        //interval
                        if (!this.interval_m) {
                            this.interval_m = 1;
                        }
                        a.push("INTERVAL=" + this.interval_m);
                        if (!this.bymonthday_.length) {
                            this.bymonthday_.push(1)
                        }
                        a.push('BYMONTHDAY=' + this.bymonthday_.join(","));

                        break;
                    case 5:
                        //interval
                        if (!this.interval_y) {
                            this.interval_y = 1;
                        }
                        a.push("INTERVAL=" + this.interval_y);
                        if (!this.bymonth_.length) {
                            this.bymonth_.push(1);
                        }
                        a.push("BYMONTH=" + this.bymonth_.join(","));
                        if (!this.byday_m.length) {
                            this.byday_m.push('1MO');
                        }
                        a.push('BYDAY=' + this.byday_m.join(","))
                        break;
                    case 6:
                        //interval
                        if (!this.interval_y) {
                            this.interval_y = 1;
                        }
                        a.push("INTERVAL=" + this.interval_y);
                        if (!this.bymonth_.length) {
                            this.bymonth_.push(1)
                        }
                        a.push("BYMONTH=" + this.bymonth_.join(","));
                        if (!this.bymonthday_.length) {
                            this.bymonthday_.push(1)
                        }
                        a.push('BYMONTHDAY=' + this.bymonthday_.join(","))
                }
                //Stop rrule
                if (this.stop_ === 'until') {
                    this.count_ = 0;
                    if (this.until_.length > 1) {
                        a.push("UNTIL=" + this.until_.split("-").join("") + "T000000Z")
                    } else {
                        //no until set (may be an default value...
                    }
                } else if (this.stop_ == 'occurrence') {
                    this.until_ = '';
                    if (this.count_ > 0) {
                        a.push('COUNT=' + this.count_);
                    }
                }

                this.value = a.join(";");
            }
            ,
            readRule() {
                let a = this.value.split(";");
                let self = this;
                a.forEach(function (value) {
                    let part = value.split("=");
                    switch (part[0]) {
                        case "FREQ":
                            switch (part[1]) {
                                case "DAILY":
                                    self.frequency_ = 1;
                                    break;
                                case "WEEKLY":
                                    self.frequency_ = 2;
                                    break;
                                case "MONTHLY":
                                    self.frequency_ = 3;
                                    break;
                                case "YEARLY":
                                    self.frequency_ = 5;
                                    break;
                            }
                            break;
                        case "INTERVAL":
                            self.interval_d = part[1];
                            self.interval_w = part[1];
                            self.interval_m = part[1];
                            self.interval_y = part[1];
                            break;
                        case "BYDAY":
                            if (self.frequency_ == 2) {
                                self.byday_w = part[1].split(",");
                            } else {
                                self.byday_m = part[1].split(",");
                            }

                            break;
                        case "BYMONTH":
                            self.bymonth_ = part[1].split(",");
                            break;
                        case "BYMONTHDAY":
                            self.bymonthday_ = part[1].split(",");
                            if (self.frequency_ == 3) {
                                self.frequency_ = 4;
                            } else if (self.frequency_ == 5) {
                                self.frequency_ = 6;
                            }
                            break;
                    }
                });
            }
            ,
            /*
             * Set the initial, internal value for the field.
             */
            setInitialValue() {
                this.value = this.field.value || '';
                if (!this.field.locale) {
                    this.field.locale = 'en';
                }
                if(this.field.hide){
                    this.hide = true;
                }
                this.readRule();
            }
            ,

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
