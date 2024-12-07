<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Powetech Cement Distribution - Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #000035;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .company-name {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .main-content {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            flex: 1;
        }

        .filters {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .filter-group label {
            font-weight: 500;
            color: #4b5563;
        }

        input[type="date"],
        input[type="month"] {
            padding: 0.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 0.875rem;
        }

        .view-btn {
            background-color: #1e40af;
            color: white;
            border: none;
            padding: 0.625rem 1.25rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .view-btn:hover {
            background-color: #1e3a8a;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #4b5563;
        }

        tr:hover {
            background-color: #f8fafc;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .empty-state-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #9ca3af;
        }

        .loading-state {
            text-align: center;
            padding: 2rem;
            color: #6b7280;
            display: none;
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #1e40af;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
            display: none;
        }

        .footer {
            background-color: #2b2b2b;
            color: #FFFFFF;
            padding: 1rem 2rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .filters {
                padding: 1rem;
            }

            .filter-group {
                width: 100%;
            }

            .view-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="company-name">Powetech Cement Distribution</div>
    </header>

    <main class="main-content">
        <div class="filters">
            <div class="filter-group">
                <label for="date-filter">Date</label>
                <input type="date" id="date-filter">
            </div>
            <div class="filter-group">
                <label for="month-filter">Month</label>
                <input type="month" id="month-filter">
            </div>
            <button class="view-btn" onclick="fetchSalesData()">View Sales</button>
        </div>

        <div class="error-message" id="error-message"></div>

        <div class="table-container">
            <div class="loading-state" id="loading-state">
                <div class="loading-spinner"></div>
                <p>Loading sales data...</p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Sales Rep Name</th>
                        <th>Shop Name</th>
                        <th>Customer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Date of Update</th>
                    </tr>
                </thead>
                <tbody id="sales-table-body">
                    <!-- Data will be populated here -->
                </tbody>
            </table>

            <div class="empty-state" id="empty-state">
                <div class="empty-state-icon">📊</div>
                <h3>No Sales Data Available</h3>
                <p>Use the filters above to load sales data</p>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2024 Powetech Cement Distribution. All rights reserved.</p>
    </footer>

    <script>
        // Function to show loading state
        function showLoading() {
            document.getElementById('loading-state').style.display = 'block';
            document.getElementById('empty-state').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';
            document.getElementById('sales-table-body').innerHTML = '';
        }

        // Function to hide loading state
        function hideLoading() {
            document.getElementById('loading-state').style.display = 'none';
        }

        // Function to show error message
        function showError(message) {
            const errorElement = document.getElementById('error-message');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
            document.getElementById('empty-state').style.display = 'block';
        }

        // Function to format currency
        function formatCurrency(amount) {
            return new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(amount);
        }

        // Function to populate table with data
        function populateTable(data) {
            const tableBody = document.getElementById('sales-table-body');
            const emptyState = document.getElementById('empty-state');
            
            if (data.length === 0) {
                emptyState.style.display = 'block';
                return;
            }

            emptyState.style.display = 'none';
            tableBody.innerHTML = '';

            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.sales_rep_name}</td>
                    <td>${row.shop_name}</td>
                    <td>${row.customer_name}</td>
                    <td>${row.item_sold}</td>
                    <td>${row.quantity}</td>
                    <td>${formatCurrency(row.unit_price)}</td>
                    <td>${formatCurrency(row.total_price)}</td>
                    <td>${new Date(row.date_updated).toLocaleDateString()}</td>
                `;
                tableBody.appendChild(tr);
            });
        }

        // Function to fetch sales data from the server
        async function fetchSalesData() {
            const dateFilter = document.getElementById('date-filter').value;
            const monthFilter = document.getElementById('month-filter').value;

            showLoading();

            try {
                // This is where you'll make the actual API call to your backend
                // Example API endpoint structure:
                // const response = await fetch(`/api/sales?date=${dateFilter}&month=${monthFilter}`);
                // const data = await response.json();
                
                // For now, simulate an API call
                await new Promise(resolve => setTimeout(resolve, 1000));
                const data = [];  // Empty data until database is connected
                
                populateTable(data);
            } catch (error) {
                showError('Error loading sales data. Please try again later.');
                console.error('Error:', error);
            } finally {
                hideLoading();
            }
        }

        // Initialize the dashboard
        document.addEventListener('DOMContentLoaded', () => {
            // Show empty state initially
            document.getElementById('empty-state').style.display = 'block';
        });
    </script>
</body>
</html>