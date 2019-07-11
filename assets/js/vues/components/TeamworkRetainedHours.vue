<template>
    <div>

        <h2 class="ui header">Capacity in Hours</h2>
        <div class="ui inverted segment">
            <SemanticUIProgressBar :label="hours_left_label" :progressValue="this.company.company_targets.retained_hours.total_retained_hours" :progressTotal="this.company.company_targets.expected_capacity_hours" />
        </div>
        <h3 class="ui header"> Retained Hours:</h3>
        <div class="ui statistics">
            <div class="statistic">
                <div class="value">{{ this.company.company_targets.retained_hours.woo_retained_hours.hours }}</div>
                <div class="label">Woo Hours</div>
            </div>
            <div class="statistic">
                <div class="value">{{ this.company.company_targets.retained_hours.magento_retained_hours.hours }}</div>
                <div class="label">Magento Hours</div>
            </div>
            <div class="statistic">
                <div class="value">{{ this.company.company_targets.retained_hours.web_app_retained_hours.hours }}</div>
                <div class="label">Custom Hours</div>
            </div>
            <div class="statistic">
                <div class="value">|</div>
            </div>
            <div class="statistic">
                <div class="value">{{ this.company.company_targets.retained_hours.total_retained_hours }}</div>
                <div class="label">Total Hours</div>
            </div>
        </div>

        <div class="ui divider"></div>

    </div>
</template>

<script>

import company from '../../data';

import SemanticUIProgressBar from './UI/SemanticUIProgressBar.vue';

export default {
    name: 'app',
    props: {},
    data: function () { 
        return {
            company: company.settings,
        } 
    },
    components: {
        SemanticUIProgressBar
    },
    computed: {
        hours_left_label: function(){
            return ( this.company.company_targets.expected_capacity_hours - this.company.company_targets.retained_hours.total_retained_hours ).toFixed(2) + ' hours left to sell'
        }
    }
}
</script>
