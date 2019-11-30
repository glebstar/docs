<template>
    <div>
        <div class="container">
            <h1>Docs</h1>

            <p>
                <router-link :to="{ name: 'home' }">Home</router-link> |
                <router-link :to="{ name: 'documents.create' }">Add Document</router-link>
            </p>

            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {}
</script>
