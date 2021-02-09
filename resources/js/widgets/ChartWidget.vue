<template>
    <div class="w-full">
        <div :is="typeChart" :episodes="episodes" />
    </div>
</template>

<script>

import LineChart from "../charts/LineChart";

export default {
    name: "ChartWidget",

    components: {
        LineChart,
    },

    props: {
        episodes: {type: [Array, Object], required: true},
        type: {type: String, default: 'line'},
    },

    computed: {
        typeChart() {
            return _.kebabCase(`${this.type}-chart`);
        }
    },

}
</script>
