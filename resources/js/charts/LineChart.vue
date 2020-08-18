<script>

import { Line } from 'vue-chartjs';

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

            _.each(this.episodes, (episodes, season) => {
                let data = [];

                _.each(episodes, episode => {
                    labels.push(episode.episodeNumber);
                    data.push(episode.rating ? episode.rating.averageRating : 0);
                });

                let dataset = {
                    label: `Temporada ${season}`,
                    fill: false,
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

            this.chartData = {
                labels,
                datasets: [{
                    label: 'Rating',
                    backgroundColor: 'transparent',
                    data,
                }]
            };
        },
    },
}
</script>
