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
            let color;

            _.each(this.episodes, (episodes, season) => {
                let data = [];

                _.each(episodes, episode => {
                    labels.push(episode.episodeNumber);
                    data.push(episode.rating ? episode.rating.averageRating : 0);
                });

                color = randomColor({
                    hue: 'blue',
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
            let colors = [];

            _.each(this.episodes, episode => {
                if(episode.rating) {
                    data.push(episode.rating.averageRating);
                    colors.push(this.getColor(episode.rating.averageRating));
                }

                labels.push(`T${episode.seasonNumber}: ${episode.episodeNumber}`);
            });

            this.chartData = {
                labels,
                datasets: [{
                    label: 'Rating',
                    fill: false,
                    backgroundColor: colors,
                    borderColor: 'white',
                    data,
                }]
            };
        },

        getColor(averageRating) {
            const number = parseFloat(averageRating);
            let color = 'gray';

            if(number >= 9.5) {
                color = '#63b3ed';
            } else if(number >= 8.5) {
                color = '#68d391';
            } else if(number >= 7.5) {
                color = '#f6e05e';
            } else if(number >= 6.5) {
                color = '#f6ad55';
            } else if(number >= 5.5) {
                color = '#f687b3';
            } else if(number > 0) {
                color = '#fc8181';
            }

            return color;
        },
    },
}
</script>
