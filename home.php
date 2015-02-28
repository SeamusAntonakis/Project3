<?php

$page_title = 'AppCast - Home';

# Include header placed in the includes folder.

include('includes/header.php');

# Display grid of images.

echo '
<div class="wrapper">
	<div class="container">	
		<div id="two-columns" class="grid-container" style="display:block;">
			<ul class="rig columns">
				<li>
					<img src="includes/images/1.jpg" />
					<h3>Image Title</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</li>
				<li>
					<img src="includes/images/2.jpg" />
					<h3>Image Title</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</li>
				<li>
					<img src="includes/images/3.jpg" />
					<h3>Image Title</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</li>
				<li>
					<img src="includes/images/4.jpg" />
					<h3>Image Title</h3>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				</li>
			</ul>
		</div>
		</div>
	<!--/.container-->
</div>
<!--/.wrapper-->';

# Include the footer placed in the includes folder.
# include('includes/footer.html');

?>