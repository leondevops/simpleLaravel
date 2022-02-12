<template>    
    <div class="body-left-container">        
        <img :src="require('../../images/hamburger.png').default"/>

        <div class="profile">
            <h1>Hi Leon</h1>
            <p>Let's make this project more fancy. </p>
        </div>

        <div class="search">
            <img :src="require('../../images/search.png').default"/>
            <input placeholder="Search your project" />            
        </div>

        <div class="project">
            <h3> Laravel Vue Project <span>2</span></h3>
            <div class="projects">                    
                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/overlay.png').default" alt="overlay image"/>
                        <span>PT</span>
                    </div>

                    <h6>Development</h6>
                </div><!-- a-project -->

                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/overlay.png').default" alt="overlay image"/>
                        <span>RA</span>
                    </div>

                    <h6>Design</h6>
                </div><!-- a-project -->

                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/overlay.png').default" alt="overlay image"/>
                        <span>TA</span>
                    </div>

                    <h6>Testing</h6>
                </div><!-- a-project -->

                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/overlay.png').default" alt="overlay image"/>
                        <span>MD</span>
                    </div>

                    <h6>Medium Draft</h6>
                </div><!-- a-project -->

                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/overlay.png').default" alt="overlay image"/>
                        <span>LP</span>
                    </div>

                    <h6>Landing page</h6>
                </div><!-- a-project -->

                <div class="a-project">
                    <div class="box-color">
                        <img :src="require('../../images/plus.png').default" alt="overlay image"/>
                        <span></span>
                    </div>

                    <h6>Add project</h6>
                </div><!-- a-project -->

            </div><!-- projects -->
        </div>
    </div><!-- body-left-container -->
</template>

<script>

export default{    
    
};
</script>

<style>

</style>