<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/like_post.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>posts</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="posts-container">

      <h2 class="heading">latest posts</h2>

      <div class="box-container">

         <?php
         $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE status = ?");
         $select_posts->execute(['active']);
         if ($select_posts->rowCount() > 0) {
            while ($fetch_posts = $select_posts->fetch(PDO::FETCH_ASSOC)) {

               $post_id = $fetch_posts['id'];

               $count_post_comments = $conn->prepare("SELECT * FROM `comments` WHERE post_id = ?");
               $count_post_comments->execute([$post_id]);
               $total_post_comments = $count_post_comments->rowCount();

               $count_post_likes = $conn->prepare("SELECT * FROM `likes` WHERE post_id = ?");
               $count_post_likes->execute([$post_id]);
               $total_post_likes = $count_post_likes->rowCount();

               $confirm_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ? AND post_id = ?");
               $confirm_likes->execute([$user_id, $post_id]);
         ?>
               <form class="box" method="post">
                  <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                  <input type="hidden" name="admin_id" value="<?= $fetch_posts['admin_id']; ?>">
                  <div class="post-admin">
                     <i class="fas fa-user"></i>
                     <div>
                        <a href="author_posts.php?author=<?= $fetch_posts['name']; ?>"><?= $fetch_posts['name']; ?></a>
                        <div><?= $fetch_posts['date']; ?></div>
                     </div>
                  </div>

                  <?php
                  if ($fetch_posts['image'] != '') {
                  ?>
                     <img src="uploaded_img/<?= $fetch_posts['image']; ?>" class="post-image" alt="">
                  <?php
                  }
                  ?>
                  <div class="post-title"><?= $fetch_posts['title']; ?></div>
                  <div class="post-content content-150"><?= $fetch_posts['content']; ?></div>
                  <a href="view_post.php?post_id=<?= $post_id; ?>" class="inline-btn">read more</a>
                  <a href="category.php?category=<?= $fetch_posts['category']; ?>" class="post-cat"> <i class="fas fa-tag"></i> <span><?= $fetch_posts['category']; ?></span></a>
                  <div class="icons">
                     <a href="view_post.php?post_id=<?= $post_id; ?>"><i class="fas fa-comment"></i><span>(<?= $total_post_comments; ?>)</span></a>
                     <button type="submit" name="like_post"><i class="fas fa-heart" style="<?php if ($confirm_likes->rowCount() > 0) {
                                                                                                echo 'color:var(--red);';
                                                                                             } ?>  "></i><span>(<?= $total_post_likes; ?>)</span></button>
                  </div>

               </form>
         <?php
            }
         } else {
            echo '<p class="empty">no posts added yet!</p>';
         }
         ?>
      </div>

   </section>





   <!-- <section class="singlepost">
      <div class="container singlepost__container">
         <h2>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sapiente
            pariatur quibusdam recusandae.
         </h2>
         <div class="post__author">
            <img src="./images/woman.jpg" alt="" />
         </div>
         <div class="post__author-info">
            <h5>By: Elder</h5>
            <small>June 14, 2022 - 07:23</small>
            <div class="singlepost__thumbnail">
               <img src="./images/image4.jpg" alt="" />
            </div>
         </div>
         <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus
            aperiam animi quod autem e aque ducimus quis iste vero odio. Tempore
            totam atque provident in placeat deleniti autem quibusdam iure non
            saepe distinctio pariatur, debitis nobis ut numquam vero excepturi.
            Error.
         </p>
         <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus
            aperiam animi quod autem e aque ducimus quis iste vero odio. Tempore
            totam atque provident in placeat deleniti autem quibusdam iure non
            saepe distinctio pariatur, debitis nobis ut numquam vero excepturi.
            Error.
         </p>
         <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus
            aperiam animi quod autem e aque ducimus quis iste vero odio. Tempore
            totam atque provident in placeat deleniti autem quibusdam iure non
            saepe distinctio pariatur, debitis nobis ut numquam vero excepturi.
            Error.
         </p>
         <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus
            aperiam animi quod autem e aque ducimus quis iste vero odio. Tempore
            totam atque provident in placeat deleniti autem quibusdam iure non
            saepe distinctio pariatur, debitis nobis ut numquam vero excepturi.
            Error.
         </p>
      </div>
   </section> -->













   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>