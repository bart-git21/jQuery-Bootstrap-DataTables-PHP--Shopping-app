const filesNames = [1, 2];
// const filesNames = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
async function getHtml(fileName) {
  const response = await fetch(`./../server/db/html/${fileName}.txt`);
  return await response.text();
}
async function getSingleFileData(fileName) {
  let splitedProducts = [];

  const data = await getHtml(fileName);
  const products = data.split("data-index");
  products.forEach((e) => {
    e = e.replaceAll("> <", "><");
    const elem = e.split("><");

    if (elem.length > 3) {
      const href = elem
        .find((e) => e.includes("href"))
        .split(" ")[1]
        .split("/product")[1];
      let id = href.replace(/(\/\?.{1,})/g, "");
      id = id.replace(/(.{1,}-)/g, "");
      const img = elem
        .find((e) => e.includes(".jpg"))
        .split(" ")
        .filter((e) => e.includes("src="))[0];
      let priceExample = elem.find((e) => e.includes("₽")) || 0;
      priceExample &&
        (priceExample = priceExample
          .split(">")[1]
          .replace(/[(₽</span)\s]/g, ""));
      const name = elem
        .find((e) => e.includes("tsBody500Medium"))
        .split('">')[1]
        .replace("</span", "");
      let rate = elem.find((e) => e.search(/>\d{1}\.\d{1}  /g) != -1) || 0;
      rate && (rate = parseFloat(rate.split(">")[1]));
      let rateAmount = elem.find((e) => /\d{1,}&nbsp;о/g.test(e)) || 0;
      rateAmount &&
        (rateAmount = rateAmount.split(">")[1].replaceAll(/\D/g, ""));

      const numbersGr = name.replaceAll(/ {1,}/g, "").match(/(\d+(г){1,2})/g);
      const numbersKg = name.replaceAll(/ {1,}/g, "").match(/(\d+(кг){1,2})/g);
      let pricePerKg = [["", 99999]];
      if (numbersGr || numbersKg) {
        pricePerKg = numbersGr
          ? numbersGr.map((e) => [e, (priceExample / parseInt(e)) * 1000])
          : numbersKg.map((e) => [e, priceExample / parseInt(e)]);
      }
      const numbersMl = name.replaceAll(/ {1,}/g, "").match(/(\d+(мл){1,2})/g);
      const numbersLitr = name.replaceAll(/ {1,}/g, "").match(/(\d+(л){1,2})/g);
      let pricePerLitr = [["", ""]];
      if (numbersMl || numbersLitr) {
        pricePerLitr = numbersMl
          ? numbersMl.map((e) => [e, (priceExample / parseInt(e)) * 1000])
          : numbersLitr.map((e) => [e, priceExample / parseInt(e)]);
      }

      const prodParam = {
        id,
        feedbacks: +rateAmount,
        href,
        name,
        price: +priceExample,
        rate: parseFloat(rate),
        tableData: [
          +rateAmount,
          `<a href='https://www.example.com/product${href}' target="_blank" rel="noopener noreferrer"><img class='link' ${img} alt='${name}'></a>`,
          `<a href='https://www.example.com/product${href}' target="_blank" rel="noopener noreferrer">${name}</a>`,
          id,
          +priceExample,
          `
                <table>
                    <tr>
                        <td>${parseInt(pricePerKg[0][1])} р/кг</td>
                        <td>${pricePerKg[0][0]}</td>
                    </tr>
                    <tr ${!pricePerLitr[0][1] && "hidden"}>
                        <td>${parseInt(pricePerLitr[0][1])} р/л</td>
                        <td>${pricePerLitr[0][0]}</td>
                    </tr>
                </table>
            `,
          parseFloat(rate),
        ],
      };

      priceExample && splitedProducts.push(prodParam);
    }
  });
  return splitedProducts;
}

async function getData() {
  let products = [];
  const promises = filesNames.map(async (e) => {
    const data = await getSingleFileData(e);
    products.push(...data);
  });
  await Promise.all(promises);
  return products;
}

class Products {
  constructor(list) {
    this.list = [...list] || [];
    this.tableData = list.map((e) => e.tableData) || [];
  }
  async create() {
    this.list = await getData();
    this.tableData = this.list.map((e) => e.tableData);
  }
  async read() {
    if (!this.list.length) await this.create();
    return this.tableData;
  }
  findProductByWords(inputValue) {
    const words = inputValue.toLowerCase().split(" ");
    const filteredList = this.list.filter((e) =>
      words.every((word) => e.name.toLowerCase().includes(word))
    );
    this.tableData  = filteredList.map(e => e.tableData);
    return this.tableData;
  }
  everyFilter(condition) {
    const words = condition.toLowerCase().split(" ");
    const filteredList = this.list.filter((e) => {
      const name = e.name.toLowerCase();
      const isAllIncludes = words.every((word) => name.includes(word));
      return !isAllIncludes;
    });
    this.tableData = filteredList.map(e => e.tableData);
    return this.tableData;
  }
  someFilter(condition) {
    const words = condition.toLowerCase().split(" ");
    const filteredList = this.list.filter((e) => {
      const name = e.name.toLowerCase();
      const isIncludesAtListOneWord = words.some((word) => name.includes(word));
      return !isIncludesAtListOneWord;
    });
    this.tableData = filteredList.map(e => e.tableData);
    return this.tableData;
  }
  unique() {
    const uniqueRate = new Set(this.list.map((e) => e.feedbacks));
    const filteredList = [...uniqueRate].map((rate) =>
      this.list.find((product) => product.feedbacks === rate)
    );
    this.tableData = filteredList.map(e => e.tableData);
    return this.tableData;
  }
  rateFilter(num) {
    const filteredList = this.list.filter((e) => e.rate >= num);
    this.tableData = filteredList.map(e => e.tableData);
    return this.tableData;
  }
  rateAmountFilter(num) {
    const filteredList = this.list.filter((e) => e.feedbacks >= num);
    this.tableData = filteredList.map(e => e.tableData);
    return this.tableData;
  }
}
const model = new Products(await getData());

export default model;
