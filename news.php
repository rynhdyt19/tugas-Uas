<?php
session_start();
include('includes/config.php');


$query = mysqli_query($con, "SELECT PostImage FROM tblposts WHERE Is_Active = 1 ORDER BY id DESC LIMIT 3");
$images = array();
while ($row = mysqli_fetch_array($query)) {
   $images[] = $row['PostImage'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Kasitau News | News</title>
   <link rel="icon" type="image/x-icon" href="images/logo-atas.png">

   <!-- Bootstrap core CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <!-- Custom styles for this template -->
   <link href="css/modern-business.css" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/icons.css">
   <link rel="stylesheet" href="css/owl.carousel.min.css">
   <link rel="stylesheet" href="css/owl.theme.default.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body>
   <!-- Navigation -->
   <?php include('includes/header.php'); ?>
   <!-- Page Content -->
   <div class="container-fluid">
      <div class="row" style="margin-top: 4%">
         <!-- Blog Entries Column -->
         <div class="col-md-2 mt-4">
            <!-- Categories Widget -->
            <div class="card my-4 border-0">
               <h5 class="card-header bg-white border-0">Categories</h5>
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <ul class="list-unstyled mb-0">
                           <?php $query = mysqli_query($con, "select id,CategoryName from tblcategory");
                           while ($row = mysqli_fetch_array($query)) {
                           ?>
                              <li class="mb-2">
                                 <a style="text-decoration: none;" href="category.php?catid=<?php echo htmlentities($row['id']) ?>" class="text-secondary"><?php echo htmlentities($row['CategoryName']); ?></a>
                              </li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7">
            <h4 class="widget-title mb-4">Berita Terkini</h4>
            <!-- Blog Post -->
            <div class="row">
               <?php
               if (isset($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
               } else {
                  $pageno = 1;
               }
               $no_of_records_per_page = 8;
               $offset = ($pageno - 1) * $no_of_records_per_page;


               $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
               $result = mysqli_query($con, $total_pages_sql);
               $total_rows = mysqli_fetch_array($result)[0];
               $total_pages = ceil($total_rows / $no_of_records_per_page);


               $query = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
               while ($row = mysqli_fetch_array($query)) {
               ?>
                  <div class="col-md-6">
                     <div class="card mb-4 border-0">
                        <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>" height="200px">
                        <div class="card-body">
                           <p class="m-0">
                              <!--category-->
                              <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid']) ?>" style="color:#fff"><?php echo htmlentities($row['category']); ?></a>
                              <!--Subcategory--->
                              <a class="badge bg-warning text-decoration-none link-light" style="color:#fff"><?php echo htmlentities($row['subcategory']); ?></a>
                           </p>
                           <p class="m-0"><small> Posted on <?php echo htmlentities($row['postingdate']); ?></small></p>
                           <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="card-title text-decoration-none text-dark">
                              <h5 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h5>
                           </a>
                           <!-- <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>" class="">Read More &rarr;</a> -->
                        </div>
                     </div>
                  </div>
               <?php } ?>
               <!-- Static -->
            </div>
         </div>
         <!-- Sidebar Widgets Column -->
         <?php include('includes/sidebar.php'); ?>
      </div>

   </div>
   <!-- /.row -->
   </div>
   <!-- /.container -->
   <!-- Footer -->
   <?php include('includes/footer.php'); ?>
   <!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->
   <script src="js/foot.js"></script>
   <!-- Bootstrap core JavaScript -->
   <script src="vendor/jquery/jquery.min.js"></script>
   <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="js/owl.carousel.min.js"></script>
   <script>
      $('#slider').owlCarousel({
         loop: true,
         margin: 10,
         nav: false,
         dots: false,
         autoplay: true,
         animateOut: 'fadeOut',
         responsive: {
            0: {
               items: 1
            },
            600: {
               items: 1
            },
            1000: {
               items: 1
            }
         }
      });
      $('#slider2').owlCarousel({
         loop: true,
         margin: 10,
         nav: false,
         dots: false,
         autoplay: true,
         animateOut: 'fadeOut',
         responsive: {
            0: {
               items: 1
            },
            600: {
               items: 1
            },
            1000: {
               items: 4
            }
         }
      });
   </script>
</body>

</html>