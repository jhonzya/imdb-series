<template>
    <div>
        <TableWidget v-if="episodes.length > 0"
            :max-season-number="maxSeasonNumber"
            :max-episode-number="maxEpisodeNumber"
            :episodes-by-season="groupBySeason"
        />

        <ChartWidget v-if="episodes.length > 0" :episodes="episodes"/>
        <ChartWidget v-if="episodes.length > 0" :episodes="groupBySeason"/>
    </div>
</template>

<script>

import ChartWidget from "../widgets/ChartWidget";
import TableWidget from "../widgets/TableWidget";

export default {
    name: "EpisodesComponent",

    components: {
        ChartWidget,
        TableWidget,
    },

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
        episodes() {
            return _.filter(this.title.episodes, val => val.episodeNumber && val.seasonNumber);
        },

        groupBySeason() {
            return _.groupBy(this.episodes, 'seasonNumber');
        },

        groupByEpisode() {
            return _.groupBy(this.episodes, 'episodeNumber');
        },

        maxEpisodeNumber() {
            const keys = _.keys(this.groupByEpisode)
                .map(val => parseInt(val))
                .filter(val => val > 0);

            return Math.max.apply(null, keys);
        },

        maxSeasonNumber() {
            const keys = _.keys(this.groupBySeason)
                .map(val => parseInt(val))
                .filter(val => val > 0);

            return Math.max.apply(null, keys);
        },
    },

    created() {
        axios.get(this.api).then(response => {
            this.title = response.data.data;
        }).catch(e => {
            console.error(e);
        })
    },
}
</script>
