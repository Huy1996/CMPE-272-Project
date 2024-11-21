<?php include "header.php";?>

<h2>Welcome to the Marketplace</h2>
<div class="company-grid">
    <!-- Company 1 -->
    <div class="company-card">
        <img src="images\images.png" alt="Tech Master">
        <h2>Tech Master</h2>
        <p>Your trusted partner in tech solutions.</p>
        <p>Contact: info@techmaster.com</p>
        <a href="http://localhost/hw/<?php echo $jwt ? '?token=' . urlencode($jwt) : ''; ?>" class="btn">Visit Tech Master</a>
    </div>

    <!-- Company 2 -->
    <div class="company-card">
        <img src="images/company2.jpg" alt="Company 2">
        <h2>Company 2</h2>
        <p>Innovative designs for your needs.</p>
        <p>Contact: support@company2.com</p>
        <a href="http://company2.com" class="btn">Visit Company</a>
    </div>

    <!-- Company 3 -->
    <div class="company-card">
        <img src="images/company3.jpg" alt="Company 3">
        <h2>Company 3</h2>
        <p>Reliable and affordable services.</p>
        <p>Contact: hello@company3.com</p>
        <a href="http://company3.com" class="btn">Visit Company</a>
    </div>

    <!-- Company 4 -->
    <div class="company-card">
        <img src="images/company4.jpg" alt="Company 4">
        <h2>Company 4</h2>
        <p>Building tomorrow's technology today.</p>
        <p>Contact: contact@company4.com</p>
        <a href="http://company4.com" class="btn">Visit Company</a>
    </div>
</div>

<?php include "footer.php";?>
