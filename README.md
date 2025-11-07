
# Custom WooCommerce API Plugin
## 📌 Description
This plugin adds a REST API for managing WooCommerce products. It allows retrieving product lists, creating new products, and deleting existing ones.

## ⚡ Features
- 📦 Retrieve product list (`GET /products`)
- ➕ Create a new product (`POST /products`)
- ❌ Delete a product (`DELETE /products/{id}`)

## 🛠 Installation
1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-repo/custom-woo-api.git
   ```
2. **Move the folder to the WordPress plugins directory:**
   ```sh
   mv custom-woo-api /wp-content/plugins/
   ```
3. **Activate the plugin in the WordPress admin panel.**

## 🚀 API Usage
### 📥 Retrieve Product List
```sh
curl -X GET "http://your-site.com/wp-json/custom-woo/v1/products" -H "Content-Type: application/json"
```

### ➕ Create a New Product
```sh
curl -X POST "http://your-site.com/wp-json/custom-woo/v1/products" \
     -H "Content-Type: application/json" \
     -H "Authorization: Basic YOUR_ENCODED_CREDENTIALS" \
     -d '{ "name": "New Product", "price": 99.99, "stock": 10 }'
```

### ❌ Delete a Product
```sh
curl -X DELETE "http://your-site.com/wp-json/custom-woo/v1/products/123" \
     -H "Authorization: Basic YOUR_ENCODED_CREDENTIALS"
```

## 🔐 Authentication
To perform `POST` and `DELETE` requests, **Basic Auth** is required. You can obtain a Base64 token using PowerShell:
```powershell
[Convert]::ToBase64String([Text.Encoding]::UTF8.GetBytes("your_username:your_password"))
```

