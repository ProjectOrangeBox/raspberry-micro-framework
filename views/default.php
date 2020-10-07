<?= pear::include('parts/head') ?>
<?= pear::include('parts/nav') ?>
<?= pear::include('parts/header') ?>

<!-- Portfolio Section-->
<section class="page-section portfolio" id="portfolio">
	<div class="container">
		<!-- Portfolio Section Heading-->
		<h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Portfolio</h2>
		<!-- Icon Divider-->
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- Portfolio Grid Items-->
		<div class="row">
			<!-- Portfolio Item 1-->
			<div class="col-md-6 col-lg-4 mb-5">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal1">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/cabin.png" alt="" />
				</div>
			</div>
			<!-- Portfolio Item 2-->
			<div class="col-md-6 col-lg-4 mb-5">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal2">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/cake.png" alt="" />
				</div>
			</div>
			<!-- Portfolio Item 3-->
			<div class="col-md-6 col-lg-4 mb-5">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal3">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/circus.png" alt="" />
				</div>
			</div>
			<!-- Portfolio Item 4-->
			<div class="col-md-6 col-lg-4 mb-5 mb-lg-0">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal4">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/game.png" alt="" />
				</div>
			</div>
			<!-- Portfolio Item 5-->
			<div class="col-md-6 col-lg-4 mb-5 mb-md-0">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal5">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/safe.png" alt="" />
				</div>
			</div>
			<!-- Portfolio Item 6-->
			<div class="col-md-6 col-lg-4">
				<div class="portfolio-item mx-auto" data-toggle="modal" data-target="#portfolioModal6">
					<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">
						<div class="portfolio-item-caption-content text-center text-white"><i class="fas fa-plus fa-3x"></i></div>
					</div>
					<img class="img-fluid" src="assets/img/portfolio/submarine.png" alt="" />
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About Section-->
<section class="page-section bg-primary text-white mb-0" id="about">
	<div class="container">
		<!-- About Section Heading-->
		<h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
		<!-- Icon Divider-->
		<div class="divider-custom divider-light">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- About Section Content-->
		<div class="row">
			<div class="col-lg-4 ml-auto">
				<p class="lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional SASS stylesheets for easy customization.</p>
			</div>
			<div class="col-lg-4 mr-auto">
				<p class="lead">You can create your own custom avatar for the masthead, change the icon in the dividers, and add your email address to the contact form to make it fully functional!</p>
			</div>
		</div>
		<!-- About Section Button-->
		<div class="text-center mt-4">
			<a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/themes/freelancer/">
				<i class="fas fa-download mr-2"></i>
				Free Download!
			</a>
		</div>
	</div>
</section>
<!-- Contact Section-->
<section class="page-section" id="contact">
	<div class="container">
		<!-- Contact Section Heading-->
		<h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contact Me</h2>
		<!-- Icon Divider-->
		<div class="divider-custom">
			<div class="divider-custom-line"></div>
			<div class="divider-custom-icon"><i class="fas fa-star"></i></div>
			<div class="divider-custom-line"></div>
		</div>
		<!-- Contact Section Form-->
		<div class="row">
			<div class="col-lg-8 mx-auto">
				<?= pear::include('parts/block/form') ?>
			</div>
		</div>
	</div>
</section>


<?= pear::include('parts/block/cabin') ?>
<?= pear::include('parts/block/cake') ?>
<?= pear::include('parts/block/circus') ?>
<?= pear::include('parts/block/game') ?>
<?= pear::include('parts/block/safe') ?>
<?= pear::include('parts/block/submarine') ?>

<?= pear::include('parts/footer') ?>


<?= pear::include('parts/scripts') ?>