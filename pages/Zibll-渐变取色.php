<?php
// Template name: Zibll-渐变取色
get_header(); ?>
  <style>
    .gradient {
      width: 100%;
      height: 680px;
      overflow: hidden;
    }
  </style>
  <main class="container">
    <div class="content-wrap">
      <div class="content-layout">
        <iframe class="gradient" src="<?php echo get_stylesheet_directory_uri() . "/pages/gradient" ?>" frameborder="0"></iframe>
      </div>
    </div>
  </main>
<?php get_footer(); ?>