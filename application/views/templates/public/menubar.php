<div class="container section-header">
    <div class="row">
        <div class="span10 offset1">
            <div class="navbar navbar-static">
                <div class="navbar-inner">
                    <div style="width: auto;" class="container">
                        <div class="row">
                            <div class="span10">
                                <div id="logo"><a href="<?= base_url() ?>" title="Antico Bali Logo"><img src="<?= base_url('assets/img/anticobali-logo.jpg') ?>" title="Antico Bali Logo" alt="Logo" /></a></div>
                                <div id="logo-title"><h1>Bali Antique and Art Store, Indonesia</h1></div>
								<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar collapsed" type="button">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>
								<div class="nav-collapse collapse" role="navigation">
                                <ul class="nav main-menu">
                                    <li class="dropdown">
                                        <a href="<?= base_url() ?>" id="home" role="button" class="dropdown-toggle">Home</a>
                                    </li>
                                    <?php /*<li class="dropdown">
                                        <a href="<?= base_url() ?>collections" id="drop1" role="button" class="dropdown-toggle">Collections</a>
                                    </li> */ ?>
                                    <li class="dropdown">
                                        <a href="<?= base_url() ?>blog" id="drop2" role="button" class="dropdown-toggle">Blog</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="<?= base_url() ?>about_us" id="drop3" role="button" class="dropdown-toggle">About</a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="<?= base_url() ?>contact_us/form" id="drop4" role="button" class="dropdown-toggle">Contact</a>
                                    </li>
                                    <li class="dropdown">
										<a href="ymsgr:SendIM?yudhicrasx"><img src="http://opi.yahoo.com/online?u=yudhicrasx&amp;m=g&amp;t=1" alt="Yahoo messenger" /></a>
                                    </li>									
                                    <?php /*
                                    <li class="dropdown">
                                      <a href="<?= base_url() ?>faq" id="drop4" role="button" class="dropdown-toggle">How To Order</a>
                                    </li> 
									<li class="dropdown">
                                      <a href="<?= base_url() ?>buy" id="drop1" role="button" class="dropdown-toggle">Buy</a>
                                      </li>
                                      <li class="dropdown">
                                      <a href="https://www.facebook.com/" id="drop1" role="button" class="dropdown-toggle">Facebook</a>
                                      </li>
                                      <li class="dropdown">
                                      <a href="<?= base_url() ?>blog" id="drop3" role="button" class="dropdown-toggle">Blog</a>
                                      </li>
                                      <li class="dropdown">
                                      <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">Slider <b class="caret"></b></a>
                                      <ul aria-labelledby="drop2" role="menu" class="dropdown-menu">
                                      <li role="presentation"><a href="<?= base_url() ?>admin/sliders/form" tabindex="-1" role="menuitem">Add Item</a></li>
                                      <li role="presentation"><a href="<?= base_url() ?>admin/sliders" tabindex="-1" role="menuitem">List</a></li>
                                      </ul>
                                      </li> */ ?>
                                    <?php /*
                                      <li class="dropdown">
                                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <b class="caret"></b></a>
                                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                                      <li role="presentation" class="divider"></li>
                                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                                      </ul>
                                      </li> */ ?>
                                </ul>
								</div>
                                <form action="<?= base_url('search') ?>" class="form-search" method="POST">
                                    <div class="input-append input-search">
                                        <input type="text" class="span2 search-query" name="input_keyword" placeholder="Search.." />
                                        <button type="submit" class="btn"><i class="icon-search"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php		
			if (isset($urls)) {
				if ($urls) {
					foreach ($urls->result() as $url) {
						$shorter_link['url'][$url->directlink] = $url->permalink;
					}
				}
			}
			
            if (isset($this->data['categories'])) {
                if (!empty($this->data['categories'])) {
                    ?>
                    <div class="sub-category-wrapper">
					<ul>
                        <?php
                        foreach ($this->data['categories']->result() as $c):
						unset($new_url);
						if (isset($shorter_link) AND (array_key_exists('category/index/'.$c->id_categories, $shorter_link['url']))) {
							$new_url = $shorter_link['url']['category/index/'.$c->id_categories];
						}
                            ?>
                            <li class="sub-menu-title"><a href="<?= isset($new_url) ? base_url($new_url) : base_url('category') . '/index/' . $c->id_categories . '/' . urlSeo($c->category); ?>"><?= $c->category ?></a></li>
                            <?php endforeach; ?>
					</ul>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>