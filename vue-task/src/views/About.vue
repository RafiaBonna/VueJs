<template>
    <div>
        <h1>{{ text}}</h1>
        <!-- <h1>"This is a number":{{ cars[0] }}</h1> -->
    </div>
</template>

<script>
export default{
    data(){
        return{
            count:0,
            text:"This is a About Page",
            numbers:34,
            cars:[],
            object:{
                name:"BMW",
                model:"3964"
            }
        }
    }
}
</script>