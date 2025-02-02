<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DataTable shopping</title>

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css" />
    <script defer src="https://cdn.datatables.net/2.2.0/js/dataTables.min.js"></script>

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

    <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
    <header>
        <?php
        include "./pages/header.php"; ?>
    </header>

    <h1>Get Products</h1>
    <div>
        <button id="getProducts">All products</button>
        <button id="uniqueProducts">Unique products</button>
    </div>
    <div>
        Find products by combination of words (the products has all of these
        words): <input type="text" id="findProductByWords" />
        <button id="findProductByWordsButton">Find</button>
    </div>
    <div>
        Exclude products by combination of words (the products has none of these
        words): <input type="text" id="everyExcludeValue" />
        <button id="everyEexcludeButton">Exclude</button>
    </div>
    <div>
        Exclude products containing some of this words (there are no products
        containing any of these words):
        <input type="text" id="someExcludeValue" />
        <button id="someEexcludeButton">Exclude</button>
    </div>
    <div>
        Product rate greater than or equal number :
        <input type="number" id="rateFilter" />
        <button id="rateButton">Filter by rate</button>
    </div>
    <div>
        Product rate amount greater than or equal number :
        <input type="number" id="rateAmountFilter" />
        <button id="rateAmountButton">Filter by rate amount</button>
    </div>
    <table id="myTable" class="display"></table>

    <script defer type="module">
        import model from "./../server/productModel.js";
        import table from "./src/datatables.js";

        const myTable = await table(await model.read());

        $(document).ready(function () {
            $("#getProducts").on("click", async function () {
                myTable.clear().draw();
                myTable.rows.add(await model.read());
                myTable.draw();
            })

            $("#priceNavBtn").on("click", function () {
                const date = new Date();
                const todayProducts = model.list.map(e => ({ "id": e.id, name: e.name, href: e.href, "price": `${e.price} - ${date.toLocaleDateString()}` }));
                $.ajax({
                    url: "./../server/price.php",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify(todayProducts),
                })
                    .done(response => {
                        console.log(response);
                    })
                    .fail((xhr, status, error) => { console.error(status, error) })
            })

            $("#uniqueProducts").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.unique());
                myTable.draw();
            })

            $("#findProductByWordsButton").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.findProductByWords($("#findProductByWords").val()));
                myTable.draw();
            });

            $("#everyEexcludeButton").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.everyFilter($("#everyExcludeValue").val()));
                myTable.draw();
            });

            $("#someEexcludeButton").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.someFilter($("#someExcludeValue").val()));
                myTable.draw();
            });

            $("#rateButton").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.rateFilter(Number($("#rateFilter").val())));
                myTable.draw();
            });

            $("#rateAmountButton").on("click", async () => {
                myTable.clear().draw();
                myTable.rows.add(model.rateAmountFilter(Number($("#rateAmountFilter").val())));
                myTable.draw();
            });
        })
    </script>
</body>

</html>