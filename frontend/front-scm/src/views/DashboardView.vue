<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/home">Home</router-link></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
        
        <section class="content"> 
            
            <div class="row">
                <div class="col-lg-3 col-sm-6" v-for="(card, i) in statCards" :key="i">
                    <div class="small-box bg-info"> 
                        <div class="inner">
                            <h3>{{ card.value }}</h3>
                            <p>{{ card.title }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i> 
                        </div>
                        <a href="#" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sales Overview</h4>
                        </div>
                        <div class="card-body">
                             <div style="height:250px; background:#fff; border:1px solid #ddd; padding:20px;">
                                Chart Placeholder
                            </div>
                        </div>
                    </div>
                </div>
                 </div>
        </section>
        
    </div>
</template>

<script>
export default {
    data() {
        return {
            avatar: "./assets/images/avatar/1.png",

            // Stat Cards data
            statCards: [
                // AdminLTE-e color class alada: bg-info, bg-success, bg-warning, bg-danger
                { title: "Today Expenses", value: 8500, color: "bg-success", width: "85%" },
                { title: "Income Detail", value: 7800, color: "bg-primary", width: "75%" },
                { title: "Task Completed", value: 500, color: "bg-warning", width: "50%" },
                { title: "Task Completed", value: 650, color: "bg-danger", width: "65%" },
            ],

            // Baki data jemon projects, orders, etc. jemon chilo temni thakbe
            projects: [ /* ... */ ],
            orders: [ /* ... */ ],
        };
    },
};
</script>