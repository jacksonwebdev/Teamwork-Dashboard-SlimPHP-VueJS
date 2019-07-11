<template>
    <div id="dashboard-app">
        <TeamworkRetainedHours />
        <TeamworkBillableHours />
    </div>
</template>

<script>
import TeamworkRetainedHours from './components/TeamworkRetainedHours.vue';
import TeamworkBillableHours from './components/TeamworkBillableHours.vue';

export default {
  name: 'app',
  components: {
    TeamworkRetainedHours,
    TeamworkBillableHours
  }
}
</script>
