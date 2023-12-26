<?php
   session_start();
   include('includes/config.php');
   error_reporting(0);
   if(strlen($_SESSION['login'])==0)
     { 
   header('location:index.php');
   }
   else{
   if( $_GET['disid'])
   {
    $id=intval($_GET['disid']);
    $query=mysqli_query($con,"update tblcomments set status='0' where id='$id'");
    $msg="Comment unapprove ";
   }
   // Code for restore
   if($_GET['appid'])
   {
    $id=intval($_GET['appid']);
    $query=mysqli_query($con,"update tblcomments set status='1' where id='$id'");
    $msg="Comment approved";
   }
   
   // Code for deletion
   if($_GET['action']=='del' && $_GET['rid'])
   {
    $id=intval($_GET['rid']);
    $query=mysqli_query($con,"delete from  tblcomments  where id='$id'");
    $delmsg="Comment deleted forever";
   }
   
   ?>
<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<div class="content-page">
<!-- Start content -->
<div class="content">
<div class="container">
   <div class="row">
      <div class="col-xs-12">
         <div class="page-title-box">
            <h4 class="page-title">Atur Komentar</h4>
            <ol class="breadcrumb p-0 m-0">
               <li>
                  <a href="#">Admin</a>
               </li>
               <li>
                  <a href="#">Komentar </a>
               </li>
               <li class="active">
                  Persetujuan Komentar
               </li>
            </ol>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
   <!-- end row -->
   <div class="row">
      <div class="col-sm-6">
         <?php if($msg){ ?>
         <div class="alert alert-success" role="alert">
            <strong>Berhasil !</strong> <?php echo htmlentities($msg);?>
         </div>
         <?php } ?>
         <?php if($delmsg){ ?>
         <div class="alert alert-danger" role="alert">
            <strong>Gagal !</strong> <?php echo htmlentities($delmsg);?>
         </div>
         <?php } ?>
      </div>
      <div class="row">
         <div class="col-md-12">
            <div class="demo-box m-t-20">
               <div class="table-responsive">
                  <table class="table m-0 table-bordered"  id="example">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th> Nama</th>
                           <th>Id Email</th>
                           <th>Komentar</th>
                           <th>Status</th>
                           <th>Berita</th>
                           <th>Tanggal Posting</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                           $query=mysqli_query($con,"Select tblcomments.id,  tblcomments.name,tblcomments.email,tblcomments.postingDate,tblcomments.comment,tblposts.id as postid,tblposts.PostTitle from  tblcomments join tblposts on tblposts.id=tblcomments.postId where tblcomments.status=1");
                           $cnt=1;
                           while($row=mysqli_fetch_array($query))
                           {
                           ?>
                        <tr>
                           <th scope="row"><?php echo htmlentities($cnt);?></th>
                           <td><?php echo htmlentities($row['name']);?></td>
                           <td><?php echo htmlentities($row['email']);?></td>
                           <td><?php echo htmlentities($row['comment']);?></td>
                           <td><span class="badge badge-secondary"><?php $st=$row['status'];
                              if($st=='0'):
                              echo "Wating for approval";
                              else:
                              echo "Approved";
                              endif;
                              ?></span></td>
                           <td><a href="edit-post.php?pid=<?php echo htmlentities($row['postid']);?>"><?php echo htmlentities($row['PostTitle']);?></a> </td>
                           <td><?php echo htmlentities($row['postingDate']);?></td>
                           <td width="100px">
                              <?php if($st==0):?>
                              <a href="manage-comments.php?disid=<?php echo htmlentities($row['id']);?>" title="Disapprove this comment" class="btn btn-primary btn-sm"><i class="ion-arrow-return-right"></i></a> 
                              <?php else :?>
                              <a class="btn btn-info btn-sm" href="manage-comments.php?appid=<?php echo htmlentities($row['id']);?>" title="Approve this comment"><i class="ion-arrow-return-right"></i></a> 
                              <?php endif;?>
                              &nbsp;<a href="manage-comments.php?rid=<?php echo htmlentities($row['id']);?>&&action=del" class="btn btn-danger btn-sm"> <i class="fa fa-trash-o"></i></a> 
                           </td>
                        </tr>
                        <?php
                           $cnt++;
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
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- container -->
</div>
<!-- content -->
<?php include('includes/footer.php');?>
<?php } ?>