<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SummitPOS - Staff Panel</title>

    <!-- html5-qrcode CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        /* Reset & base */
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #2f3e2f;
            line-height: 1.5;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #4a6a34;
            color: #e8f0d8;
            box-shadow: 0 2px 6px rgba(74, 106, 52, 0.4);
            user-select: none;
        }
        header h1 {
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }
        .header-buttons button {
            background-color: #6b8e3a;
            color: #e8f0d8;
            border: none;
            padding: 0.55rem 1.1rem;
            margin-left: 0.6rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background-color 0.25s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
        .header-buttons button.active,
        .header-buttons button:hover {
            background-color: #374b1f;
            box-shadow: 0 3px 8px rgba(0,0,0,0.3);
        }

        /* Main container */
        main {
            max-width: 1200px;
            margin: 2rem auto 3rem;
            padding: 0 2rem;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        /* Top section */
        .top-section {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        .scanner-container {
            flex: 2;
            background-color: #35492d;
            border-radius: 12px;
            padding: 1.5rem 1.8rem 3rem;
            color: #d1c794;
            position: relative;
            box-shadow: 0 6px 15px rgb(45 69 31 / 0.5);
            min-width: 320px;
        }
        #qr-scanner {
            border: 3px dashed #d1c794;
            border-radius: 12px;
            height: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 700;
            font-size: 1.1rem;
            user-select: none;
            background: linear-gradient(135deg, #2f4625 25%, #425b33 100%);
            box-shadow: inset 0 0 20px rgb(209 199 148 / 0.4);
            transition: background-color 0.3s ease;
        }
        .toggle-scanner-btn {
            position: absolute;
            bottom: 1.5rem;
            left: 1.8rem;
            background-color: #d1c794;
            color: #35492d;
            border: none;
            padding: 0.65rem 1.25rem;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgb(209 199 148 / 0.5);
            user-select: none;
            transition: background-color 0.25s ease, box-shadow 0.25s ease;
            letter-spacing: 0.05em;
        }
        .toggle-scanner-btn:hover {
            background-color: #b9af6c;
            box-shadow: 0 6px 14px rgb(185 175 108 / 0.7);
        }

        /* Current order */
        .current-order {
            flex: 1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 280px;
            user-select: none;
        }
        .current-order h2 {
            margin-top: 0;
            font-weight: 800;
            color: #374b1f;
            font-size: 1.5rem;
            letter-spacing: 0.03em;
        }
        .order-total {
            font-weight: 700;
            font-size: 1.3rem;
            margin: 1.5rem 0 2rem;
            color: #466034;
            text-align: right;
        }
        .checkout-btn {
            background-color: #5fa64a;
            border: none;
            padding: 0.9rem 0;
            font-weight: 700;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            letter-spacing: 0.04em;
            box-shadow: 0 6px 14px rgb(95 166 74 / 0.65);
            transition: background-color 0.3s ease;
        }
        .checkout-btn:hover {
            background-color: #4a7a37;
            box-shadow: 0 8px 20px rgb(74 122 55 / 0.8);
        }

        /* Categories */
        .categories {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: center;
            user-select: none;
        }
        .category-btn {
            padding: 0.5rem 1.3rem;
            border-radius: 25px;
            border: 1.8px solid #466034;
            background-color: white;
            color: #466034;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(70, 96, 52, 0.12);
        }
        .category-btn.active,
        .category-btn:hover {
            background-color: #466034;
            color: white;
            box-shadow: 0 4px 14px rgba(70, 96, 52, 0.4);
        }

        /* Product grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1.5rem;
            user-select: none;
        }
        .product-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 6px 14px rgb(0 0 0 / 0.07);
            padding: 1rem 1.2rem 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: box-shadow 0.25s ease, transform 0.25s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .product-card:hover {
            box-shadow: 0 10px 24px rgb(0 0 0 / 0.15);
            transform: translateY(-4px);
        }
        .product-image {
            height: 110px;
            width: 110px;
            background: linear-gradient(145deg, #eee, #ccc);
            border-radius: 14px;
            box-shadow: inset 0 3px 6px rgb(255 255 255 / 0.8);
            margin-bottom: 0.85rem;
        }
        .product-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #2f3e2f;
            margin-bottom: 0.25rem;
        }
        .product-price {
            color: #5a7a34;
            font-weight: 700;
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .top-section {
                flex-direction: column;
            }
            .scanner-container, .current-order {
                min-width: 100%;
            }
            main {
                padding: 0 1rem;
            }
            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>SummitPOS</h1>
    </header>

    <main>
        <div class="top-section">
            <div class="scanner-container">
                <div id="qr-scanner">
                    Align QR code within frame to scan
                </div>
                <button id="toggle-scanner-btn" class="toggle-scanner-btn">Start Scanner</button>
            </div>

            <div class="current-order">
                <h2>Current Order</h2>
                <div class="order-total">Total: <strong>$0.00</strong></div>
                <button class="checkout-btn">Checkout</button>
            </div>
        </div>

        <div class="categories">
            <button class="category-btn active">All Items</button>
            <button class="category-btn">Food</button>
            <button class="category-btn">Drinks</button>
            <button class="category-btn">Gear</button>
        </div>

        <div class="product-grid">
            <div class="product-card" data-category="food">
                <div class="product-image"></div>
                <div class="product-name">Trail Mix</div>
                <div class="product-price">$3.99</div>
            </div>
            <div class="product-card" data-category="food">
                <div class="product-image"></div>
                <div class="product-name">Energy Bar</div>
                <div class="product-price">$2.49</div>
            </div>
            <div class="product-card" data-category="drinks">
                <div class="product-image"></div>
                <div class="product-name">Bottled Water</div>
                <div class="product-price">$1.99</div>
            </div>
            <div class="product-card" data-category="drinks">
                <div class="product-image"></div>
                <div class="product-name">Sports Drink</div>
                <div class="product-price">$2.99</div>
            </div>
            <div class="product-card" data-category="gear">
                <div class="product-image"></div>
                <div class="product-name">Hiking Boots</div>
                <div class="product-price">$129.99</div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html5QrCode = new Html5Qrcode("qr-scanner");
            const toggleScannerBtn = document.getElementById("toggle-scanner-btn");
            let scannerRunning = false;

            async function startScanner() {
                try {
                    const cameras = await Html5Qrcode.getCameras();
                    if (cameras && cameras.length) {
                        const cameraId = cameras[0].id;
                        await html5QrCode.start(
                            cameraId,
                            {
                                fps: 10,
                                qrbox: 250,
                                aspectRatio: 1.0,
                                experimentalFeatures: { useBarCodeDetectorIfSupported: true }
                            },
                            qrCodeMessage => {
                                console.log("QR Code detected:", qrCodeMessage);
                                alert("Scanned: " + qrCodeMessage);

                                // Example: send scanned data to backend via fetch API
                                fetch('/scan-qr', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ qr_code: qrCodeMessage })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log("Server response:", data);
                                    // TODO: update UI accordingly
                                })
                                .catch(error => {
                                    console.error('Error sending QR data:', error);
                                });
                            },
                            errorMessage => {
                                // Optional scan error handling
                                // console.debug("QR scan error:", errorMessage);
                            }
                        );
                        toggleScannerBtn.textContent = "Stop Scanner";
                        scannerRunning = true;
                    } else {
                        alert("No cameras found on this device.");
                    }
                } catch (err) {
                    alert("Error starting scanner: " + err);
                }
            }

            async function stopScanner() {
                try {
                    await html5QrCode.stop();
                    toggleScannerBtn.textContent = "Start Scanner";
                    scannerRunning = false;
                } catch (err) {
                    alert("Failed to stop scanner: " + err);
                }
            }

            toggleScannerBtn.addEventListener("click", () => {
                if (scannerRunning) {
                    stopScanner();
                } else {
                    startScanner();
                }
            });

            // Category filtering
            const categoryButtons = document.querySelectorAll(".category-btn");
            const productCards = document.querySelectorAll(".product-card");

            categoryButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    // Remove active from all buttons
                    categoryButtons.forEach(b => b.classList.remove("active"));
                    // Activate clicked
                    btn.classList.add("active");

                    const category = btn.textContent.trim().toLowerCase();

                    productCards.forEach(card => {
                        const productCategory = card.getAttribute("data-category");
                        if (category === "all items" || productCategory === category) {
                            card.style.display = "flex";
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
