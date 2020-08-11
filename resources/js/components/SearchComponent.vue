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
            search(input) {
                const url = `${this.api}?q=${encodeURI(input)}`

                return new Promise((resolve) => {
                    if (input.length < 3) {
                        return resolve([])
                    }

                    fetch(url)
                        .then((response) => response.json())
                        .then((data) => {
                            resolve(data.data)
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
