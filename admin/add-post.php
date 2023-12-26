<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
   header('location:index.php');
} else {

   // For adding post  
   if (isset($_POST['submit'])) {
      $posttitle = $_POST['posttitle'];
      $catid = $_POST['category'];
      $subcatid = $_POST['subcategory'];
      $postdetails = $_POST['postdescription'];
      $postedby = $_SESSION['login'];
      $arr = explode(" ", $posttitle);
      $url = implode("-", $arr);
      $imgfile = $_FILES["postimage"]["name"];
      // get the image extension
      $extension = substr($imgfile, strlen($imgfile) - 4, strlen($imgfile));
      // allowed extensions
      $allowed_extensions = array(".jpg", "jpeg", ".png", ".gif");
      // Validation for allowed extensions .in_array() function searches an array for a specific value.
      if (!in_array($extension, $allowed_extensions)) {
         echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
      } else {
         //rename the image file
         $imgnewfile = md5($imgfile) . $extension;
         // Code for move image into directory
         move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

         $status = 1;
         $query = mysqli_query($con, "insert into tblposts(PostTitle,CategoryId,SubCategoryId,PostDetails,PostUrl,Is_Active,PostImage,postedBy) values('$posttitle','$catid','$subcatid','$postdetails','$url','$status','$imgnewfile','$postedby')");
         if ($query) {
            $msg = "Post successfully added ";
         } else {
            $error = "Something went wrong . Please try again.";
         }
      }
   }
?>


   <!-- Top Bar Start -->
   <?php include('includes/topheader.php'); ?>
   <script>
      function getSubCat(val) {
         $.ajax({
            type: "POST",
            url: "get_subcategory.php",
            data: 'catid=' + val,
            success: function(data) {
               $("#subcategory").html(data);
            }
         });
      }
   </script>
   <!-- ========== Left Sidebar Start ========== -->
   <?php include('includes/leftsidebar.php'); ?>
   <div class="content-page">
      <!-- Start content -->
      <div class="content">
         <div class="container">
            <div class="row">
               <div class="col-xs-12">
                  <div class="page-title-box">
                     <h4 class="page-title">Tambah Postingan </h4>
                     <ol class="breadcrumb p-0 m-0">
                        <li>
                           <a href="#">Postingan Berita</a>
                        </li>
                        <li>
                           <a href="#">Tambah Berita </a>
                        </li>
                        <li class="active">
                           Tambah Berita
                        </li>
                     </ol>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
            <!-- end row -->
            <div class="row">
               <div class="col-sm-6">
                  <!---Success Message--->
                  <?php if ($msg) { ?>
                     <div class="alert alert-success" role="alert">
                        <strong>Berhasil!</strong> <?php echo htmlentities($msg); ?>
                     </div>
                  <?php } ?>
                  <!---Error Message--->
                  <?php if ($error) { ?>
                     <div class="alert alert-danger" role="alert">
                        <strong>Gagal !</strong> <?php echo htmlentities($error); ?>
                     </div>
                  <?php } ?>
               </div>
            </div>


            <form name="addpost" method="post" class="row" enctype="multipart/form-data">
               <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Judul Berita</label>
                  <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Masukkan Judul" required>
               </div>
               <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Kategori</label>
                  <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                     <option value="">Pilih Kategori </option>
                     <?php
                     // Feching active categories
                     $ret = mysqli_query($con, "select id,CategoryName from  tblcategory where Is_Active=1");
                     while ($result = mysqli_fetch_array($ret)) {
                     ?>
                        <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="form-group col-md-6">
                  <label for="exampleInputEmail1">Sub Kategori</label>
                  <select class="form-control" name="subcategory" id="subcategory" required>
                  </select>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card-box">
                        <h4 class="m-b-30 m-t-0 header-title"><b>Detail Berita</b></h4>
                        <textarea class="summernote" name="postdescription" required></textarea>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12">
                     <div class="card-box">
                        <h4 class="m-b-30 m-t-0 header-title"><b>Gambar Berita</b></h4>
                        <input type="file" class="form-control" id="postimage" name="postimage" required>
                     </div>
                  </div>
               </div>
               <button type="submit" name="submit" class="btn btn-custom waves-effect waves-light btn-md">Simpan Dan Posting</button>
               <button type="button" class="btn btn-danger waves-effect waves-light">Batal</button>
            </form>

         </div>
         <!-- container -->
      </div>
      <!-- content -->
      <?php include('includes/footer.php'); ?>
      <!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->

   <?php } ?>