<?php
include "functions/function.php";

// URLs of child company APIs
$child_company_apis = [
    ["url" => "http://localhost/hw/products/get_top_visited.php", "name" => "Techmaster"]
    // ["url" => "http://company2.com/api_get_most_visited.php", "name" => "Company 2"],
    // ["url" => "http://company3.com/api_get_most_visited.php", "name" => "Company 3"],
    // ["url" => "http://company4.com/api_get_most_visited.php", "name" => "Company 4"]
];

$all_products = [];

// Fetch data from all child company APIs
foreach ($child_company_apis as $api) {
    $products = fetch_child_company_data($api['url'], $api['name']);
    $all_products = array_merge($all_products, $products);
}

// Get the top 5 most visited products
$top_5_products = get_top_5_products($all_products);
include "header.php";
?>
<div class="container">
    <h1>Top 5 Most Visited Products</h1>
    <?php if (!empty($top_5_products)): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Visit Count</th>
                    <th>Company</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top_5_products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($product['visit_count']); ?></td>
                        <td><?php echo htmlspecialchars($product['company']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No data available.</p>
    <?php endif; ?>
</div>
<?php include "footer.php"; ?>