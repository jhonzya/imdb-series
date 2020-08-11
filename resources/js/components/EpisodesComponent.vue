<template>
    <div>
        <div class="grid grid-flow-col grid-cols-5 gap-4">
            <div v-for="(season, index) in groupBySeason" :key="index">
                <div class="text-center">
                    <div v-for="episode in season"
                         :key="episode.seasonNumber + episode.episodeNumber"
                         class="bg-gray-400 my-2">
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
    },

    created() {
        axios.get(this.api).then(response => {
            this.title = response.data.data;
        }).catch(e => {
            console.error(e);
        })
    }
}
</script>
