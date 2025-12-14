<template>
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-info">Depo Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link to="/">Login</router-link>
                        </li>
                        <li class="breadcrumb-item active">Depo Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="lead">Welcome, Depo User! This is your Depo dashboard.</p>
                </div>
            </div>

            <!-- Example Depo Content -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h5>Total Stock</h5>
                            <p class="mb-0">1250 Items</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5>Pending Orders</h5>
                            <p class="mb-0">38 Orders</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5>Today's Dispatch</h5>
                            <p class="mb-0">14 Trucks</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </div>
</template>

<script>
export default {
    name: "DepoDashboard",
};
</script>
