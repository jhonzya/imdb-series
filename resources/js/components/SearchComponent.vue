<template>
    <div class="w-full">
        <Autocomplete
            :search="search"
            :placeholder="placeholder"
            :aria-label="placeholder"
            :debounce-time="300"
            @submit="onSubmit">
            <template
                #default="{
                rootProps,
                inputProps,
                inputListeners,
                resultListProps,
                resultListListeners,
                results,
                resultProps
              }"
            >
                <div v-bind="rootProps">
                    <input
                        v-model="value"
                        v-bind="inputProps"
                        v-on="inputListeners"
                        @focus="handleFocus"
                        @blur="handleBlur"
                    >
                    <ul
                        v-if="value && results.length === 0"
                        class="autocomplete-result-list"
                        style="position: absolute; z-index: 1; width: 100%; top: 100%;"
                    >
                        <li class="autocomplete-result">
                            No results found
                        </li>
                    </ul>
                    <ul v-bind="resultListProps" v-on="resultListListeners">
                        <li
                            v-for="(result, index) in results"
                            :key="resultProps[index].id"
                            v-bind="resultProps[index]"
                        >
                            {{ result.primaryTitle }}
                        </li>
                    </ul>
                </div>

            </template>
        </Autocomplete>
    </div>
</template>

<script>
import Autocomplete from '@trevoreyre/autocomplete-vue';

export default {
    name: "SearchComponent",
    components: {
        Autocomplete,
    },
    props: {
        api: {type: String, required: true},
    },
    data() {
        return {
            focus: false,
            placeholder: 'Buscar serie',
            value: '',
        };
    },
    methods: {
        search(q) {
            this.value = q;

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

        onSubmit(result) {
            window.open(result.profile, '_self');
        },

        handleFocus() {
            this.focus = true;
        },

        handleBlur() {
            this.focus = false;
        },
    },
}
</script>
