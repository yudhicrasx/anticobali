<div class="navbar navbar-static" id="navbar-example">
    <div class="navbar-inner">
        <div style="width: auto;" class="container">
            <a href="<?= base_url() ?>" class="brand">Home</a>
            <ul role="navigation" class="nav">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">Items <b class="caret"></b></a>
                    <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?= base_url() ?>admin/items/form" tabindex="-1" role="menuitem">Add Item</a></li>
                        <li role="presentation"><a href="<?= base_url() ?>admin/items" tabindex="-1" role="menuitem">List</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="<?= base_url() ?>admin/contact_us" id="drop2" role="button" class="dropdown-toggle">Contact Us</b></a>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">Slider <b class="caret"></b></a>
                    <ul aria-labelledby="drop2" role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?= base_url() ?>admin/sliders/form" tabindex="-1" role="menuitem">Add Item</a></li>
                        <li role="presentation"><a href="<?= base_url() ?>admin/sliders" tabindex="-1" role="menuitem">List</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">Category <b class="caret"></b></a>
                    <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?= base_url() ?>admin/categories/form" tabindex="-1" role="menuitem">Add Category</a></li>
                        <li role="presentation"><a href="<?= base_url() ?>admin/categories" tabindex="-1" role="menuitem">List</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" role="button" href="#" id="drop1">Blog <b class="caret"></b></a>
                    <ul aria-labelledby="drop1" role="menu" class="dropdown-menu">
                        <li role="presentation"><a href="<?= base_url() ?>admin/blog/form" tabindex="-1" role="menuitem">Add Blog</a></li>
                        <li role="presentation"><a href="<?= base_url() ?>admin/blog" tabindex="-1" role="menuitem">List</a></li>
                    </ul>
                </li>
                <!--
                <li class="dropdown">
                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">Dropdown 2 <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                      </ul>
                    </li>
                -->
            </ul>
            <ul class="nav pull-right">
                <li><a href="<?=base_url()?>admin/login/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>