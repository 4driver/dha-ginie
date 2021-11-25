<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dashboard</h3>
                        </div>
                        <div class="card-body">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus reiciendis totam labore corrupti facere numquam deserunt unde voluptas at a veritatis quis natus nihil optio, omnis minima eos sequi illum?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>
</template>

<script>
export default {
    mounted() {
        /*
         * BAR CHART
         * ---------
         */

        var bar_data = {
            data: [
                [1, 10],
                [2, 8],
                [3, 4],
                [4, 13],
                [5, 17],
                [6, 9]
            ],
            bars: { show: true }
        };
        $.plot("#bar-chart", [bar_data], {
            grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: "center"
                }
            },
            colors: ["#3c8dbc"],
            xaxis: {
                ticks: [
                    [1, "January"],
                    [2, "February"],
                    [3, "March"],
                    [4, "April"],
                    [5, "May"],
                    [6, "June"]
                ]
            }
        });
        /* END BAR CHART */
        console.log("Component mounted.");
    }
};
</script>
