<template>
    <div :class="grid">
        <div>
            <div class="text-center mb-4">
                <div class="bg-gray-700 border border-gray-800 text-gray-700 select-none">S/T</div>
                <div class="bg-gray-700 border border-gray-800 text-white select-none" v-for="index in maxEpisodeNumber" :key="index">
                    {{ index }}
                </div>
            </div>
        </div>
        <div v-for="(season, index) in episodesBySeason" :key="index">
            <div class="text-center mb-4">
                <div class="bg-gray-700 border border-gray-800 text-white select-none">T{{ index }}</div>
                <div v-for="episode in season"
                    :key="episode.seasonNumber + episode.episodeNumber"
                    :class="getEpisodeClass(episode.rating)"
                     @click.prevent="getDetails(episode)">
                    {{ episode.rating ? episode.rating.averageRating : null }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TableWidget",

    props: {
        episodesBySeason: {type: Object, required: true},
        maxEpisodeNumber: { type: Number, required: true},
        maxSeasonNumber: { type: Number, required: true},
    },

    computed: {
        grid() {
            let sm, md, lg, max;
            sm = md = lg = max = this.maxSeasonNumber+1;

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

    methods: {
        getDetails(episode) {
            console.log(episode);
        },

        getEpisodeClass(rating) {
            const number = parseFloat(rating ? rating.averageRating : null);
            let color = 'gray';
            let opacity = 400;

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
                `hover:bg-${color}-${opacity+100}`,
                `focus:bg-${color}-${opacity+100}`,
                'border border-gray-800',
                `text-${color}-${opacity}`,
                `hover:text-gray-800`,
            ];
        },
    },
}
</script>
