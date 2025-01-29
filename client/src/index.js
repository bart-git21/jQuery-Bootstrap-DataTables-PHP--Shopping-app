import model from "./model.js";
import table from "./datatables.js";

const myTable = await table(await model.read());

const getProducts = document.querySelector("#getProducts");
getProducts.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(await model.read());
    myTable.draw();
})

const uniqueProducts = document.querySelector("#uniqueProducts");
uniqueProducts.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.unique());
    myTable.draw();
})

const findProductByWordsButton = document.querySelector("#findProductByWordsButton");
const findProductByWords = document.querySelector("#findProductByWords");
findProductByWordsButton.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.findProductByWords(findProductByWords.value));
    myTable.draw();
});

const everyFilterBtn = document.querySelector("#everyEexcludeButton");
const everyFilterValue = document.querySelector("#everyExcludeValue");
everyFilterBtn.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.everyFilter(everyFilterValue.value));
    myTable.draw();
});

const someFilterBtn = document.querySelector("#someEexcludeButton");
const someFilterValue = document.querySelector("#someExcludeValue");
someFilterBtn.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.someFilter(someFilterValue.value));
    myTable.draw();
});

const rateFilter = document.querySelector("#rateFilter");
const rateButton = document.querySelector("#rateButton");
rateButton.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.rateFilter(+rateFilter.value));
    myTable.draw();
});

const rateAmountFilter = document.querySelector("#rateAmountFilter");
const rateAmountButton = document.querySelector("#rateAmountButton");
rateAmountButton.addEventListener("click", async () => {
    myTable.clear().draw();
    myTable.rows.add(model.rateAmountFilter(+rateAmountFilter.value));
    myTable.draw();
});
