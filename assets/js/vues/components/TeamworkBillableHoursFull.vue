<template>
    <div>
        <h2 class="ui header">{{ settings.month }}'s Team Billable Target ({{ this.company.company_targets.expected_capacity_hours }} Hours)</h2>

        <div class="ui inverted segment">
            <div class="ui items">
                <div class="item">
                    <div class="image">
                        <img class="ui avatar image" src="assets/images/coolblueweb-logo.png">
                    </div>
                    <div class="content">
                        <div class="meta">
                            <span>Progress</span>
                        </div>
                        <div class="description">
                            
                            <SemanticUIProgressBar :progressValue="this.totalBillableHours" :progressTotal="this.company.company_targets.full_capacity_hours" />
                            
                            <div class="ui statistics">
                                <div class="statistic">
                                    <div class="value">{{ this.totalBillableHours }}</div>
                                    <div class="label">Hours</div>
                                </div>
                                <div class="statistic">
                                    <div class="value">/</div>
                                </div>
                                <div class="statistic">
                                    <div class="value">{{ this.company.company_targets.expected_capacity_hours }}</div>
                                    <div class="label">Hours</div>
                                </div>
                                <div class="statistic">
                                    <div class="value">| </div>
                                </div>
                                <div class="statistic hours-left">
                                    <div class="value">{{ this.hoursLeft }}</div>
                                    <div class="label">Hours Left</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui divider"></div>
    </div>

</template>

<script>

import util from '../../util';

import SemanticUIProgressBar from './UI/SemanticUIProgressBar.vue';

// use event bus emitter
import EventBus from './helpers/eventBus';

export default {
    name: "TeamworkBillableHours",
    props: {
        company: Object,
        hoursLeft: 0,
        totalBillableHours: Number,
        tick: Number
    },
    components: {
        SemanticUIProgressBar
    },
    data: function () {
        return {
            settings: {
                month: util.getCurrentMonth()
            },
            loading: true
        }
    },
    mounted () {},
    methods: {},
    watch: { 
        // watch manual tick on data, wait for 3
        // to show that all platforms loaded
        tick: function(){
            if ( this.tick === 3 ) {
                this.loading = false;
                // not very pretty, but these jQuery progress bars are acting a little wonky
                // for now we have to track the number of children manually.
                // set timeout with arrow function to reference Vue version of setTimeout
                setTimeout(() => EventBus.$emit( 'progress_init' ), 1000);
            }
        }
    }
}
</script>