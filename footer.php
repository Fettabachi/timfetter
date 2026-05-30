		<!-- </div> -->
		</div> <!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
		    <div class="container">
		        <div class="site-footer__inner">
		            <div class="site-footer__brand">
		                <p class="site-footer__name">Tim Fetter</p>
		                <p class="site-footer__summary">
		                    Front-end WordPress developer building practical systems,
		                    reusable components, and interactive prototypes.
		                </p>
		            </div>

		            <div class="site-footer__links">
		                <nav class="site-footer__nav" aria-label="<?php esc_attr_e('Footer navigation', 'base'); ?>">
		                    <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'primary',
                                    'container'      => false,
                                    'menu_class'     => 'site-footer__menu',
                                    'depth'          => 1,
                                )
                            );
                            ?>
		                </nav>

		                <a class="site-footer__email" href="mailto:contact@timfetter.com">
		                    contact@timfetter.com
		                </a>
		            </div>
		        </div>

		        <div class="site-footer__meta">
		            <p>&copy; <?php echo esc_html(date('Y')); ?> Tim Fetter</p>
		        </div>
		    </div>
		</footer><!-- #colophon -->

		</div><!-- #page -->

		<?php wp_footer(); ?>

		</body>

		</html>