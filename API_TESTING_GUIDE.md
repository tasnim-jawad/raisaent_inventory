# API Testing Guide for Warehouse Stock Feature

## Testing the Enhanced Product API

### 1. Basic Product List with Warehouse Stock
```bash
curl -X GET "http://your-domain.com/api/v1/products" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

### 2. Get All Products (No Pagination)
```bash
curl -X GET "http://your-domain.com/api/v1/products?get_all=1" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

### 3. Search Products with Warehouse Stock
```bash
curl -X GET "http://your-domain.com/api/v1/products?search=product_name" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

### 4. Filter by Status with Warehouse Stock
```bash
curl -X GET "http://your-domain.com/api/v1/products?status=active&limit=10" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

## Expected Response Format

```json
{
    "status": "success",
    "code": 200,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Sample Product",
                "description": "Product description",
                "product_category_id": 1,
                "product_sub_category_id": 1,
                "suppliyer_id": 1,
                "status": "active",
                "created_at": "2024-01-01T00:00:00.000000Z",
                "updated_at": "2024-01-01T00:00:00.000000Z",
                "total_stock_quantity": 150,
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
                },
                "product_category": {
                    "id": 1,
                    "title": "Category Name"
                },
                "product_sub_category": {
                    "id": 1,
                    "title": "Sub Category Name"
                },
                "suppliyer": {
                    "id": 1,
                    "name": "Supplier Name"
                }
            }
        ],
        "first_page_url": "http://your-domain.com/api/v1/products?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://your-domain.com/api/v1/products?page=1",
        "links": [...],
        "next_page_url": null,
        "path": "http://your-domain.com/api/v1/products",
        "per_page": 500,
        "prev_page_url": null,
        "to": 1,
        "total": 1,
        "active_data_count": 10,
        "inactive_data_count": 2,
        "trased_data_count": 1
    }
}
```

## Verification Checklist

### ✅ Data Validation
- [ ] Each product shows `warehouse_stock_details` attribute
- [ ] `total_stock` matches sum of all warehouse remaining stocks
- [ ] All warehouses appear in the list (even with 0 stock)
- [ ] `remaining_stock` = `stock_in` - `stock_out`
- [ ] No negative stock values displayed

### ✅ Performance Checks
- [ ] Response time is reasonable for large product lists
- [ ] No N+1 query issues (check your database query logs)
- [ ] Memory usage is acceptable

### ✅ Edge Cases
- [ ] Products with no stock transactions show 0 values
- [ ] Inactive warehouses are not included
- [ ] Deleted/soft-deleted stock records are ignored
- [ ] Empty product list handles gracefully

## Database Query Monitoring

To monitor the queries being executed, add this to your `.env` file temporarily:
```
DB_LOG_QUERIES=true
```

Or use Laravel Telescope/Debugbar to monitor database queries.

## Troubleshooting

### Common Issues

1. **Missing warehouse_stock_details in response**
   - Check if the model's `$appends` array includes 'warehouse_stock_details'
   - Verify DB connections and table names

2. **Slow response times**
   - Check if proper indexes exist on foreign key columns
   - Monitor query execution plans

3. **Incorrect stock calculations**
   - Verify that only 'active' status records are included
   - Check the JOIN conditions in the SQL queries

4. **Empty warehouse list**
   - Ensure warehouses exist with status = 'active'
   - Check warehouse model relationships

### Performance Optimization Tips

1. **Database Indexes** (Recommended):
```sql
-- For better performance, consider adding these indexes:
CREATE INDEX idx_whpsp_product_status ON ware_house_product_stock_products(product_id, status);
CREATE INDEX idx_wpop_product_status ON warehouse_product_out_products(product_id, status);
CREATE INDEX idx_whps_warehouse_status ON ware_house_product_stocks(warehouse_id, status);
CREATE INDEX idx_wpo_warehouse_status ON warehouse_product_outs(warehouse_id, status);
```

2. **Query Optimization**:
   - Use `get_all=1` parameter for non-paginated results when possible
   - Implement proper caching for warehouse list if it doesn't change frequently

3. **Response Size**:
   - Consider adding a parameter to exclude warehouse details if not needed
   - Implement field selection for API responses