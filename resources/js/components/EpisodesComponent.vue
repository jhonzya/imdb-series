<template>
    <div>
        <div :class="grid">
            <div v-for="(season, index) in groupBySeason" :key="index">
                <div class="text-center">
                    <div>T{{ index }}</div>
                    <div v-for="episode in season" :title="episode.rating ? episode.rating.averageRating : null"
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

            const max = Math.max.apply(null, keys);

            return ['grid grid-flow-col', `grid-cols-${max}`];
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
            let color = 'gray-300';
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
