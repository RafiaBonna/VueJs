<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-success">Distributor Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><router-link to="/">Login</router-link></li>
                        <li class="breadcrumb-item active">Distributor Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content"> 
            <div class="row">
                <div class="col-lg-3 col-sm-6" v-for="(card, i) in statCards" :key="i">
                    <div class="small-box" :class="card.color"> 
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

            <div class="card mt-3">
                <div class="card-body">
                    <p class="lead">Welcome, Distributor User! Here is your summary.</p>
                </div>
            </div>

        </section>
    </div>
</template>

<script>
export default {
    name: "DistributorDashboard",

    data() {
        return {
            statCards: [
                { title: "Total Retailers", value: 120, color: "bg-info" },
                { title: "Daily Orders", value: 35, color: "bg-success" },
                { title: "Pending Deliveries", value: 12, color: "bg-info" },
                { title: "Completed Deliveries", value: 98, color: "bg-success" },
            ],
        };
    },
};
</script>
