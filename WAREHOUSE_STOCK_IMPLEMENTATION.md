# Warehouse Stock Implementation

## Overview
This implementation adds warehouse-wise stock tracking to the product listing API. Each product now shows detailed stock information for all warehouses, including stock in, stock out, and remaining stock.

## Database Tables Used

### 1. `ware_houses`
- Stores warehouse information
- Fields: `id`, `name`, `address`, `status`

### 2. `ware_house_product_stocks`
- Main stock entry records
- Fields: `id`, `warehouse_id`, `purchase_order_id`, `date`

### 3. `ware_house_product_stock_products`
- Product-specific stock in records
- Fields: `id`, `ware_house_product_stock_id`, `product_id`, `product_name`, `quantity`

### 4. `warehouse_product_outs`
- Main stock out records
- Fields: `id`, `warehouse_id`, `sales_order_id`, `date`

### 5. `warehouse_product_out_products`
- Product-specific stock out records
- Fields: `id`, `ware_house_product_out_id`, `product_id`, `product_name`, `quantity`

## Implementation Details

### 1. Product Model Updates
- Added `warehouse_stock_details` to the `$appends` array
- Created `getWarehouseStockDetailsAttribute()` method
- Added static method `getWarehouseStockDataForProducts()` for bulk operations
- Updated `getTotalStockQuantityAttribute()` to use new calculation method

### 2. Model Relationships
- Added `wareHouseProductStock()` relationship to `WareHouseProductStockProductModel`
- Added `wareHouseProductOut()` relationship to `WarehouseProductOutProductModel`

### 3. GetAllData Action Updates
- Enhanced to include warehouse stock details for all products
- Uses efficient bulk querying to avoid N+1 queries
- Supports both paginated and non-paginated results

## API Response Structure

### Product List Response
```json
{
  "data": [
    {
      "id": 1,
      "title": "Product Name",
      "description": "Product Description",
      "total_stock_quantity": 150,
      "warehouse_stock_details": {
        "total_stock": 150,
        "warehouse_details": [
          {
            "warehouse_id": 1,
            "warehouse_name": "Main Warehouse",
            "stock_in": 200,
            "stock_out": 30,
            "remaining_stock": 170
          },
          {
            "warehouse_id": 2,
            "warehouse_name": "Secondary Warehouse",
            "stock_in": 0,
            "stock_out": 20,
            "remaining_stock": 0
          }
        ]
      }
    }
  ]
}
```

## Features

### 1. Warehouse-wise Stock Display
- Shows stock for ALL warehouses (even if stock is 0)
- Calculates remaining stock as: Stock In - Stock Out
- Ensures no negative stock values are displayed

### 2. Performance Optimization
- Uses raw SQL queries with JOINs for efficiency
- Bulk processing for multiple products
- Minimal database queries regardless of product count

### 3. Data Accuracy
- Only considers active records (`status = 'active'`)
- Proper relationships between stock tables
- Accurate stock calculations

## Usage

### Get Products with Warehouse Stock
```
GET /api/v1/products
```

### Parameters
- `limit`: Number of products per page (default: 500)
- `status`: Product status filter (default: 'active')
- `search`: Search term for product title/description
- `get_all`: Set to 1 to get all products without pagination
- Other existing filters (category, supplier, date range, etc.)

## SQL Queries Used

### Stock In Calculation
```sql
SELECT whps.warehouse_id, SUM(whpsp.quantity) as total_in
FROM ware_house_product_stock_products whpsp
JOIN ware_house_product_stocks whps ON whpsp.ware_house_product_stock_id = whps.id
WHERE whpsp.product_id = ? 
  AND whpsp.status = 'active' 
  AND whps.status = 'active'
GROUP BY whps.warehouse_id
```

### Stock Out Calculation
```sql
SELECT wpo.warehouse_id, SUM(wpop.quantity) as total_out
FROM warehouse_product_out_products wpop
JOIN warehouse_product_outs wpo ON wpop.ware_house_product_out_id = wpo.id
WHERE wpop.product_id = ? 
  AND wpop.status = 'active' 
  AND wpo.status = 'active'
GROUP BY wpo.warehouse_id
```

## Benefits

1. **Complete Stock Visibility**: Shows stock status across all warehouses
2. **Real-time Calculations**: Stock is calculated on-demand with current data
3. **Zero Stock Warehouses**: Explicitly shows warehouses with no stock
4. **Performance**: Optimized queries prevent database overload
5. **Accurate Totals**: Proper total stock calculation across all warehouses

## Future Enhancements

1. Stock movement history tracking
2. Low stock alerts per warehouse
3. Stock transfer between warehouses
4. Warehouse-specific stock reservations
5. Stock aging reports