<template>
    <div>
        <div :class="grid">
            <div v-for="(season, index) in groupBySeason" :key="index">
                <div class="text-center mb-4">
                    <div class="bg-gray-700 border border-white text-white select-none">T{{ index }}</div>
                    <div v-for="episode in season"
                         :key="episode.seasonNumber + episode.episodeNumber"
                         :class="getEpisodeClass(episode.rating)">
                        {{ episode.episodeNumber }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EpisodesComponent",

    props: {
        api: {type: String, required: true},
    },

    data() {
        return {
            title: {
                primaryTitle: '',
                episodes: [],
            },
        };
    },

    computed: {
        groupBySeason() {
            return _.groupBy(this.title.episodes, 'seasonNumber');
        },

        grid() {
            const keys = _.keys(this.groupBySeason)
                .map(val => parseInt(val))
                .filter(val => val > 0);

            let sm, md, lg, max;
            sm = md = lg = max = Math.max.apply(null, keys);

            if(max > 12) {
                sm = 12;
            }

            if(max > 16) {
                md = 16;
            }

            if(max > 24) {
                lg = 24;
            }

            if(max > 32) {
                max = 32;
            }

            return [
                'grid',
                `grid-cols-${sm}`,
                `md:grid-cols-${md}`,
                `lg:grid-cols-${lg}`,
                `xl:grid-cols-${max}`,
            ];
        },
    },

    created() {
        axios.get(this.api).then(response => {
            this.title = response.data.data;
        }).catch(e => {
            console.error(e);
        })
    },

    methods: {
        getEpisodeClass(rating) {
            const number = parseFloat(rating ? rating.averageRating : null);
            let color = 'gray';
            let opacity = 300;

            if(number >= 10) {
                color = 'blue';
            } else if(number >= 9) {
                color = 'green';
            } else if(number >= 8) {
                color = 'yellow';
            } else if(number >= 7) {
                color = 'orange';
            } else if(number >= 6) {
                color = 'pink';
            } else if(number > 0) {
                color = 'red';
                opacity = 400;
            }

            return [
                'select-none',
                'cursor-pointer',
                `bg-${color}-${opacity}`,
                `hover:bg-${color}-${opacity+200}`,
                'border border-white rounded',
            ];
        },
    },
}
</script>
