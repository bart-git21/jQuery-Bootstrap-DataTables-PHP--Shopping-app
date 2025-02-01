export default async function(data) {
  const table = new DataTable("#myTable", {
    data: data,
    columns: [
      { title: "Rate Amount" },
      { title: "Product" },
      { title: "Name" },
      { title: "ID" },
      { title: "Price" },
      { title: "Price per kg or etc." },
      { title: "rate" },
    ],
    paging: true, // Enable pagination
    ordering: true, // Enable column ordering
    info: true, // Show table information
    lengthChange: true, // Allow changing the number of records per page
    pageLength: 25, // Set default number of records per page
    responsive: true, 
  });
  return table;
}
