<script>
    import { Line } from 'vue-chartjs';

    export default {
        extends: Line,

        mounted() {
            let url = window.location.href.split('/').pop();

            if (url.indexOf('?') === -1)
                url = process.env.MIX_APP_URL + '/api/' + url + '/graf';
            else
                url = process.env.MIX_APP_URL + '/api/' + url.substr(0, url.indexOf('?')) + '/graf';

            axios.get(url).then((response) => {
                let data = response.data;
                let Dates = [];
                let Additions = [];

                if (data['entries']) {
                    data['entries'].forEach(element => {
                        Dates.push(moment(element.date, "YYYY-MM-DD"));
                        Additions.push(element.additions);
                    });

                    this.renderChart({
                        labels: Dates,
                        datasets: [{
                            label: data['label'],
                            backgroundColor: 'rgba(52, 58, 64, 0.5)',
                            pointBackgroundColor: '#343a40',
                            data: Additions,
                        }]
                    }, {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            xAxes: [{
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            }],
                            yAxes: [{ ticks: { beginAtZero:true } }]
                        },
                    });
                } else {
                    console.log('No data');
                }
            });
        }
    }
</script>
