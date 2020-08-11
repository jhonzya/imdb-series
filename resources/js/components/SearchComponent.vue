<template>
    <Autocomplete
        :search="search"
        placeholder="Buscar serie"
        aria-label="Buscar serie"
        :get-result-value="getResultValue"
        :debounce-time="300"
        @submit="onSubmit" />
</template>

<script>
import Autocomplete from '@trevoreyre/autocomplete-vue';

const wikiUrl = 'https://es.wikipedia.org'

export default {
    name: "SearchComponent",
    components: {
        Autocomplete,
    },
    props: {
        api: {type: String, required: true},
    },
    methods: {
        search(q) {
            return new Promise((resolve) => {
                if (q.length < 3) {
                    return resolve([])
                }

                axios.get(this.api, {
                    params: {q},
                }).then((response) => {
                    resolve(response.data.data);
                }).catch(e => {
                    console.error(e);
                })
            })
        },

        getResultValue(result) {
            return result.primaryTitle;
        },

        onSubmit(result) {
            window.open(result.profile, '_self');
        },
    },
}
</script>
