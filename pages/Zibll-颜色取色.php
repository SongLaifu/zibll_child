<?php
// Template name: Zibll-颜色取色
get_header(); ?>
  <style>
    .color {
      width: 100%;
      height: 680px;
      overflow: hidden;
      overflow-y: scroll
    }

    .container {
      max-width: 60%;
    }
  </style>
  <main class="container">
    <div class="content-wrap">
      <div class="content-layout">
        <iframe class="color" src="<?php echo get_stylesheet_directory_uri() . "/pages/color" ?>" frameborder="0"></iframe>
      </div>
    </div>
  </main>
<?php get_footer(); ?>