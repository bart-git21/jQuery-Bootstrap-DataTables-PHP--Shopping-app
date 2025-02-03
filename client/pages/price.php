<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Price trend</title>

    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <header>
        <?php include "header.php"; ?>
    </header>

    <h1>Price trend</h1>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr);" id="output"></div>

    <script type="module">
        function displayProductChart(product) {
            const productView = `
                <a href="${product.href}">${product.id} - ${product.name}</a>
                <canvas id="myChart"></canvas>
            `
            const productPriceList = product.price.map(p => p.split(" - ")[0]);
            const div = document.createElement("div");
            div.setAttribute("style", "width: 500px;");
            div.insertAdjacentHTML("beforeend", productView);
            output.insertAdjacentElement("beforeend", div);
            const ctx = div.querySelector('#myChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: product.price.map(p => p.split(" - ")[1]),
                    datasets: [{
                        data: productPriceList,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        }
                    },
                    scales: {
                        y: {
                            min: productPriceList.at(-1) * 0.8,
                            max: productPriceList.at(-1) * 1.2
                        }
                    }
                }
            });
        }
        let discount = [];
        const output = document.getElementById('output');
        $(document).ready(function () {
            $.ajax({
                url: "./../../server/db/discount.json",
                method: "GET",
                contentType: "application/json",
            })
                .done(response => {
                    discount = response;
                    discount.forEach(e => displayProductChart(e))
                })
                .fail((xhr, status, error) => { console.log(error) })
        })
    </script>
</body>

</html>