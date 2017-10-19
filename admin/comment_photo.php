<?php include("includes/header.php"); ?>
<?php if(!$session->is_signed_in()){redirect("login.php");} ?>

<?php
if(empty($_GET['id'])){
    redirect("photos.php");
}

$comment = Comment::find_the_comments($_GET['id']);
?>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->

    <?php include "includes/top_nav.php" ?>







    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

    <?php include "includes/side_nav.php" ?>




    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Comments
                </h1>
                <p class="bg-success"><?php echo $message; ?></p> 
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Author</th>
                                <th>Body</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php foreach ($comment as $comments) : ?>
                            <tr>
                                <td><?php echo $comments->id; ?></td>
                                <td><?php echo $comments->author; ?>
                                    <div class="action_links">
                                    <a href="delete_comment_photo.php?id=<?php echo $comments->id; ?>">Delete</a>
                                    </div>
                                </td>
                                <td><?php echo $comments->body; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->