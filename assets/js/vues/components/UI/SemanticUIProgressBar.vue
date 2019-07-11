<template>
    <div class="ui large indicating progress" :class="inverted_class" :data-value="progressValue" :data-total="progressTotal" >
        <div class="bar">
            <div class="progress"></div>
        </div>
        <div v-if="this.label" class="label">{{ this.label }}</div>
    </div>
</template>

<script>

// use event bus emitter
import EventBus from '../helpers/eventBus';

export default {
    name: "SemanticUIProgressBar",
    props: {
        progressValue: 0,
        progressTotal: 0,
        label: String
    },
    data: function () {
        return {}
    },
    computed: {
        percent: function(){
            return ( Math.round( ( this.progressValue / this.progressTotal ) * 100 ) );
        },
        inverted_class: function() {
            if ( this.label ) { return 'inverted blue' } else { return ''; }
        }
    },
    mounted () {
        EventBus.$on('progress_init', () => {
            this.onLoadedEvent();
        });
    },
    methods: {
        // emit 
        onLoadedEvent() {
            this.initProgress();
        },
        initProgress() {
            // wonder twin powers activate. Form of: jQuery DOM active, VueJS Shadow DOM inactive
            // doesn't play well with others
            if ( this.percent ) {
                $(this.$el).progress('set percent', this.percent );
            }
            
        }
    }
}
</script>