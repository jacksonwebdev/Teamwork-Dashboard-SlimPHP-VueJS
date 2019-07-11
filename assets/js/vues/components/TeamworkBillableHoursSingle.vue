<template>
    <div class="column" v-bind:class="this.type">
       
        <div class="ui fluid card">
            <div v-if="loading" class="loading">
                <div class="ui active dimmer inverted">
                    <div class="ui loader"></div>
                </div>
            </div>
            <div class="content">
                <a class="header"><img class="ui avatar image" :src="settings.platform.avatar" >{{ settings.platform.title }}</a>
                <div class="meta">
                    <span>Progress</span>
                </div>
                <div class="description">
                    <SemanticUIProgressBar :progressValue="info.total_billable_time" :progressTotal="settings.platform.hours" />
                </div>
            </div>
            <div class="extra content">
                <div class="ui tiny statistics">
                    <div class="statistic">
                        <div class="value">{{ info.total_billable_time }}</div>
                        <div class="label">Hours</div>
                    </div>
                    <div class="statistic">
                        <div class="value">/</div>
                    </div>
                    <div class="statistic">
                        <div class="value">{{ settings.platform.hours }}</div>
                        <div class="label">Hours</div>
                    </div>
                </div>
            </div>
            <div class="extra content">
                <TeamworkProjectAccordion :info="info" />
            </div>
        </div>
        <div class="error" v-if="!loading && error"
            >
            {{ error }}
        </div>
    </div>
</template>

<script>

import company from '../../data';
import util from '../../util';

// use event bus emitter
import EventBus from './helpers/eventBus';

import TeamworkProjectAccordion from './TeamworkProjectAccordion.vue';
import SemanticUIProgressBar from './UI/SemanticUIProgressBar.vue';


const axios = require('axios');

export default {
    name: "TeamworkBillableHoursSingle",
    props: {
        type: String
    },
    components: {
        TeamworkProjectAccordion,
        SemanticUIProgressBar
    },
    data: function () {
        return {
            loading: true,
            error: false,
            required: false,
            settings: {
                retained_hours_type: '',
                platform: null
            },
            info: {
                company_info: [],
                total_billable_time: 0
            },
            payload: Object,
            tick: 1
        }
    },
    created () {
        var retained_hours = company.settings.company_targets.retained_hours;
        for (var retained_value in retained_hours) {
            if ( retained_hours.hasOwnProperty( retained_value ) ) {
                var containsType = retained_value.indexOf( this.type ) !== -1;
                if( containsType ) {
                    this.settings.retained_hours_type = retained_value;
                    this.settings.platform = retained_hours[retained_value];
                }
            }
        }
    },
    mounted () {
        util.log(this.type);
        axios
            .get( '/api/teamwork/hours/' + this.type )
            .then(response => {
                this.info.company_info = response.data.company_info;
                this.info.total_billable_time = parseFloat(response.data.total_billable_time.toFixed(2));
                this.payload = {
                    time: this.info.total_billable_time,
                    tick: this.tick
                }
            })
            .catch(error => {
                console.log(error)
                this.error = true
            })
            .finally(() => { 
                this.loading = false;
                EventBus.$emit('loaded', this.payload );
            });
    }
}
</script>