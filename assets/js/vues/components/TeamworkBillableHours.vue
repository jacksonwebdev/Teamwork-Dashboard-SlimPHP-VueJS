<template>

    <div class="ui middle aligned centered grid">
        <div class="floating column">
            <br>

            <TeamworkBillableHoursFull :tick="tick" :total-billable-hours=totalBillableHours :hours-left="hoursLeft" :company="company" />

            <div class="ui three column grid teamworkBillableHours">
                <TeamworkBillableHoursSingle type="woo" />
                <TeamworkBillableHoursSingle type="magento" />
                <TeamworkBillableHoursSingle type="web_app" />
            </div>
            <div class="ui divider"></div>
        </div>
    </div>
</template>

<script>

import company from '../../data';

// use event bus emitter
import EventBus from './helpers/eventBus';

import TeamworkBillableHoursFull from './TeamworkBillableHoursFull.vue';
import TeamworkBillableHoursSingle from './TeamworkBillableHoursSingle.vue';

export default {
    name: "TeamworkBillableHours",
    props: {
    },
    data: function () { 
        return {
            totalBillableHours: 0.00,
            hoursLeft: 0,
            company: company.settings,
            tick: 0
        } 
    },
    computed: {},
    components: {
        TeamworkBillableHoursFull,
        TeamworkBillableHoursSingle
    },
    methods: {
        onLoadedChild (payload) {
            
        }
    },
    mounted () {
        EventBus.$on('loaded', ( payload ) => {
            if ( payload ) {
                this.totalBillableHours += payload.time;
                this.hoursLeft = company.settings.company_targets.expected_capacity_hours - this.totalBillableHours;
                this.hoursLeft = this.hoursLeft.toFixed(2);

                this.tick += payload.tick;
               
                EventBus.$emit( 'progress_init' );
                
            }
        });
    }
    
}
</script>