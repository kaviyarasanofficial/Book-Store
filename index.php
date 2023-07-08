<?php 
session_start();

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = get_all_books($conn);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Book Store</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
	<style>
		body{
			overflow-x:hidden;
		}
    @media only screen and (max-width: 767px) {
        .category {
            display: none;
        }
		.d-flex {
            justify-content: center;
        }
		.navbar-toggler {
            color: white !important;
        }
    }
	.footer {
   
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: black;
   color: white;
   text-align: center;
   height: 300px;
   margin-top:30px;
}
.column {
  float: left;
  width: 33.33%;
  padding: 15px;
  height: 300px; /* Should be removed. Only for demonstration */
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
<body style="background-color:#09144f;">
	<div class="container">
		<div class="logo">
		<img src="img/venthanal-01.png" style="height: 150px; width: 300px; display: block; margin: 30px auto;" alt="வெந்தணல்">

	</div>
	<nav class="navbar navbar-expand-lg navbar-light" style="color: white">
    <div class="container-fluid" >
        <button class="navbar-toggler" style="color: white"  type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span  class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" style="color: white" aria-current="page" href="index.php"><i class="bi bi-house-door-fill"></i> முகப்பு</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href="category.php?id=2"><i class="bi-journal-bookmark"></i> மாதஇதழ்கள்</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href="category.php?id=3"><i class="bi bi-book"></i>  வாரஇதழ்கள்</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href=""><i class="bi-info-square"></i> மேலும்</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a class="nav-link" style="color: white" href="admin.php"><i class="bi bi-person-circle"></i> கட்டுப்பாட்டகம்</a>
                    <?php } else { ?>
                        <a class="nav-link" style="color: white" href="login.php"><i class="bi bi-person-circle"></i> கட்டுப்பாட்டகம்</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<hr style="border-top: 3px solid #f8f8f5ef; width:100%;">

<form action="search.php" method="get" style="width: 100%; max-width: 30rem; margin: 0 auto;">
   



       	<div class="input-group my-5">
		  <input type="text" 
		         class="form-control"
		         name="key" 
		         placeholder="Search Book..." 
		         aria-label="Search Book..." 
		         aria-describedby="basic-addon2">

		  <button class="input-group-text
		                 btn btn-primary" 
		          id="basic-addon2">
		          <img src="img/search.png"
		               width="20">

		  </button>
		</div>
       </form>
		<div class="d-flex pt-3">
			<?php if ($books == 0){ ?>
				<div class="alert alert-warning 
        	            text-center p-5" 
        	     role="alert">
        	     <img src="img/empty.png" 
        	          width="100">
        	     <br>
			    There is no book in the database
		       </div>
			<?php }else{ ?>
			<div class="pdf-list d-flex flex-wrap">
				<?php foreach ($books as $book) { ?>
				<div class="card m-1">
				<img src="uploads/cover/<?=$book['cover']?>" class="card-img-top" style="height: 200px; width: 150px; display: block; margin-left: auto; margin-right: auto;">

					<div class="card-body">
						<h5 class="card-title">
							<?=$book['title']?>
						</h5>
						<p class="card-text">
							<i><b>ஆசிரியர்
								<?php foreach($authors as $author){ 
									if ($author['id'] == $book['author_id']) {
										echo $author['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
							<?=$book['description']?>
							<br><i><b>Category:
								<?php foreach($categories as $category){ 
									if ($category['id'] == $book['category_id']) {
										echo $category['name'];
										break;
									}
								?>

								<?php } ?>
							<br></b></i>
						</p>
                       <a href="uploads/files/<?=$book['file']?>"
                          class="btn btn-success">Open</a>

                        <a href="uploads/files/<?=$book['file']?>"
                          class="btn btn-primary"
                          download="<?=$book['title']?>">Download</a>
					</div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>

		<div class="category" style="padding-left:25px;">
			<!-- List of categories -->
			<div class="list-group">
				<?php if ($categories == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active"> <i class="bi-journal-bookmark"></i> Category</a>
				   <?php foreach ($categories as $category ) {?>
				  
				   <a href="category.php?id=<?=$category['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$category['name']?></a>
				<?php } } ?>
			</div>

			<!-- List of authors -->
			<div class="list-group mt-5" >
				<?php if ($authors == 0){
					// do nothing
				}else{ ?>
				<a href="#"
				   class="list-group-item list-group-item-action active"><i class="bi bi-pen-fill"></i> Author</a>
				   <?php foreach ($authors as $author ) {?>
				  
				   <a href="author.php?id=<?=$author['id']?>"
				      class="list-group-item list-group-item-action">
				      <?=$author['name']?></a>
				<?php } } ?>
			</div>
		</div>
		</div>
	</div>

	<div class="footer">
	<div class="row">
  <div class="column" >
  <h6 class="text-uppercase fw-bold"><i class="bi bi-buildings-fill"></i> வெந்தணல்</h6>
              <hr
                  class="mb-4 mt-0 d-inline-block mx-auto"
                  style="width: 60px; background-color: #7c4dff; height: 2px"
                  />
              <p>
                வெந்தணல் இணையதளம் வழியாக சிறந்த படைப்புகள்
                <br> உங்களிடம் கொண்டு வந்து சேர்க்க படுகிறது
              </p>
  </div>
  <div class="column" >
  <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" style="color: white" aria-current="page" href="index.php"><i class="bi bi-house-door-fill"></i> முகப்பு</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href="category.php?id=2"><i class="bi-journal-bookmark"></i> மாதஇதழ்கள்</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href="category.php?id=3"><i class="bi bi-book"></i>  வாரஇதழ்கள்</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" style="color: white" href=""><i class="bi-info-square"></i> மேலும்</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <a class="nav-link" style="color: white" href="admin.php"><i class="bi bi-person-circle"></i> கட்டுப்பாட்டகம்</a>
                    <?php } else { ?>
                        <a class="nav-link" style="color: white" href="login.php"><i class="bi bi-person-circle"></i> கட்டுப்பாட்டகம்</a>
                    <?php } ?>
                </li>
            </ul><br><br>
			<p>&#10084; Vendanal &#10084;</p>
  </div>
  
  <div class="column" >
  <h6 class="text-uppercase fw-bold"><i class="bi-house-fill"></i> விலாசம் </h6>
              <hr
                  class="mb-4 mt-0 d-inline-block mx-auto"
                  style="width: 60px; background-color: #7c4dff; height: 2px"
                  />
              <p><i class="bi bi-house"></i> வெந்தணல் குடில் </p>
              <p><i class="bi bi-envelope"></i> vendanal@info.com</p>
              <p><i class="bi bi-telephone"></i> 90000 00000</p>
  </div>
</div>

</div>
</body>
</html>