<?php 
	session_start();
	require __DIR__.'/vendor/autoload.php';
	use phpish\shopify;

	require __DIR__.'/conf.php';

	$shopify = shopify\client($_SESSION['shop'], SHOPIFY_APP_API_KEY, $_SESSION['oauth_token']);

	try
	{
			echo "<table>
	<tr>
		<th>ID</th>
		<th>IMAGE</th>
		<th>TITLE</th>
	</tr>";
		$products = $shopify('GET /admin/products.json?limit=100', array('published_status'=>'published'));
		$so_sp = count($products);
		for ($i = 0; $i < $so_sp;$i++){
			echo "<tr>";
			echo "<td>".$products[$i]['id']."</td>";
			echo "<td>"; ?>
			<?php if (isset($products[$i]['images'][0]['src'])) {
				echo $products[$i]['images'][0]['src'];
			} else {
				echo "khong co hinh anh";
			}
			 ?>
			<?php echo "</td>";
			echo "<td>".$products[$i]['title']."</td>";
			echo "</tr>";

		}
		echo "</table>";
	}
	catch (shopify\ApiException $e)
	{
		# HTTP status code was >= 400 or response contained the key 'errors'
		echo $e;
		print_r($e->getRequest());
		print_r($e->getResponse());
	}
	catch (shopify\CurlException $e)
	{
		# cURL error
		echo $e;
		print_r($e->getRequest());
		print_r($e->getResponse());
	}
