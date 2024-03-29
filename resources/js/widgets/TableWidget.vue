<template>
    <div>
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
                        {{ episode.rating ? episode.rating.averageRating : nullRating }}
                    </div>
                </div>
            </div>
        </div>

        <!-- modal -->
        <div v-if="modal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div class="fixed inset-0 transition-opacity" @click="modal = false">
                    <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
                </div>

                <div class="inline-block border-white border-2 transform transition-all sm:max-w-lg w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="bg-gray-800 px-4 pb-5 pt-3">
                        <p class="text-right cursor-pointer" @click="modal = false">x</p>
                        <h3 class="text-lg leading-6 font-medium text-white text-left">
                            {{ episode.detail.primaryTitle }}
                        </h3>
                        <div class="mt-0 mb-4 text-gray-500 text-sm">
                            <a :href="episode.detail.link" class="underline select-none" target="_blank">Show on IMDb</a>
                        </div>
                        <div class="text-gray-500 text-sm leading-5 text-center">
                            <p :class="getEpisodeClass(episode.rating, false)">
                                {{ episode.rating ? episode.rating.averageRating : nullRating }}
                            </p>
                            <p>
                                Season {{ episode.seasonNumber }} | Episode {{ episode.episodeNumber }}
                            </p>
                        </div>
                    </div>
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

    data() {
        return {
            episode: {
                extra: {},
            },
            modal: false,
            nullRating: 'n/a',
        };
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
            this.episode = episode;
            this.modal = false;

            axios.get(`/api/episode/${episode.titleId}/show`).then(response => {
                this.episode.detail = response.data.data;
                this.modal = true;
            }).catch(e => {
                console.error(e);
            })
        },

        getEpisodeClass(rating, pointer = true) {
            const number = parseFloat(rating ? rating.averageRating : null);
            let color = 'gray';

            if(number >= 9.5) {
                color = 'blue';
            } else if(number >= 8.5) {
                color = 'green';
            } else if(number >= 7.5) {
                color = 'yellow';
            } else if(number >= 6.5) {
                color = 'orange';
            } else if(number >= 5.5) {
                color = 'pink';
            } else if(number > 0) {
                color = 'red';
            }

            let classes = [
                'select-none',
                `bg-${color}-400`,
                'border border-gray-800',
            ];

            if(pointer) {
                classes = classes.concat([
                    `hover:bg-${color}-500`,
                    `focus:bg-${color}-500`,
                    `text-gray-800`,
                    `hover:text-gray-800`,
                    'cursor-pointer',
                ]);
            } else {
                classes = classes.concat([
                    `text-gray-800`,
                ]);
            }

            return classes;
        },
    },
}
</script>
