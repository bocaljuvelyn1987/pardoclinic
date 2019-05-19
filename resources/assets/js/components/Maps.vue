<template>
    <GmapMap
  :center="{lat:10.2785, lng:123.8543}"
  :zoom="17"
  map-type-id="terrain"
  style="width: 100%; height: 100vh"
>
  <GmapMarker
    :key="index"
    v-for="(m, index) in markers"
    :position="m.position"
    :clickable="true"
    :draggable="true"
    @click="center=m.position"
  />
</GmapMap>
</template>