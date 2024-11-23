<?php

// Function to fetch data from child company APIs
function fetch_child_company_data($api_url, $company_name) {
    try {
        // Fetch data from the API
        $response = file_get_contents($api_url);
        if ($response === false) {
            throw new Exception("Failed to fetch data from $api_url");
        }

        // Decode JSON response
        $data = json_decode($response, true);

        // Check if the response has valid data
        if ($data['status'] !== 'success' || !isset($data['data'])) {
            throw new Exception("Invalid response from $api_url");
        }

        // Add company name to each product
        foreach ($data['data'] as &$product) {
            $product['company'] = $company_name;
        }

        return $data['data'];
    } catch (Exception $e) {
        error_log($e->getMessage());
        return [];
    }
}

// Function to get the top 5 most visited products
function get_top_5_products($all_products) {
    // Sort by visit_count in descending order
    usort($all_products, function ($a, $b) {
        return $b['visit_count'] - $a['visit_count'];
    });

    // Return the top 5
    return array_slice($all_products, 0, 5);
}