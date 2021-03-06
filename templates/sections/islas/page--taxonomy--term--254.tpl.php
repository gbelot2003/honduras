<!-- Bay Islands -->
<!--.page -->
<?php global $base_url; ?>
<div role="document" class="page">

  <!--.l-header region -->
  <header role="banner" class="l-header">
    
    <div id="header-top" class="header-top">
      <div class="row">
        <?php if(isset($icon_using) && isset($facebook_url) || isset($twitter_url) || isset($pinterest_url) || isset($instagram_url)): ?>
          <div id='social-icons' class="list-centered small-12  large-2 columns">
            <ul class="horizontal-list">
              <?php if(isset($facebook_url)): ?>
                <li class="list-inline"><?php print $facebook_url ?></li>
              <?php endif ?>
              
              <?php if(isset($twitter_url)): ?>
                <li class="list-inline"><?php print $twitter_url ?></li>
              <?php endif ?>

              <?php if(isset($pinterest_url)): ?>              
                <li class="list-inline"><?php print $pinterest_url ?></li>
              <?php endif ?>

              <?php if(isset($instagram_url)): ?>
                <li class="list-inline"><?php print $instagram_url ?></li>    
              <?php endif ?>
            </ul>
          </div>
        <?php endif; ?>
        <div id="block-locale-language" class="small-12 large-10 columns">
          <?php print block_render('locale', 'language'); ?>
        </div>
      </div>
    </div>
    
    <?php if ($top_bar): ?>
      <!--.top-bar -->
      <?php if ($top_bar_classes): ?>
      <div class="<?php print $top_bar_classes; ?>">
      <?php endif; ?>
        <nav class="top-bar"<?php print $top_bar_options; ?>>
          <ul class="title-area">
            <li class="name"><h1><?php print $linked_site_name; ?></h1></li>
            <li class="toggle-topbar menu-icon"><a href="#"><span><?php print $top_bar_menu_text; ?></span></a></li>
          </ul>
          <section class="top-bar-section">
            <?php if ($top_bar_secondary_menu) :?>
              <?php print $top_bar_secondary_menu; ?>
            <?php endif; ?>
            <?php if ($top_bar_main_menu) :?>
              <?php print $top_bar_main_menu; ?>
            <?php endif; ?>
          </section>
        </nav>
      <?php if ($top_bar_classes): ?>
      </div>
      <?php endif; ?>
      <!--/.top-bar -->
    <?php endif; ?>

    <!-- Title, slogan and menu -->
    <?php if ($alt_header): ?>
    <section class="row <?php print $alt_header_classes; ?>">

      <?php if ($linked_logo): print $linked_logo; endif; ?>

      <?php if ($site_name): ?>
        <?php if ($title): ?>
          <div id="site-name" class="element-invisible">
            <strong>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
            </strong>
          </div>
        <?php else: /* Use h1 when the content title is empty */ ?>
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
          </h1>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ($site_slogan): ?>
        <h2 title="<?php print $site_slogan; ?>" class="site-slogan"><?php print $site_slogan; ?></h2>
      <?php endif; ?>

      <?php if ($alt_main_menu): ?>
        <nav id="main-menu" class="navigation" role="navigation">
          <?php print ($alt_main_menu); ?>
        </nav> <!-- /#main-menu -->
      <?php endif; ?>

      <?php if ($alt_secondary_menu): ?>
        <nav id="secondary-menu" class="navigation" role="navigation">
          <?php print $alt_secondary_menu; ?>
        </nav> <!-- /#secondary-menu -->
      <?php endif; ?>

    </section>
    <?php endif; ?>
    <!-- End title, slogan and menu -->

    <?php if (!empty($page['header'])): ?>
      <!--.l-header-region -->
      <section class="l-header-region row">
        <div class="large-12 columns">
          <?php print render($page['header']); ?>
        </div>
      </section>
      <!--/.l-header-region -->
    <?php endif; ?>
  </header>
  <!--/.l-header -->

  <div class="l-slider">     
    <div class="front-message">
      <h2 class="front-title"><span class="guara"><?php print t("Explore") ?></span> <span class="mportal"><?php print t("Bay Islands") ?></span></h2>
      <h5 class="portal honduras"><?php print t("Live a new world") ?></h5>
      <div class="hash">
        <div class="row">
          <div class="large-12 columns text-center">
            <?php print render($page['hash']) ?></div>
          </div>
      </div>
    </div>
  </div>


  <?php if (!empty($page['featured'])): ?>
    <!--/.featured -->
    <section class="l-featured row">
      <div class="large-12 columns">
        <?php print render($page['featured']); ?>
      </div>
    </section>
    <!--/.l-featured -->
  <?php endif; ?>

  <?php if (!empty($page['help'])): ?>
    <!--/.l-help -->
    <section class="l-help row">
      <div class="large-12 columns">
        <?php print render($page['help']); ?>
      </div>
    </section>
    <!--/.l-help -->
  <?php endif; ?>

  <!-- /**********  MAIN REGION**************************************************************************************************************** -->
  <!-- /**********  MAIN REGION**************************************************************************************************************** -->
  <!-- /**********  MAIN REGION**************************************************************************************************************** -->
  
  <main role="main" class="row l-main">
    <?php if ($messages && !$zurb_foundation_messages_modal): ?>
    <!--/.l-messages -->
    <section class="l-messages row">
      <div class="large-12 columns">
        <?php if ($messages): print $messages; endif; ?>
      </div>
    </section>
    <!--/.l-messages -->
  <?php endif; ?>
    <div class="<?php print $main_grid; ?> main columns">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlight panel callout">
          <?php print render($page['highlighted']); ?>
        </div>
      <?php endif; ?>

      <a id="main-content"></a>

    

      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
        <?php if (!empty($tabs2)): print render($tabs2); endif; ?>
      <?php endif; ?>

      <?php if ($action_links): ?>
        <ul class="action-links">
          <?php print render($action_links); ?>
        </ul>
      <?php endif; ?>
      
      <div id="l-row-first" class="large-12 columns">
        <div class="row">
          
          <div id="l-row-image" class="large-6 columns">
             <h3 class="page-title front"><?php print t('Destinations') ?></h3>
             <p class="description"><?php print t("Explore and discover Honduras in all it's splendor") ?></p>
			  <?php print render($page['front_first']); ?>
             <div id="link-servicios" class="">
              <h3 class="page-title front"><?php print t("Trusted tourism services lists") ?></h3>
              <p class="description"><?php print  t('You will find all of the certify services to trust as Hotels or transports at Honduras, just fallow the links below') ?></p>
                <ul class="inline">
                  
                  <li class="list-inline">
                    <div class="icon-inside">
                      <a class="hotels" title="<?php print t("List of Hotels at Honduras") ?>" rel="<?php print t('List of Services at Honduras') ?>" target="_blanck" href="<?php print $link_hotels ?>?field_turistic_section_tid=All"><i class="fa-hoteles"></i> <?php print t("Hotels") ?></a>
                    </div>
                  </li>
                  <li class="list-inline">
                    <div class="icon-inside">
                      <a class="restaurants" title="<?php print t("List of Restaurants at Honduras")?>" rel="<?php print t('List of Services at Honduras') ?>" target="_blanck" href="<?php print $link_restaurants ?>?field_turistic_section_tid=All"><i class="fa-restaurantes"></i> <?php print t("Restaurants") ?> </a>
                    </div>
                  </li>
                  <li class="list-inline">
                    <div class="icon-inside">
                      <a class="transport" title="<?php print t("List of Transports at Honduras")?>" rel="<?php print t('List of Services at Honduras') ?>" target="_blanck" href="<?php print $link_transports ?>"><i class="fa-transporte"></i> <?php print t("Transports") ?></a>
                    </div>
                  </li>
                  <li class="list-inline">
                    <div class="icon-inside">
                      <a class="diving" title="<?php print t("List of Diving Centers at Honduras")?>" rel="<?php print t('List of Services at Honduras') ?>" target="_blanck" href="<?php print $link_diving ?>"><i class="fa-buceo"></i> <?php print t("Diving Centers") ?> </a>
                    </div>
                  </li>
                  <li class="list-inline">
                    <div class="icon-inside">
                      <a class="tours" title="<?php print t("List of Tour Operatos at Honduras")?>" rel="<?php print t('List of Services at Honduras') ?>" target="_blanck" href="<?php print $link_tours ?>"><i class="fa-tours"></i> <?php print t("Tour Operators") ?></a>
                    </div>
                  </li>

               </ul>
             </div>
          </div>

          <div id="l-row-news" class="large-6 columns">
            <h3 class="page-title front"><?php print t('News') ?></h3>
            <p class="description"><?php print t('Intresting news and tips for travelers') ?></p>
            <?php print views_embed_view('front_page', $display_id = 'block_4');  ?>
			  <!-- Calendar Block -->
			  <h3 class="page-title front"><?php print t('Calendar Content') ?></h3>
			  <?php print views_embed_view('new_calendar', $display_id = 'block'); ?>
          </div>
        
        </div>

      </div>
      
      <?php print render($page['content']); ?>
    </div>
    <!--/.main region -->
    
    <div id="l-row-secund" class="large-12 columns">
      <?php print render($page['buttom_content']) ?>
    </div>

    <?php if ($messages && $zurb_foundation_messages_modal): print $messages; endif; ?>
  </main>
  <!-- /**********  MAIN REGION**************************************************************************************************************** -->
  <!-- /**********  MAIN REGION**************************************************************************************************************** -->
  <!-- /**********  MAIN REGION**************************************************************************************************************** -->

	<?php if (!empty($page['triptych_first']) || !empty($page['triptych_middle']) || !empty($page['triptych_last'])): ?>
		<!--.triptych-->
		<section class="l-triptych row">
			<div class="triptych-first large-3 small-6 columns">
				<?php print render($page['triptych_first']); ?>
			</div>
			<div class="triptych-middle large-3 small-6 columns">
				<?php print render($page['triptych_middle']); ?>
			</div>
			<div class="triptych-last large-6 small-12 columns">
				<?php print render($page['triptych_last']); ?>
			</div>
		</section>
		<!--/.triptych -->
	<?php endif; ?>
</div>

<div class="l-sub-footer">
    <?php if (!empty($page['footer_firstcolumn']) || !empty($page['footer_secondcolumn']) || !empty($page['footer_thirdcolumn']) || !empty($page['footer_fourthcolumn'])): ?>
    <!--.footer-columns -->
    <section class="row l-footer-columns">
      <?php if (!empty($page['footer_firstcolumn'])): ?>
        <div class="footer-first large-3 columns">
          <?php print render($page['footer_firstcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_secondcolumn'])): ?>
        <div class="footer-second large-3 columns">
          <?php print render($page['footer_secondcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_thirdcolumn'])): ?>
        <div class="footer-third large-3 columns">
          <?php print render($page['footer_thirdcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_fourthcolumn'])): ?>
        <div class="footer-fourth large-3 columns">
          <?php print render($page['footer_fourthcolumn']); ?>
        </div>
      <?php endif; ?>
    </section>
    <!--/.footer-columns-->
  <?php endif; ?>
</div>

<!--.l-footer-->
<footer>
  <div class="l-footer row" role="contentinfo">
    <?php if (!empty($page['footer'])): ?>
      <div class="footer large-12 columns">
        <?php print render($page['footer']); ?>
      </div>
    <?php endif; ?>

    <?php if ($site_name) :?>
      <div class="copyright large-10 columns">
        &copy; <?php print date('Y') . ' ' . "CANATURH" . ' ' . t('All rights reserved.'); ?>
      </div>
    <?php endif; ?>

    <div class="l-marca large-2 columns">
      <img src="<?php print $base_url . '/' . drupal_get_path('theme', 'honduras'); ?>/images/marca1.png">
    </div>

    <?php if(!empty($page['menu_footer'])): ?>
      <div class="large-12 columns menu-footer">
        <?php print render($page['menu_footer']); ?>
      </div>
    <?php endif; ?>
  </div>

</footer>
  <!--/.footer-->
<!--/.page -->
