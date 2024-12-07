<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerTech - Sales Dashboard</title>
    <!-- Include html2pdf library for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #F5F5F5;
            color: #333333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #000035;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: #FFFFFF;
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        .nav-links a {
            color: #FFFFFF;
            text-decoration: none;
            margin-left: 2rem;
            font-size: 1.1rem;
        }

        .logout-btn {
            background-color: #FFC107;
            color: #003366;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            margin-left: 2rem;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            flex: 1;
        }

        .dashboard-header {
            background-color: #FFFFFF;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .dashboard-header h1 {
            color: #003366;
            margin-bottom: 0.5rem;
        }

        .form-container {
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333333;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #003366;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .calculation-section {
            background-color: #F5F5F5;
            padding: 1.5rem;
            border-radius: 5px;
            margin-top: 1.5rem;
        }

        .calculation-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .button-group {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .submit-btn, .print-btn {
            background-color: #003366;
            color: #FFFFFF;
            padding: 1rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .print-btn {
            background-color: #FFC107;
            color: #003366;
        }

        .submit-btn:hover {
            background-color: #002244;
        }

        .print-btn:hover {
            background-color: #e6ac00;
        }

        footer {
            background-color: #2b2b2b;
            color: #FFFFFF;
            text-align: center;
            padding: 1rem;
            margin-top: auto;
        }

        #bill-template {
            display: none;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .calculation-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="logo">PowerTech</a>
        <div class="nav-links">
            <a href="#">Dashboard</a>
            <a href="home.html" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Sales Representative Dashboard</h1>
            <p>Update inventory and manage orders</p>
        </div>

        <form class="form-container" id="inventory-form">
            <div class="form-grid">
                <div class="form-group">
                    <label for="shop-name">Shop Name</label>
                    <input type="text" id="shop-name" required>
                </div>

                <div class="form-group">
                    <label for="customer-name">Customer Name</label>
                    <input type="text" id="customer-name" required>
                </div>

                <div class="form-group full-width">
                    <label for="shop-address">Shop Address</label>
                    <input type="text" id="shop-address" required>
                </div>

                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" required>
                </div>

               

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" min="1" required>
                </div>

                <div class="form-group">
                    <label for="unit-price">Unit Price</label>
                    <input type="number" id="unit-price" step="0.01" required>
                </div>

                <div class="calculation-section full-width">
                    <div class="calculation-grid">
                        <div class="form-group">
                            <label for="discount">Discount (%)</label>
                            <input type="number" id="discount" min="0" max="100" value="0" step="0.1">
                        </div>

                        <div class="form-group">
                            <label for="vat">VAT (%)</label>
                            <input type="number" id="vat" min="0" max="100" step="0.1">
                        </div>

                        <div class="form-group">
                            <label for="total-price">Total Price</label>
                            <input type="number" id="total-price" readonly class="readonly-input">
                        </div>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="submit-btn">Update Inventory</button>
                <button type="button" class="print-btn" onclick="generatePDF()">Print Bill</button>
            </div>
        </form>

        <!-- Hidden template for PDF generation -->
        <div id="bill-template">
            <div style="padding: 20px;">
                <h2 style="color: #003366; margin-bottom: 20px;">PowerTech - Invoice</h2>
                <div style="margin-bottom: 20px;">
                    <p><strong>Shop Name:</strong> <span id="pdf-shop-name"></span></p>
                    <p><strong>Customer Name:</strong> <span id="pdf-customer-name"></span></p>
                    <p><strong>Address:</strong> <span id="pdf-address"></span></p>
                    <p><strong>Date:</strong> <span id="pdf-date"></span></p>
                </div>
                <div style="margin-bottom: 20px;">
                    <p><strong>Item:</strong> <span id="pdf-item"></span></p>
                    <p><strong>Quantity:</strong> <span id="pdf-quantity"></span></p>
                    <p><strong>Unit Price:</strong> <span id="pdf-unit-price"></span></p>
                    <p><strong>Discount:</strong> <span id="pdf-discount"></span>%</p>
                    <p><strong>VAT:</strong> <span id="pdf-vat"></span>%</p>
                    <p><strong>Total Price:</strong> <span id="pdf-total"></span></p>
                </div>
            </div>
        </div>
    </div>

    <div id="bill-template" style="display: none;">
        <h2 style="text-align: center; color: #003366;">PowerTech Invoice</h2>
        <p><strong>Shop Name:</strong> <span id="pdf-shop-name"></span></p>
        <p><strong>Customer Name:</strong> <span id="pdf-customer-name"></span></p>
        <p><strong>Shop Address:</strong> <span id="pdf-address"></span></p>
        <p><strong>Date:</strong> <span id="pdf-date"></span></p>
        <p><strong>Item:</strong> <span id="pdf-item"></span></p>
        <p><strong>Quantity:</strong> <span id="pdf-quantity"></span></p>
        <p><strong>Unit Price:</strong> $<span id="pdf-unit-price"></span></p>
        <p><strong>Discount (%):</strong> <span id="pdf-discount"></span>%</p>
        <p><strong>VAT (%):</strong> <span id="pdf-vat"></span>%</p>
        <p><strong>Total Price:</strong> $<span id="pdf-total"></span></p>
    </div>


    <footer>
        <p>&copy; 2024 PowerTech. All rights reserved.</p>
    </footer>

    <script>
        // Load saved VAT and other form data from localStorage
        window.onload = function () {
            // Load VAT
            const savedVAT = localStorage.getItem('vatRate');
            if (savedVAT) {
                document.getElementById('vat').value = savedVAT;
            }
    
            // Load other saved form data
            const savedFormData = JSON.parse(localStorage.getItem('formData')) || {};
            for (const [key, value] of Object.entries(savedFormData)) {
                const element = document.getElementById(key);
                if (element) {
                    element.value = value;
                }
            }
    
            // Calculate total on load if data exists
            calculateTotal();
        };
    
        // Calculate total and save all form data to localStorage
        const calculateTotal = () => {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const unitPrice = parseFloat(document.getElementById('unit-price').value) || 0;
            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const vat = parseFloat(document.getElementById('vat').value) || 0;
    
            // Save all form data to localStorage
            const formData = {
                'shop-name': document.getElementById('shop-name').value,
                'customer-name': document.getElementById('customer-name').value,
                'shop-address': document.getElementById('shop-address').value,
                'date': document.getElementById('date').value,
                'item': document.getElementById('item').value,
                'quantity': quantity,
                'unit-price': unitPrice,
                'discount': discount,
                'vat': vat
            };
    
            localStorage.setItem('formData', JSON.stringify(formData));
            localStorage.setItem('vatRate', vat);
    
            const subtotal = quantity * unitPrice;
            const discountAmount = subtotal * (discount / 100);
            const afterDiscount = subtotal - discountAmount;
            const vatAmount = afterDiscount * (vat / 100);
            const total = afterDiscount + vatAmount;
    
            document.getElementById('total-price').value = total.toFixed(2);
            localStorage.setItem('totalPrice', total.toFixed(2));
        };
    
        // Add event listeners for calculation and storage
        ['quantity', 'unit-price', 'discount', 'vat', 'shop-name', 'customer-name',
            'shop-address', 'date', 'item'].forEach(id => {
                const element = document.getElementById(id);
                element.addEventListener('input', () => {
                    calculateTotal();
                });
            });
    
        // Generate PDF function with saved data
        function generatePDF() {
            // Get saved form data
            const savedFormData = JSON.parse(localStorage.getItem('formData')) || {};
            const savedTotal = localStorage.getItem('totalPrice') || '0';
    
            // Update placeholders in the bill template
            document.getElementById('pdf-shop-name').textContent = savedFormData['shop-name'] || 'N/A';
            document.getElementById('pdf-customer-name').textContent = savedFormData['customer-name'] || 'N/A';
            document.getElementById('pdf-address').textContent = savedFormData['shop-address'] || 'N/A';
            document.getElementById('pdf-date').textContent = savedFormData['date'] || 'N/A';
    
            const itemSelect = document.getElementById('item');
            const selectedItemText = itemSelect.options[itemSelect.selectedIndex]?.text || 'N/A';
            document.getElementById('pdf-item').textContent = selectedItemText;
    
            document.getElementById('pdf-quantity').textContent = savedFormData['quantity'] || '0';
            document.getElementById('pdf-unit-price').textContent = savedFormData['unit-price'] || '0.00';
            document.getElementById('pdf-discount').textContent = savedFormData['discount'] || '0%';
            document.getElementById('pdf-vat').textContent = savedFormData['vat'] || '0%';
            document.getElementById('pdf-total').textContent = savedTotal;
    
            // Generate PDF using html2pdf
            const element = document.getElementById('bill-template');
            if (!element) {
                alert("Bill template is missing in the HTML.");
                return;
            }
    
            const opt = {
                margin: 1,
                filename: `PowerTech-Invoice-${savedFormData['shop-name'] || 'Invoice'}.pdf`,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
    
            html2pdf().from(element).set(opt).save();
        }
    
        // Form submission handler
        document.getElementById('inventory-form').addEventListener('submit', function (e) {
            e.preventDefault();
            calculateTotal(); // Ensure final calculations are saved
            alert('Inventory updated successfully!');
        });
    </script>
    
</body>
</html>