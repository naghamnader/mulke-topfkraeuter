<?php
/**
Template Name: Produkt Template
*/
get_header();

?>

<section class="page-wrapper">
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<style>
body {
  overscroll-behavior-y: none;
}
.product-box-parent{
	margin: 4%;
    padding-bottom: 4%;
	border-radius: 10px;
	position: relative;
    background: linear-gradient(300deg, rgba(8,225,174,0.24273459383753504) 0%, rgba(152,222,91,0.40800070028011204) 31%, rgba(8,225,174,0.37718837535014005) 100%);

}
p {
    color: black;
    font-size: 15px;
    font-family: 'Raleway', sans-serif;
}
.product-row{

	/** same height for all columns */
	display: -webkit-box;
	display: -webkit-flex;
	display: -ms-flexbox;
	display: flex;
	flex-wrap: wrap;
} 
.cart-btn-holder{
    bottom: 2%;
    position: absolute;
}
input[type=number]::-webkit-inner-spin-button {
	/** show the number picker buttons all the time */
  opacity: 1;
}
.product-img{
	width:100% !important;
    height: 250px!important;
}
.img-holder{
	margin-top: 3%;
    margin-bottom: 3%;
}
</style>

	<div class="container-fluid">
					
        <?php 
        
        include "mulke-db-connection.php";
        //show saved produkte
            $sql = "SELECT * FROM mulke_product";
            $result = $conn->query($sql);
            if (!$result) {
                trigger_error('Invalid query: ' . $conn->error);
            }
            echo "<div class='col-md-9'>";
            if ($result->num_rows > 0) {
				$i = 1;
            // output data of each row
            while($row = $result->fetch_assoc()) {
				if($i % 3 == 1) {
					echo "<div class='row product-row'>";
				}
                echo "<div class='headline col-md-3 product-box-parent' id ='product-box-" . $row['id'] . "'>";
                echo "<div class='col-md-12 text-center img-holder'><img class='img-rounded product-img' src='" . $row['product_img'] . "'></div><!-- /.img-holder -->";
                echo "<h3 class='col-md-8'><strong>" . $row['product_name'] . "</strong></h3>";
                echo "<p class='col-md-10'><strong>usage:</strong> " . $row['product_usage'] . "</p>";
                echo "<p class='col-md-7'><strong>Location:</strong> " . getProductLocation($row['product_location']) . "</p>";
                echo "<p class='col-md-7'><strong>Wasser:</strong> " . getProductWaterConsumption($row['water_consumption']) . "</p>";
				echo "<p class='col-md-11'><strong>Prise:</strong> " . $row['product_price'] . " &#8364;</p>";
				echo "<div class='col-md-7 cart-btn-holder'>";
				echo do_shortcode("[wp_cart_button name='" . $row['product_name'] . "' price='" . $row['product_price'] . "']");
				echo "</div><!-- /.cart-btn-holder -->";
				echo "</div><!-- /.product-box-parent -->";

				if($i % 3 == 0 || $i == $result->num_rows) {
					echo "</div> <!-- /.product-row -->";
				}
                $i++;
            }
            echo "</div><!-- /.products-column -->";
            
            } else {
            echo "0 results";
            }
            $conn->close();
           
    function getProductLocation($key) {
        $value = "";
        switch($key){
            case 1:
                $value = "sonnig";
            break; 
            case 2:
                $value = "vollsonnig";
            break; 
            case 3:
                $value = "halbschattig";
            break; 
            case 4:
                $value = "schattig";
            break; 
        }
        return $value;
    }
    function getProductWaterConsumption($key) {
        $value = "";
        switch($key){
            case 1:
                $value = "mittel";
            break; 
            case 2:
                $value = "mäßig feucht";
            break; 
            case 3:
                $value = "feucht";
            break; 
            case 4:
                $value = "leicht feucht";
            break; 
            case 5:
                $value = "mäßig";
            break; 
            case 6:
                $value = "mäßig trocken";
            break; 
            case 7:
                $value = "trocken";
            break; 
        }
        return $value;
    }
    ?>
        
    <?php if ( is_active_sidebar( 'sidebar-product' ) ) : ?>
    <?php dynamic_sidebar( 'sidebar-product' ); ?>
    <?php endif; ?>

	</div><!-- /.container -->
</section>
<?php
get_footer();
?>