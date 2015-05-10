<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php 
                switch (true) {
                	case Session::get()->isTeam():
                	$admin_type = '<span class="label label-success">Compte Team</span>';
                	break;
                	case Session::get()->isModerator(): 
                	$admin_type = '<span class="label label-warning">Compte Modo</span>';
                	break;
                	case Session::get()->isAdmin(): 
                	$admin_type = '<span class="label label-danger">Compte Admin</span>';
                	break;
                	default: 
                	$admin_type = '<span class="label label-info" style="background: gray">Hacker</span>';
                	break;
                }
                ?>
                <a class="navbar-brand" href="<?php echo WEBROOT . 'admin'?>">DreamVids - Administration - <?php echo $admin_type; ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo WEBROOT; ?>"><i class="fa fa-arrow-left fa-fw"></i> Accueil</a>
                        </li>
                        <li><a href="<?php echo WEBROOT.'account/infos'; ?>"><i class="fa fa-user fa-fw"></i> Mon compte</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo WEBROOT.'login/signout'; ?>"><i class="fa fa-sign-out fa-fw"></i> Déconnexion</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                        </li> -->
                        <?php 
                        
                        /**
                         * $menu_array is the side menu.
                         * To add an item just add :
                         * 			"<showed name>" => 
                         * 					["icon" => "<font awesome icon>", "url" => "<url> (optional)", "right" => <permission>]
                         * <permission> can be an array like ["modo", "admin"] that is equivalent to the acceptable string "modo_or_more"
                         * Availlable string are located at Utils::generateAdminMenuFromArray() 
                         * Add a "sub-menu" with a sub array that contains what we said before. 
                         */  
                        $menu_array = 
                        [
                        		"Vue d'ensemble" => 
                        			["icon" => "dashboard", "url" => "dashboard"],
                        		
                        		"Statistiques" => 
                        			["icon" => "bar-chart-o", "url" => "statistic", "right" => ["team_or_more"] , "sub-menu" => 
                        					["Contenu" => ["icon" => "align-justify", "url" => "statistic"],
                        					"Accès" => ["icon" => "bar-chart", "url" => "statistic/accesses"],
                        					"Graphiques" => ["icon" => "bar-chart", "url" => "statistic/graph"]
                        					]
                        			],
                        		
                        		
                        		"Modération" => 
                        			["icon" => "smile-o", "right" => ["modo_or_more"], "sub-menu" => 
                        					["Vue d'ensemble" => ["icon" => "dashboard", "url" => "moderation"],
                        					 "Vidéos" => ["icon" => "video-camera", "url" => "moderation/videos"],
                        					 "Commentaires" => ["icon" => "comments", "url" => "moderation/comments"]]
                        			],
                        		"Event" =>
                        			["icon" => "gift", "url" => "egg"],
                        		
                        		"Gestion des utilisateurs" =>
                        			["icon" => "users", "url" => "user", "right" => ["modo_or_more"]],
                        		
                        		"Coordonnées de la team" =>
                        			["icon" => "phone", "url" => "staffContactDetails", "right" => ["team_or_more"]],
                        		
                        		"Gestion des chaînes" => 
                        			["icon" => "sitemap", "url" => "channel", "right" => ["modo_or_more"]],
                        		
                        		"Gestion des vidéos" =>
                        			["icon" => "video-camera", "url" => "videos", "right" => ["modo_or_more"]],
                        		
                        		"Tickets" => 
                        			["icon" => "bug", "url" => "tickets"],
                        		
                        		"Paramètres" =>
                        			["icon" => "wrench", "right" => ["admin"], "sub-menu" =>
                        					["Mise en maintenance" => ["icon" => "plug", "url" => "settings/emergency"],
                        					 "Gestion des admins/modérateurs" => ["icon" => "users", "url" => "settings/users"]]
                        			]
                        ];
                        $menu = Utils::generateAdminMenuFromArray($menu_array, Session::get()); 
                        echo $menu;
                        ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>