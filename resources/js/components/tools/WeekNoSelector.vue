<template>
    <div>
        <strong>{{translate(0)}}</strong>
        <table>

            <tr>
                <td>
                    <ul>
                        <li v-for="i in [1,2,3,4,5,6,7,8,9,10]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [11,12,13,14,15,16,17,18,19,20]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [21,22,23,24,25,26,27,28,29,30]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [31,32,33,34,35,36,37,38,39,40]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [41,42,43,44,45,46,47,48,49,50]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
                <td>
                    <ul>
                        <li v-for="i in [51,52]">
                            <label :for="'p'+i"><input :id="'p'+i"  type="checkbox" v-model="weeks[i]" @change="setValue"><span
                                    class="text-sm ml-3 mr-8">{{i}}</span></label><br>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>


    </div>
</template>

<script>
    export default {
        name: "WeekNoSelector",
        props: {
            value: {
                type: String,
                //required: true,
                default: () => {
                    return 'BYWEEKNO=';
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
                weeksNumbers: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52],
                weeks: [false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false],
                dict: [
                    {value: 0, nl: "Op deze weken van het jaar", en: 'On these weeks of the year'},
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
                this.weeks= [false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false, false, false, false, false, false, false, false,
                    false, false, false];
                    params.forEach(function (value) {
                        self.weeks[value] = true;
                    });
            },
            setValue() {
                let weeksString = 'BYWEEKNO=';
                for (let i = 1; i < 53; i++) {
                    if (this.weeks[i]) {
                        weeksString += i + ',';
                    }
                }
                this.value = weeksString.replace(/,+$/g, '');
                this.$emit('update:value', this.value);
            }
        }
    }
</script>

<style scoped>
    ul {margin:0;padding:0;}
    li {margin:0;padding:0;list-style:none;}
    td {vertical-align: top;}
</style>