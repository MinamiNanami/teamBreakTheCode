document.addEventListener("DOMContentLoaded", function() {
    const salesContainer = document.getElementById("sales-chart-container");

    function loadSalesData() {
        fetch('/admin/sales-data')
        .then(res => res.json())
        .then(data => {
            salesContainer.innerHTML = `
                <h3>Total Sales: ₱${data.total_sales}</h3>
                <h3>Orders Processed: ${data.orders}</h3>
                <h3>Average Order Value: ₱${data.avg_order}</h3>
                <h3>Top Selling Item: ${data.top_item}</h3>
            `;
        });
    }

    loadSalesData();
    const refreshBtn = document.getElementById("refresh-sales-btn");
    if(refreshBtn) refreshBtn.addEventListener("click", loadSalesData);
});
