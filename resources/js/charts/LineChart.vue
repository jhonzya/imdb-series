<script>

import { Line } from 'vue-chartjs';

const randomColor = require('randomcolor');

export default {
    name: "LineChart",

    extends: Line,

    props: {
        episodes: {type: [Array, Object], required: true},
    },

    data() {
        return {
            chartData: {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                }],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 5,
                            max: 10,
                            stepSize: 1,
                        }
                    }]
                }
            },
        };
    },

    created() {
        if( _.isArray(this.episodes) ) {
            this.ratingData();
        } else if( _.isObject(this.episodes) ) {
            this.groupData();
        }
    },

    mounted() {
        this.renderChart(this.chartData, this.options);
    },

    methods: {
        groupData() {
            let labels = [];
            let datasets = [];
            let color;

            _.each(this.episodes, (episodes, season) => {
                let data = [];

                _.each(episodes, episode => {
                    labels.push(episode.episodeNumber);
                    data.push(episode.rating ? episode.rating.averageRating : 0);
                });

                color = randomColor({
                    hue: 'green',
                });

                let dataset = {
                    label: `Temporada ${season}`,
                    fill: false,
                    backgroundColor: color,
                    borderColor: color,
                    data,
                };

                datasets.push(dataset);
            });

            labels = _.uniq(labels);

            this.chartData = {
                labels,
                datasets,
            };
        },

        ratingData() {
            let labels = [];
            let data = [];

            _.each(this.episodes, episode => {
                labels.push(`T${episode.seasonNumber}: ${episode.episodeNumber}`);
                data.push(episode.rating ? episode.rating.averageRating : 0);
            });

            const color = randomColor({
                hue: 'green',
            });

            this.chartData = {
                labels,
                datasets: [{
                    label: 'Rating',
                    fill: false,
                    backgroundColor: color,
                    borderColor: color,
                    data,
                }]
            };
        },
    },
}
</script>
