<template>
    <div>
        {{ human }}
    </div>
</template>

<script setup>
import {computed, onMounted, ref, watch} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    locale: {
        type: String,
        default: 'en',
    }
})
const human = ref('')
const value = computed(() => {
    return props.modelValue || ''
})
const dict = [
    {i: 'MO', nl: 'maandag', en: 'monday'},
    {i: 'TU', nl: 'dinsdag', en: 'tuesday'},
    {i: 'WE', nl: 'woensdag', en: 'wednesday'},
    {i: 'TH', nl: 'donderdag', en: 'thursday'},
    {i: 'FR', nl: 'vrijdag', en: 'friday'},
    {i: 'SA', nl: 'zaterdag', en: 'saturday'},
    {i: 'SO', nl: 'zondag', en: 'sunday'},
    {i: '1MO', nl: '1e maandag', en: '1st monday'},
    {i: '1TH', nl: '1e dinsdag', en: '1st tuesday'},
    {i: '1WE', nl: '1e woensdag', en: '1st wednesday'},
    {i: '1TH', nl: '1e donderdag', en: '1st thursday'},
    {i: '1FR', nl: '1e vrijdag', en: '1st friday'},
    {i: '1SA', nl: '1e zaterdag', en: '1st saturday'},
    {i: '1SO', nl: '1e zondag', en: '1st sunday'},
    {i: '2MO', nl: '2e maandag', en: '2nd monday'},
    {i: '2TH', nl: '2e dinsdag', en: '2nd tuesday'},
    {i: '2WE', nl: '2e woensdag', en: '2nd wednesday'},
    {i: '2TH', nl: '2e donderdag', en: '2nd thursday'},
    {i: '2FR', nl: '2e vrijdag', en: '2nd friday'},
    {i: '2SA', nl: '2e zaterdag', en: '2nd saturday'},
    {i: '2SO', nl: '2e zondag', en: '2nd sunday'},
    {i: '3MO', nl: '3e maandag', en: '3th monday'},
    {i: '3TH', nl: '3e dinsdag', en: '3th tuesday'},
    {i: '3WE', nl: '3e woensdag', en: '3th wednesday'},
    {i: '3TH', nl: '3e donderdag', en: '3th thursday'},
    {i: '3FR', nl: '3e vrijdag', en: '3th friday'},
    {i: '3SA', nl: '3e zaterdag', en: '3th saturday'},
    {i: '3SO', nl: '3e zondag', en: '3th sunday'},
    {i: '4MO', nl: '4e maandag', en: '4th monday'},
    {i: '4TH', nl: '4e dinsdag', en: '4th tuesday'},
    {i: '4WE', nl: '4e woensdag', en: '4th wednesday'},
    {i: '4TH', nl: '4e donderdag', en: '4th thursday'},
    {i: '4FR', nl: '4e vrijdag', en: '4th friday'},
    {i: '4SA', nl: '4e zaterdag', en: '4th saturday'},
    {i: '4SO', nl: '4e zondag', en: '4th sunday'},
    {i: '5MO', nl: '5e maandag', en: '5th monday'},
    {i: '5TH', nl: '5e dinsdag', en: '5th tuesday'},
    {i: '5WE', nl: '5e woensdag', en: '5th wednesday'},
    {i: '5TH', nl: '5e donderdag', en: '5th thursday'},
    {i: '5FR', nl: '5e vrijdag', en: '5th friday'},
    {i: '5SA', nl: '5e zaterdag', en: '5th saturday'},
    {i: '5SO', nl: '5e zondag', en: '5th sunday'},
    {i: '-1MO', nl: 'laatste maandag', en: 'last monday'},
    {i: '-1TH', nl: 'laatste dinsdag', en: 'last tuesday'},
    {i: '-1WE', nl: 'laatste woensdag', en: 'last wednesday'},
    {i: '-1TH', nl: 'laatste donderdag', en: 'last thursday'},
    {i: '-1FR', nl: 'laatste vrijdag', en: 'last friday'},
    {i: '-1SA', nl: 'laatste zaterdag', en: 'last saturday'},
    {i: '-1SO', nl: 'laatste zondag', en: 'last sunday'},
    {i: 'daily', nl: 'Dagelijks', en: 'Daily'},
    {i: 'monthly', nl: 'Maandelijks', en: 'Monthly'},
    {i: 'weekly', nl: 'Wekelijks', en: 'Weekly'},
    {i: 'yearly', nl: 'Jaarlijks', en: 'Yearly'},
    {i: 'on', nl: 'op', en: 'on'},
    {i: 'week', nl: 'week', en: 'week'},
    {i: 'weeks', nl: 'weeks', en: 'weeks'},
    {i: 'day', nl: 'dag', en: 'day'},
    {i: 'days', nl: 'dagen', en: 'days'},
    {i: 'month', nl: 'maand', en: 'month'},
    {i: 'months', nl: 'maands', en: 'months'},
    {i: 'year', nl: 'jaar', en: 'year'},
    {i: 'years', nl: 'jaren', en: 'years'},
    {i: 'of', nl: 'van', en: 'of'},
    {i: '', nl: '', en: ''},
    {i: 'the', nl: 'de', en: 'the'},
    {i: 'with', nl: 'met', en: 'with'},
    {i: 'repeats', nl: 'herhalingen', en: 'repeats'},
    {i: 'repeat', nl: 'herhaling', en: 'repeat'},
    {i: 'till', nl: 'tot', en: 'till'},
    {i: '1th', nl: '1e', en: '1st'},
    {i: '2th', nl: '2e', en: '2nd'},
    {i: 'th', nl: 'e', en: 'th'},
    {i: '1m', nl: 'januari', en: 'January'},
    {i: '2m', nl: 'februari', en: 'February'},
    {i: '3m', nl: 'maart', en: 'March'},
    {i: '4m', nl: 'april', en: 'April'},
    {i: '5m', nl: 'mei', en: 'May'},
    {i: '6m', nl: 'juni', en: 'June'},
    {i: '7m', nl: 'juli', en: 'July'},
    {i: '8m', nl: 'augustus', en: 'August'},
    {i: '9m', nl: 'september', en: 'September'},
    {i: '10m', nl: 'oktober', en: 'October'},
    {i: '11m', nl: 'november', en: 'November'},
    {i: '12m', nl: 'december', en: 'December'},
    {i: 'every', nl: 'Om de', en: 'Every'},
    {i: 'every other', nl: 'Om de', en: 'Every other'},
    {i: 'and', nl: 'en', en: 'and'},
    {i: 'once', nl: 'eenmalig', en: 'once'},
]

const __ = (field) => {
    let item = dict.find(x => x.i === field)
    if (item) {
        return item[props.locale]
    }
    return field
}
watch(value, () => {
    if (value.value.length) {
        makeHuman()
    }
})
onMounted(() => {
    if (value.value.length) {
        makeHuman()
    }
})
const makeHuman = () => {
    let temp = ''
    let out = ''
    let freq = value.value.split(';').find(x => x.includes('FREQ')).split('=')[1]
    let interval = 0
    let when = ''
    if (value.value.includes('INTERVAL')) {
        interval = value.value.split(';').find(x => x.includes('INTERVAL')).split('=')[1]
    }
    let till = ''
    if (value.value.includes('UNTIL')) {
        temp = value.value.split(';').find(x => x.includes('UNTIL')).split('=')[1]
        if (temp.length > 10) {
            if (props.locale === 'nl') {
                till = __('till') + ' ' + temp.substring(6, 8) + '-' + temp.substring(4, 6) + '-' + temp.substring(0, 4)
            } else {
                till = __('till') + ' ' + temp.substring(4, 6) + '/' + temp.substring(6, 8) + '/' + temp.substring(0, 4)
            }
        }
    }
    if (value.value.includes('COUNT')) {
        temp = value.value.split(';').find(x => x.includes('COUNT')).split('=')[1] || 0
        if (Number(temp) === 1) {
            till = __('once')
        } else if (temp > 1) {
            till = `${__('with')}  ${temp}  ${__('repeats')}`
        }
    }

    let bydays = []
    if (value.value.includes('BYDAY')) {
        bydays = value.value.split(';').find(x => x.includes('BYDAY')).split('=')[1].split(',')
    }
    let bymonths = []
    if (value.value.includes('BYMONTH')) {
        bymonths = value.value.split(';').find(x => x.includes('BYMONTH')).split('=')[1].split(',')
    }
    let weekno = []
    if (value.value.includes('WEEKNO')) {
        weekno = value.value.split(';').find(x => x.includes('WEEKNO')).split('=')[1].split(',')
    }
    let bymonthday = []
    if (value.value.includes('BYMONTHDAY')) {
        bymonthday = value.value.split(';').find(x => x.includes('BYMONTHDAY')).split('=')[1].split(',')
    }
    if (bymonthday.length && bymonthday[0].length) {
        temp = []
        if (freq === 'YEARLY') {
            if (bymonths.length) {
                bymonths.forEach(month => {
                    bymonthday.forEach(day => {
                        if (props.locale === 'nl') {
                            temp.push(day + '/' + month)
                        } else {
                            temp.push(month + '/' + day)
                        }
                    })
                })
                when = joinToString(temp)
            }
        } else if (freq === 'MONTHLY') {
            bymonthday.forEach(day => {
                if (props.locale === 'nl') {
                    temp.push(day + 'e')
                } else {
                    temp.push(__(day + 'th'))
                }
            })
            when = ' ' + __('on') + ' ' + __('the') + ' ' + joinToString(temp)
        }

    } else if (bydays.length && bydays[0].length) {
        temp = []
        if (bymonths.length) {
            bydays.forEach(day => {
                bymonths.forEach(month => {
                    temp.push(__(day) + ' ' + __('of') + ' ' + __(month + 'm')) //translate
                })
            })
            when = joinToString(temp)
        } else if (weekno.length) {
            bydays.forEach(day => {
                weekno.forEach(week => {
                    if (week < 3) {
                        temp.push(__(day) + ' ' + __('of') + ' ' + __(week + 'th') + ' ' + __('week'))
                    } else {
                        temp.push(__(day) + ' ' + __('of') + ' ' + week + __('th') + ' ' + __('week'))
                    }
                })
            })
            when = __('on') + ' ' + joinToString(temp)
        } else {
            bydays.forEach(day => {
                temp.push(__(day)) //translate
            })
            when = __('on') + ' ' + __('the') + ' ' + joinToString(temp)
        }
    }

    if (freq === 'DAILY') {
        out = __('daily')
        if (interval > 1) {
            if (Number(interval) === 2) {
                out = __('every other') + ' ' + __('day')
            } else {
                out = __('every') + ' ' + interval + ' ' + __('days')
            }
        }
    }
    if (freq === 'WEEKLY') {
        out = __('weekly')
        if (interval > 1) {
            if (Number(interval) === 2) {
                out = __('every other') + ' ' + __('week')
            } else {
                out = __('every') + ' ' + interval + ' ' + __('weeks')
            }
        }
    }
    if (freq === 'MONTHLY') {
        out = __('monthly')
        if (interval > 1) {
            if (Number(interval) === 2) {
                out = __('every other') + ' ' + __('month')
            } else {
                out = __('every') + ' ' + interval + ' ' + __('months')
            }
        }
    }
    if (freq === 'YEARLY') {
        out = __('yearly')
        if (interval > 1) {
            if (Number(interval) === 2) {
                out = __('every other') + ' ' + __('year')
            } else {
                out = __('every') + ' ' + interval + ' ' + __('years')
            }
        }
    }

    human.value = out + ' ' + when + ' ' + till
}
const joinToString = (a) => {
    if (a.length === 1) {
        return a[0]
    } else if (a.length === 2) {
        return a.join(' ' + __('and') + ' ')
    } else {
        let lastItem = a.pop()
        return a.join(', ') + ' ' + __('and') + ' ' + lastItem
    }
}
</script>
