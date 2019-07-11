<template>
    <div class="ui accordion" v-if="info">
        <div class="title">
            <i class="dropdown icon"></i>
            Show All Projects
        </div>
        <div class="content ">
            <table class="ui stable">
                <tbody>
                    <tr class="company_info"
                        v-for="company_info in info.company_info" 
                        v-bind:key="company_info.id"
                    >
                        <td >
                            <img :alt="company_info.company_name" class="ui tiny image" :src="company_info.company_logo">
                        </td>
                        <td>
                            <span class="right floated">
                                <div class="ui mini horizontal statistics">
                                    <div class="statistic">
                                        <div class="value">{{ company_info.billable_hours }}</div>
                                        <div class="label">Hours</div>
                                    </div>
                                </div>
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>

export default {
    name: "TeamworkProjectAccordion",
    props: {
        info: Object,
    },
    data: function () {
        return {}
    },
    mounted () {
        if ( this.info ) {
            $(this.$el).accordion();
        }
    }
}
</script>