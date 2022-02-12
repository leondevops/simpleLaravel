<template>    
    <div class="body-container">        
        <BodyLeft />
        <BodyRight />
    </div>
</template>

<script>

import BodyLeft from "./BodyLeft.vue";
import BodyRight from "./BodyRight.vue";

export default{
    name:"body-component",
    components:{
        BodyLeft,
        BodyRight,
    },
};
</script>

<style>

</style>
