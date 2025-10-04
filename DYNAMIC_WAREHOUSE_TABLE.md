# Dynamic Warehouse Stock Table Implementation

## Overview
The product table now dynamically displays warehouse-wise stock information with columns for each warehouse showing remaining stock quantities.

## Table Structure

### Static Columns (Always Present)
1. **Actions** - Row actions (edit, delete, etc.)
2. **Select** - Checkbox for bulk operations
3. **ID** - Product sequence number
4. **Title** - Product name
5. **Supplier** - Supplier information
6. **Product Category** - Category name
7. **Product Sub Category** - Sub-category name
8. **Total Stock** - Sum of all warehouse stocks

### Dynamic Columns (Based on Active Warehouses)
- **[Warehouse Name] Stock** - Remaining stock for each warehouse
- Columns are generated dynamically based on active warehouses
- Stock values are color-coded with badges:
  - **Green (Success)**: Stock >= 10
  - **Yellow (Warning)**: Stock < 10 but >= 5
  - **Red (Danger)**: Stock < 5
  - **Gray (Secondary)**: Stock = 0

### Static Columns (End)
9. **Status** - Product status (active/inactive)
10. **Created At** - Creation timestamp
11. **Image** - Product image

## Implementation Details

### Frontend Components Modified

1. **TableHead.vue**
   - Uses `dynamicTableHeaders` computed property
   - Fetches warehouse data from store
   - Generates headers dynamically

2. **TableBody.vue**
   - Uses `dynamicTableRowData` computed property
   - Renders warehouse stock with color-coded badges
   - Handles missing/empty warehouse data gracefully

3. **All.vue (Main Page)**
   - Fetches warehouses on component creation
   - Includes warehouses in store state

4. **Store Enhancement**
   - Added `warehouses` to initial state
   - Created `get_warehouses` async action
   - Fetches active warehouses from API

### Stock Display Logic

```javascript
// Get warehouse stock for a specific warehouse
getWarehouseStock(item, warehouseKey) {
  const warehouseId = parseInt(warehouseKey.replace('warehouse_stock_', ''));
  const warehouseDetails = item.warehouse_stock_details?.warehouse_details || [];
  
  const warehouseData = warehouseDetails.find(detail => 
    detail.warehouse_id === warehouseId
  );
  
  return warehouseData?.remaining_stock || 0;
}

// Badge color logic
getStockBadgeClass(stock) {
  if (stock === 0) return 'badge-secondary';      // Gray
  if (stock < 5) return 'badge-danger';          // Red
  if (stock < 10) return 'badge-warning';        // Yellow
  return 'badge-success';                        // Green
}
```

### API Integration

**Warehouse API Endpoint:**
```
GET /api/v1/ware-houses?get_all=1&status=active
```

**Expected Warehouse Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "name": "Main Warehouse",
      "address": "Main Address",
      "status": "active"
    },
    {
      "id": 2,
      "name": "Branch Warehouse", 
      "address": "Branch Address",
      "status": "active"
    }
  ]
}
```

**Product Response with Warehouse Stock:**
```json
{
  "id": 1,
  "title": "Sample Product",
  "warehouse_stock_details": {
    "total_stock": 150,
    "warehouse_details": [
      {
        "warehouse_id": 1,
        "warehouse_name": "Main Warehouse",
        "stock_in": 200,
        "stock_out": 50,
        "remaining_stock": 150
      },
      {
        "warehouse_id": 2,
        "warehouse_name": "Branch Warehouse",
        "stock_in": 0,
        "stock_out": 0,
        "remaining_stock": 0
      }
    ]
  }
}
```

## Benefits

1. **Dynamic Adaptation**: Table automatically adjusts when warehouses are added/removed
2. **Visual Stock Indicators**: Color-coded badges for quick stock level assessment
3. **Comprehensive View**: Complete warehouse-wise stock visibility in one table
4. **Performance Optimized**: Efficient queries and minimal re-renders
5. **Responsive Design**: Table maintains usability across different screen sizes

## Usage

### For Developers
1. Warehouse columns are generated automatically
2. No manual configuration needed for new warehouses
3. Stock data is fetched with product data in a single API call

### For Users
1. View total stock across all warehouses
2. See individual warehouse stock levels
3. Quickly identify low stock situations with color coding
4. Use all existing filtering and sorting features

## Styling

```css
.badge {
  padding: 4px 8px;
  border-radius: 4px;
  font-size: 11px;
  font-weight: bold;
  color: white;
}

.badge-success { background-color: #28a745; }  /* Green - Good stock */
.badge-warning { background-color: #ffc107; }  /* Yellow - Low stock */
.badge-danger { background-color: #dc3545; }   /* Red - Very low stock */
.badge-secondary { background-color: #6c757d; } /* Gray - No stock */
.badge-primary { background-color: #007bff; }   /* Blue - Total stock */
```

## Future Enhancements

1. **Stock Alerts**: Click on low stock badges to set alerts
2. **Stock Transfer**: Quick actions to transfer stock between warehouses
3. **Historical Trends**: Hover tooltips showing stock movement trends
4. **Warehouse Filtering**: Filter products by specific warehouse stock levels
5. **Export Options**: Include warehouse columns in CSV exports
6. **Mobile Optimization**: Collapsible warehouse columns for mobile view