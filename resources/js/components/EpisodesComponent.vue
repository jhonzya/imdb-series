<template>
    <div>
        {{ title }}
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

    created() {
        axios.get(this.api).then(response => {
            this.title = response.data.data;
        }).catch(e => {
            console.error(e);
        })
    }
}
</script>
