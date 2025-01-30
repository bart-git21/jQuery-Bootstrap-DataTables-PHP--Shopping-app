<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DataTable shopping</title>

    <script type="module" src="src/index.js"></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
      integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8="
      crossorigin="anonymous"
    ></script>
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.min.css"
    />
    <script
      defer
      src="https://cdn.datatables.net/2.2.0/js/dataTables.min.js"
    ></script>

    <link rel="stylesheet" href="./assets/css/style.css" />
  </head>
  <body>
    <header class="d-flex">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Navbar</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                  </li>
                </ul>
                <form class="d-flex" role="search">
                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
              </div>
            </div>
          </nav>
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
  </body>
</html>
