<template>
    <div>
        <h1>{{ text}}</h1>
        <h1>"This is number":{{ cars[0] }}</h1>
        <h1>"This is cars obj"{{ object }}</h1>
        <button ></button>
    </div>
</template>

<script>
export default{
    data(){
        return{
            count:0,
            text:"This is home page",
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