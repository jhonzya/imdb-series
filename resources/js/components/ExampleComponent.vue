<template>
    <section class="flex items-center justify-center h-screen p-8 bg-orange-100">
        <div class="container">
            <input class="w-full h-16 rounded focus:outline-none focus:shadow-outline text-xl px-8 shadow-lg"
                type="search" placeholder="Search...">
        </div>
    </section>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
