<?php
session_start();
include('includes/config.php');
error_reporting(0);
if (strlen($_SESSION['login']) == 0) {
   header('location:index.php');
} else {
   if ($_GET['action'] == 'del' && $_GET['scid']) {
      $id = intval($_GET['scid']);
      $query = mysqli_query($con, "update  tblsubcategory set Is_Active='0' where SubCategoryId='$id'");
      $msg = "Category deleted ";
   }
   // Code for restore
   if ($_GET['resid']) {
      $id = intval($_GET['resid']);
      $query = mysqli_query($con, "update  tblsubcategory set Is_Active='1' where SubCategoryId='$id'");
      $msg = "Category restored successfully";
   }

   // Code for Forever deletionparmdel
   if ($_GET['action'] == 'perdel' && $_GET['scid']) {
      $id = intval($_GET['scid']);
      $query = mysqli_query($con, "delete from   tblsubcategory  where SubCategoryId='$id'");
      $delmsg = "Category deleted forever";
   }

?>

   <?php include('includes/topheader.php'); ?>
   <!-- ========== Left Sidebar Start ========== -->
   <?php include('includes/leftsidebar.php'); ?>
   <!-- Left Sidebar End -->
   <!-- ============================================================== -->
   <!-- Start right Content here -->
   <!-- ============================================================== -->
   <div class="content-page">
      <!-- Start content -->
      <div class="content">
         <div class="container">
            <div class="row">
               <div class="col-xs-12">
                  <div class="page-title-box">
                     <h4 class="page-title">Atur Sub Kategori</h4>
                     <ol class="breadcrumb p-0 m-0">
                        <li>
                           <a href="#">Admin</a>
                        </li>
                        <li>
                           <a href="#">Sub Kategori </a>
                        </li>
                        <li class="active">
                           Atur Sub Kategori
                        </li>
                     </ol>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
            <!-- end row -->
            <div class="row">
               <div class="col-sm-6">
                  <?php if ($msg) { ?>
                     <div class="alert alert-success" role="alert">
                        <strong>Berhasil !</strong> <?php echo htmlentities($msg); ?>
                     </div>
                  <?php } ?>
                  <?php if ($delmsg) { ?>
                     <div class="alert alert-danger" role="alert">
                        <strong>Gagal !</strong> <?php echo htmlentities($delmsg); ?>
                     </div>
                  <?php } ?>
               </div>
               <div class="row">
                  <div class="col-md-12">
                     <div class="demo-box m-t-20">
                        <div class="m-b-30">
                           <a href="add-subcategory.php">
                              <button id="addToTable" class="btn btn-custom waves-effect waves-light btn-md">Tambah <i class="mdi mdi-plus-circle-outline"></i></button>
                           </a>
                        </div>
                        <div class="table-responsive overflow-scrolled">
                           <table class="table m-0 table-bordered" id="example">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th> Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Posting</th>
                                    <th>Tanggal Update Terakhir</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $query = mysqli_query($con, "Select tblcategory.CategoryName as catname,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=1");
                                 $cnt = 1;
                                 $rowcount = mysqli_num_rows($query);
                                 if ($rowcount == 0) {
                                 ?>
                                    <tr>
                                       <td colspan="7" align="center">
                                          <h3 style="color:red">Data Yang Baru Dihapus Tidak Ditemukan!</h3>
                                       </td>
                                    <tr>
                                       <?php
                                    } else {

                                       while ($row = mysqli_fetch_array($query)) {
                                       ?>
                                    <tr>
                                       <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                       <td><?php echo htmlentities($row['catname']); ?></td>
                                       <td><?php echo htmlentities($row['subcatname']); ?></td>
                                       <td><?php echo htmlentities($row['SubCatDescription']); ?></td>
                                       <td><?php echo htmlentities($row['subcatpostingdate']); ?></td>
                                       <td><?php echo htmlentities($row['subcatupdationdate']); ?></td>
                                       <td><a href="edit-subcategory.php?scid=<?php echo htmlentities($row['subcatid']); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                          &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($row['subcatid']); ?>&&action=del" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a>
                                       </td>
                                    </tr>
                              <?php
                                          $cnt++;
                                       }
                                    } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!--- end row -->
               <div class="row">
                  <div class="col-md-12">
                     <div class="demo-box m-t-20">
                        <div class="m-b-30">
                           <h4><i class="fa fa-trash-o"></i> Hapus Sub Kategori</h4>
                        </div>
                        <div class="table-responsive">
                           <table class="table m-0 table-bordered" id="example1">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th> Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Tanggal Posting</th>
                                    <th>Tanggal Update Terakhir</th>
                                    <th>Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $query = mysqli_query($con, "Select tblcategory.CategoryName as catname,tblsubcategory.Subcategory as subcatname,tblsubcategory.SubCatDescription as SubCatDescription,tblsubcategory.PostingDate as subcatpostingdate,tblsubcategory.UpdationDate as subcatupdationdate,tblsubcategory.SubCategoryId as subcatid from tblsubcategory join tblcategory on tblsubcategory.CategoryId=tblcategory.id where tblsubcategory.Is_Active=0");
                                 $cnt = 1;
                                 $rowcount = mysqli_num_rows($query);
                                 if ($rowcount == 0) {
                                 ?>
                                    <tr>
                                       <td colspan="7" align="center">
                                          <h3 style="color:red">Data Yang Baru Dihapus Tidak Ditemukan!</h3>
                                       </td>
                                    <tr>
                                       <?php
                                    } else {

                                       while ($row = mysqli_fetch_array($query)) {
                                       ?>
                                    <tr>
                                       <th scope="row"><?php echo htmlentities($cnt); ?></th>
                                       <td><?php echo htmlentities($row['catname']); ?></td>
                                       <td><?php echo htmlentities($row['subcatname']); ?></td>
                                       <td><?php echo htmlentities($row['SubCatDescription']); ?></td>
                                       <td><?php echo htmlentities($row['subcatpostingdate']); ?></td>
                                       <td><?php echo htmlentities($row['subcatupdationdate']); ?></td>
                                       <td><a href="manage-subcategories.php?resid=<?php echo htmlentities($row['subcatid']); ?>" class="btn btn-primary btn-sm"><i class="ion-arrow-return-right" title="Restore this SubCategory"></i></a>
                                          &nbsp;<a href="manage-subcategories.php?scid=<?php echo htmlentities($row['subcatid']); ?>&&action=perdel" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a>
                                       </td>
                                    </tr>
                              <?php
                                          $cnt++;
                                       }
                                    } ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- container -->
         </div>
         <!-- content -->
         <?php include('includes/footer.php'); ?>
         <!--  Author Name: Mayuri K. 
 for any PHP, Codeignitor, Laravel OR Python work contact me at mayuri.infospace@gmail.com  
 Visit website : www.mayurik.com -->

      <?php } ?>