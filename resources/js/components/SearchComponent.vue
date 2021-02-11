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
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none z-10">
                            <loader-icon v-if="searching" class="text-gray-500 inline-block"></loader-icon>
                            <search-icon v-else class="text-gray-500 inline-block"></search-icon>
                        </div>
                        <input
                            v-model="value"
                            v-bind="inputProps"
                            v-on="inputListeners"
                            @focus="handleFocus"
                            @blur="handleBlur"
                        >
                    </div>
                    <ul
                        v-if="value.length >= min && results.length === 0 && !searching"
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
                            class="leading-none"
                        >
                            {{ result.primaryTitle }}
                            <div class="text-sm text-gray-500">
                                {{ result.startYear }} / {{ result.type }}
                            </div>
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
    data() {
        return {
            api: '/api/title/search',
            focus: false,
            placeholder: 'Search serie',
            value: '',
            searching: false,
            min: 3,
        };
    },
    methods: {
        search(q) {
            this.value = q;

            return new Promise((resolve) => {
                if (q.length < this.min) {
                    return resolve([])
                }

                this.searching = true;

                axios.get(this.api, {
                    params: {q},
                }).then((response) => {
                    this.searching = false;
                    resolve(response.data.data);
                }).catch(e => {
                    console.error(e);
                })
            })
        },

        onSubmit(result) {
            this.searching = true;
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
