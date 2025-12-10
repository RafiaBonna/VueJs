<template>
    <div>
        <h1>{{ text}}</h1>
        <!-- <h1>"This is a number":{{ cars[0] }}</h1> -->
    </div>
    h2
</template>

<script>
export default{
    data(){
        return{
            count:0,
            text:"This is a home page",
            numbers:34,
            cars:[2,4,7,9],
            object:{
                name:"BMW",
                model:"3964"
            }
        }
    }
}
</script>