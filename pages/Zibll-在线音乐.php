<?php
// Template name: Zibll-在线音乐
get_header(); ?>
  <style>
    .HeoMusic {
      width: 100%;
      height: 680px;
    }
  </style>
  <main class="container">
    <div class="content-wrap">
      <div class="content-layout">
        <iframe class="HeoMusic" src="<?php echo get_stylesheet_directory_uri() . "/pages/HeoMusic" ?> " frameborder="0"></iframe>
      </div>
    </div>
  </main>
<?php get_footer(); ?>