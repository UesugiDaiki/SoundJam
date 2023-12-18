<template>
    <!-- <router-view /> -->
    <RouterView v-slot="{ Component }">
    <Suspense>
        <div>
        <component :is="Component" />
        </div>
    </Suspense>
    </RouterView>
</template>

<script setup>
    //
</script>
