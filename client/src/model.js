const filesNames = [1, 2];
// const filesNames = [1,2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
async function getSingleFileData(url) {
  const response = await fetch(`./db/html/${url}.txt`);
  const data = await response.text();
  const products = data.split("data-index");
  let splitedProducts = [];
  products.forEach((e) => {
    e = e.replaceAll("> <", "><");
    const elem = e.split("><");

    if (elem.length > 3) {
      const href = elem.find(e => e.includes("href")).split(" ")[1].split("/product")[1];
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

      const productParameters = [
        +rateAmount,
        `<a href='https://www.example.com/product${href}' target="_blank" rel="noopener noreferrer"><img class='link' ${img} alt='${name}'></a>`,
        `<a href='https://www.example.com/product${href}' target="_blank" rel="noopener noreferrer">${name}</a>`,
        id,
        +priceExample,
        parseFloat(rate),
        name,
      ];

      splitedProducts.push(productParameters);
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
    this.list = list || [];
  }
  async create() {
    this.list = await getData();
  }
  async read() {
    if (!this.list.length) await this.create();
    return this.list;
  }
  everyFilter(condition) {
    const words = condition.toLowerCase().split(" ");
    return this.list.filter((e) => {
      const name = e[2].toLowerCase();
      const isAllIncludes = words.every((word) => name.includes(word));
      return !isAllIncludes;
    });
  }
  someFilter(condition) {
    const words = condition.toLowerCase().split(" ");
    return this.list.filter((e) => {
      const name = e[6].toLowerCase();
      const isIncludesAtListOneWord = words.some((word) => name.includes(word));
      return !isIncludesAtListOneWord;
    });
  }
  unique() {
    const uniqueRate = new Set(this.list.map((e) => e[0]));
    return [...uniqueRate].map((rate) =>
      this.list.find((product) => product[0] === rate)
    );
  }
  rateFilter(num) {
    return this.list.filter((e) => e[5] >= num);
  }
  rateAmountFilter(num) {
    return this.list.filter((e) => e[0] >= num);
  }
}
const model = new Products(await getData());

export default model;
